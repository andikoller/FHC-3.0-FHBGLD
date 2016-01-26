<?php
/* Copyright (C) 2010 Technikum-Wien
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
 *
 * Authors: Christian Paminger 		<christian.paminger@technikum-wien.at>,
 *          Andreas Oesterreicher 	<andreas.oesterreicher@technikum-wien.at>,
 *          Rudolf Hangl 			<rudolf.hangl@technikum-wien.at> and
 *			Gerald Simane-Sequens 	<gerald.simane-sequens@technikum-wien.at>
 */
require_once('../../config/wawi.config.inc.php');
require_once('../../include/basis_db.class.php');
require_once('../../include/mail.class.php');
	
if (!$db = new basis_db())
	die('Fehler beim Herstellen der Datenbankverbindung');

if (!$conn_wawi = pg_pconnect(CONN_STRING_WAWI)) 
   	die('Es konnte keine Verbindung zum Server aufgebaut werden.   *** File:='.__FILE__.' Line:='.__LINE__."\n");
			
$error_log='';
$firma_synced='';
$firma_synced1='';
$upd_log='';
$text = '';
$anzahl_quelle=0;
$anzahl_insert=0;
$anzahl_update=0;
$anzahl_delete=0;
$anzahl_fehler=0;
$ausgabe='';
$ausgabe_adresse='';
$update=false;
$rollback=false;
$akt_firma_id='';
$mail='';

?>
<html>
<head>
<title>Synchro - WaWi -&gt; FAS - Firma</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
$qry="
	SET CLIENT_ENCODING TO UNICODE; 
	SELECT 
		*, firma.email as firma_email, username_neu as username 
	FROM 
		firma LEFT JOIN benutzer on(firma.luser=user_id) 
	ORDER BY firma_id
	";
if($result=pg_query($conn_wawi, $qry))
{

	$anzahl_quelle=pg_num_rows($result);
	
	while($row = pg_fetch_object($result))
	{
		//check, ob firma bereits übertragen
		$qry_check="SELECT * FROM public.tbl_firma WHERE ext_id='".addslashes($row->firma_id)."'";
		if($result_check=$db->db_query($qry_check))
		{
			if($row->username=='' || $row->username==NULL)
			{
				$row->username="WaWiSync";
			}
			if($db->db_num_rows($result_check)>0)
			{
				//Firma vorhanden - Änderungen im WaWi?
				$upd_log.=$row->firma_id.", ".$row->firmenname."\n";
				if($row_firma=$db->db_fetch_object($result_check))
				{
					if($row_firma->name!=$row->firmenname)
					{
						$upd_log.="Änderung Firmenname von '".$row_firma->name."' auf '".$row->firmenname."'\n";
						$update=true;
					}
					if($row_firma->anmerkung!=($row->anmerkung."\nAnsprechpartner:".$row->ansprechpartner))
					{
						$upd_log.="Änderung Firma Anmerkung von '".$row_firma->anmerkung."' auf '".$row->anmerkung."\nAnsprechpartner:".$row->ansprechpartner."'\n";
						$update=true;
					}
					$akt_firma_id=$row_firma->firma_id;
					if($update)
					{
						$firma_upd="UPDATE public.tbl_firma SET 
						name=".$db->addslashes($row->firmenname).", 
						anmerkung=".$db->addslashes($row->anmerkung."\nAnsprechpartner:".$row->ansprechpartner).", 
						updatevon=".$db->addslashes($row->username).", 
						updateamum=".$db->addslashes($row->lupdate)." 
						WHERE ext_id='".addslashes($row->firma_id)."'";
						if(!$db->db_query($firma_upd))
						{
							$anzahl_fehler++;
							$error_log.="Firma konnte nicht upgedated werden.\n".$firma_upd."\n";
						}
						$update=false;
						$anzahl_update++;
					}	
				}
				else
				{
					$error_log.="Fehler beim Laden Firma: \n".$qry_check."\n";
					continue;	
				}
				//Änderung firma-organisationseinheit
				$fiorgeh_sel="SELECT * FROM public.tbl_firma_organisationseinheit WHERE firma_id='".addslashes($row_firma->firma_id)."'";
				if($result_fiorgeh=$db->db_query($fiorgeh_sel))
				{
					if($db->db_num_rows($result_fiorgeh)>0)
					{
						//Delete
						if($row->kundennr=='' || $row->kundennr==NULL)
						{
							$fiorgeh_del="DELETE FROM public.tbl_firma_organisationseinheit 
								WHERE firma_id='".addslashes($row_firma->firma_id)."'";
							if(!$db->db_query($fiorgeh_del))
							{
								$anzahl_fehler++;
								$error_log.="Firma_Organisationseinheit konnte nicht gelöscht werden.\n".$fiorgeh_del."\n";
							}
							else 
							{
								$anzahl_delete++;
								$upd_log.="Firma_Organisationseinheit wurde gelöscht!\n";	
							}
						}
						//Update
						elseif($row_fiorgeh=$db->db_fetch_object($result_fiorgeh))
						{
							if($row_fiorgeh->kundennummer!=$row->kundennr)
							{
								$upd_log.="Änderung Kundennummer von '".$row_fiorgeh->kundennummer."' auf '".$row->kundennr."'\n";
								$update=true;
							}
							if($update)
							{
								$firma_orgeinheit_upd="UPDATE public.tbl_firma_organisationseinheit SET 
								kundennummer=".$db->addslashes($row->kundennr)."
								WHERE firma_id='".addslashes($row_firma->firma_id)."'";
								if(!$db->db_query($firma_orgeinheit_upd))
								{
									$anzahl_fehler++;
									$error_log.="Firma_Organisationseinheit konnte nicht upgedated werden.\n".$firma_orgeinheit_upd."\n";
								}
								else
								{
									$anzahl_update++;
								}
							}
							$update=false;
						}	
					}
					else 
					{
						if($row->kundennr!='' && $row->kundennr!=NULL)
						{
							//Insert
							$firma_orgeinheit_ins="INSERT INTO public.tbl_firma_organisationseinheit 
								(firma_id, oe_kurzbz, kundennummer, insertvon, insertamum) VALUES 
								(".$db->addslashes($akt_firma_id).", 'etw', ".$db->addslashes($row->kundennr).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
							if(!$db->db_query($firma_orgeinheit_ins))
							{	
								$anzahl_fehler++;
								$error_log.="Firma_Organisationseinheit konnte nicht angelegt werden.\n".$firma_orgeinheit_ins."\n";
							}
							else 
							{
								$anzahl_insert++;
								$upd_log.="Firma_organisationseinheit mit Kundennummer '".$row->kundennr."' neu angelegt.\n";	
							}
						}
					}	
				}
				//Änderung bei Standort
				$standort_sel="SELECT * FROM public.tbl_standort WHERE firma_id='".addslashes($row_firma->firma_id)."'";
				if($result_standort=$db->db_query($standort_sel))
				{
					if($db->db_num_rows($result_standort)>0)
					{
						//Update
						if($row_standort=$db->db_fetch_object($result_standort))
						{
							if($row_standort->kurzbz!=$row->kurzbezeichnung)
							{
								$upd_log.="Änderung Standort Kurzbezeichnung von '".$row_standort->kurzbz."' auf '".$row->kurzbezeichnung."'\n";
								$update=true;
							}
							if($row_standort->bezeichnung!=$row->firmenname)
							{
								$upd_log.="Änderung Standort Firmenname von '".$row_standort->bezeichnung."' auf '".$row->firmenname."'\n";
								$update=true;
							}
							if($update)
							{
								$standort_upd="UPDATE public.tbl_standort SET kurzbz=".$db->addslashes($row->kurzbezeichnung).", bezeichnung=".$db->addslashes($row->firmenname)." 
								WHERE firma_id='".addslashes($row_firma->firma_id)."'";
								if(!$db->db_query($standort_upd))
								{
									$anzahl_fehler++;
									$error_log.="Standort konnte nicht upgedated werden.\n".$standort_upd."\n";
								}
								else
								{
									$anzahl_update++;
								}
							}
							$update=false;
							$akt_standort_id=$row_standort->standort_id;
							$akt_adresse_id=$row_standort->adresse_id;
						}	
						//Adresse -- hängt an tbl_standort
						$adresse_sel="SELECT * FROM public.tbl_adresse WHERE adresse_id=".$db->addslashes($akt_adresse_id);
						if($result_adresse=$db->db_query($adresse_sel))
						{
							if($db->db_num_rows($result_adresse)>0)
							{
								if(($row->strasse=='' || $row->strasse==NULL) && ($row->plz=='' || $row->plz==NULL) && ($row->ort=='' || $row->ort==NULL))
								{
									//Delete Adresse
									//adresse_id aus standort entfernen
									$standort_sel="SELECT * FROM public.tbl_standort WHERE firma_id='".addslashes($row_firma->firma_id)."'";
									
									$standort_upd="UPDATE public.tbl_standort SET adresse_id=NULL WHERE firma_id='".addslashes($row_firma->firma_id)."'";
									if(!$db->db_query($standort_upd))
									{
										$anzahl_fehler++;
										$error_log.="Standort konnte nicht upgedated werden.\n".$standort_upd."\n";
									}
									else 
									{
										$anzahl_update++;
										$upd_log.="Standort wurde gelöscht!\n".$standort_upd."\n";
									}
									
									$adresse_del="DELETE FROM public.tbl_adresse WHERE adresse_id=".$db->addslashes($akt_adresse_id);
									if(!$db->db_query($adresse_del))
									{
										$anzahl_fehler++;
										$error_log.="Adresse konnte nicht gelöscht werden.\n".$adresse_del."\n";
									}
									else 
									{
										$anzahl_delete++;
										$upd_log.="Adresse wurde gelöscht!\n".$adresse_del."\n";	
									}
								}
								//Update
								elseif($row_adresse=$db->db_fetch_object($result_adresse))
								{
									if($row_adresse->strasse!=$row->strasse)
									{
										$upd_log.="Änderung Adresse - Strasse von '".$row_adresse->strasse."' auf'".$row->strasse."'\n";
										$update=true;
									}
									if($row_adresse->plz!=$row->plz)
									{
										$upd_log.="Änderung Adresse - Plz von '".$row_adresse->plz."' auf'".$row->plz."'\n";
										$update=true;
									}
									if($row_adresse->ort!=$row->ort)
									{
										$upd_log.="Änderung Adresse - Ort von '".$row_adresse->ort."' auf'".$row->ort."'\n";
										$update=true;
									}
									if($row_adresse->gemeinde!=$row->ort)
									{
										$upd_log.="Änderung Adresse - Gemeinde von '".$row_adresse->gemeinde."' auf'".$row->ort."'\n";
										$update=true;
									}
									if($update)
									{
										$adresse_upd="UPDATE public.tbl_adresse SET 
											strasse=".$db->addslashes($row->strasse).", 
											plz=".$db->addslashes($row->plz).", 
											ort=".$db->addslashes($row->ort).", 
											gemeinde=".$db->addslashes($row->ort)." 
											WHERE adresse_id=".$db->addslashes($akt_adresse_id);
										if(!$db->db_query($adresse_upd))
										{
											$anzahl_fehler++;
											$error_log.="Adresse konnte nicht upgedated werden.\n".$adresse_upd."\n";
										}
										else
										{
											$anzahl_update++;
										}
									}
									$update=false;
								}	
							}
							else 
							{
								if(($row->strasse!='' && $row->strasse!=NULL) || ($row->plz!='' && $row->plz!=NULL) || ($row->ort!='' && $row->ort!=NULL))
								{
									//Insert
									$adresse_ins="INSERT INTO public.tbl_adresse 
										(strasse, plz, ort, gemeinde, typ, heimatadresse, zustelladresse, insertvon, insertamum) VALUES 
										(".$db->addslashes($row->strasse).", ".$db->addslashes($row->plz).", ".$db->addslashes($row->ort).", ".$db->addslashes($row->ort).", 'f', false, false, ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
									if(!$db->db_query($adresse_ins))
									{	
										$rollback=true;
										$anzahl_fehler++;
										$error_log.="Adresse konnte nicht angelegt werden.\n".$adresse_ins."\n";
									}
									else 
									{
										$anzahl_insert++;
										$qryu = "SELECT currval('public.tbl_adresse_adresse_id_seq') AS id;";
										if($rowu=$db->db_fetch_object($db->db_query($qryu)))
											$akt_adresse_id=$rowu->id;
										else
										{
											$anzahl_fehler++;
											$error_log.="Adresse-Sequence konnte nicht ausgelesen werden.\n";
											$akt_adresse_id=NULL;
										}
										$standort_upd="UPDATE public.tbl_standort SET 
										adresse_id=".$db->addslashes($akt_adresse_id)." 
										WHERE firma_id='".addslashes($row_firma->firma_id)."'";
										if($db->db_query($standort_upd))
										{
											$anzahl_update++;
											$upd_log.="Adresse mit Strasse '".$row->strasse."', '".$row->plz."' und '".$row->ort."' neu angelegt.\n";
										}
										else
										{
											$anzahl_fehler++;
										}	
									}
								}
							}
						}
					}
					else 
					{
						//Insert Standort
						//Adresse -- hängt an tbl_standort
						$adresse_sel="SELECT * FROM public.tbl_adresse WHERE adresse_id=".$db->addslashes($akt_adresse_id);
						if($result_adresse=$db->db_query($adresse_sel))
						{
							if($db->db_num_rows($result_adresse)>0)
							{
								if($row_adresse=$db->db_fetch_object($result_adresse))
								{
									if($row_adresse->strasse!=$row->strasse)
									{
										$upd_log.="Änderung Adresse - Strasse von '".$row_adresse->strasse."' auf'".$row->strasse."'\n";
										$update=true;
									}
									if($row_adresse->plz!=$row->plz)
									{
										$upd_log.="Änderung Adresse - Plz von '".$row_adresse->plz."' auf'".$row->plz."'\n";
										$update=true;
									}
									if($row_adresse->ort!=$row->ort)
									{
										$upd_log.="Änderung Adresse - Ort von '".$row_adresse->ort."' auf'".$row->ort."'\n";
										$update=true;
									}
									if($row_adresse->gemeinde!=$row->ort)
									{
										$upd_log.="Änderung Adresse - Gemeinde von '".$row_adresse->gemeinde."' auf'".$row->ort."'\n";
										$update=true;
									}
									if($update)
									{
										$anzahl_update++;
										$telefon_upd="UPDATE public.tbl_adressse SET 
											strasse=".$db->addslashes($row->strasse).", 
											plz=".$db->addslashes($row->plz).", 
											ort=".$db->addslashes($row->ort).", 
											gemeinde=".$db->addslashes($row->gemeinde)." 
											WHERE adresse_id=".$db->addslashes($akt_adresse_id);
										if(!$db->db_query($adresse_upd))
										{
											$anzahl_fehler++;
											$error_log.="Adresse konnte nicht upgedated werden.\n".$adresse_upd."\n";
										}
										else
										{
											$anzahl_update++;
										}
									}
									$update=false;
									$akt_adresse_id=$row_adresse->adresse_id;
								}	
							}
							else 
							{
								if(($row->strasse!='' && $row->strasse!=NULL) || ($row->plz!='' && $row->plz!=NULL) || ($row->ort!='' && $row->ort!=NULL))
								{
									//Insert
									$adresse_ins="INSERT INTO public.tbl_adresse 
										(strasse, plz, ort, gemeinde, typ, heimatadresse, zustelladresse, insertvon, insertamum) VALUES 
										(".$db->addslashes($row->strasse).", ".$db->addslashes($row->plz).", ".$db->addslashes($row->ort).", ".$db->addslashes($row->ort).", 'f', false, false, ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
									if(!$db->db_query($adresse_ins))
									{	
										//$rollback=true;
										$anzahl_fehler++;
										$error_log.="Adresse konnte nicht angelegt werden.\n".$adresse_ins."\n";
										$akt_adresse_id=NULL;
									}
									else 
									{
										$anzahl_insert++;
										$upd_log.="Adresse mit Strasse '".$row->strasse."', '".$row->plz."' und '".$row->ort."' neu angelegt.(2)\n";
										$qryu = "SELECT currval('public.tbl_adresse_adresse_id_seq') AS id;";
										if($rowu=$db->db_fetch_object($db->db_query($qryu)))
											$akt_adresse_id=$rowu->id;
										else
										{
											$anzahl_fehler++;
											$error_log.="Adresse-Sequence konnte nicht ausgelesen werden.\n";
											$akt_adresse_id=NULL;
										}	
									}
								}
								else 
								{
									$akt_adresse_id=NULL;
								}
							}
						}
						$standort_ins="INSERT INTO public.tbl_standort 
							(kurzbz, adresse_id, bezeichnung, firma_id, insertvon, insertamum) VALUES 
							(".$db->addslashes($row->kurzbezeichnung).", ".$db->addslashes($akt_adresse_id).", ".$db->addslashes($row->firmenname).", ".$db->addslashes($akt_firma_id).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
						if(!$db->db_query($standort_ins))
						{	
							$anzahl_fehler++;
							$error_log.="Standort konnte nicht angelegt werden.\n".$standort_ins."\n";
						}
						else 
						{
							$anzahl_insert++;
							$upd_log.="Standort mit Kurzbezeichnung '".$row->kurzbezeichnung."' und Firmenname '".$row->firmenname."' neu angelegt.\n";	
						}
						$qryu = "SELECT currval('public.tbl_standort_standort_id_seq') AS id;";
						if($rowu=$db->db_fetch_object($db->db_query($qryu)))
							$akt_standort_id=$rowu->id;
						else
						{
							$anzahl_fehler++;
							$error_log.="Standort-Sequence konnte nicht ausgelesen werden.\n";
						}
					}
				}
				//Änderungen bei Kontakte
				//Telefon
				$telefon_sel="SELECT * FROM public.tbl_kontakt WHERE kontakttyp='telefon' AND standort_id=".$db->addslashes($akt_standort_id);
				if($result_telefon=$db->db_query($telefon_sel))
				{
					if($db->db_num_rows($result_telefon)>0)
					{
						//Delete
						if($row->telefon=='' || $row->telefon==NULL)
						{
							$telefon_del="DELETE FROM public.tbl_kontakt 
								WHERE kontakttyp='telefon' AND standort_id=".$db->addslashes($akt_standort_id);
							if(!$db->db_query($telefon_del))
							{
								$anzahl_fehler++;
								$error_log.="Telefon-Kontakt konnte nicht gelöscht werden.\n".$telefon_del."\n";
							}
							else 
							{
								$anzahl_delete++;
								$upd_log.="Telefon-Kontakt wurde gelöscht!\n";	
							}
						}
						//Update
						elseif($row_telefon=$db->db_fetch_object($result_telefon))
						{
							if($row_telefon->kontakt!=$row->telefon)
							{
								$upd_log.="Änderung Telefon von '".$row_telefon->kontakt."' auf'".$row->telefon."'\n";
								$update=true;
							}
							if($update)
							{
								$telefon_upd="UPDATE public.tbl_kontakt SET 
									kontakt=".$db->addslashes($row->telefon)." 
									WHERE kontakttyp='telefon' AND standort_id=".$db->addslashes($akt_standort_id);
								if(!$db->db_query($telefon_upd))
								{
									$anzahl_fehler++;
									$error_log.="Telefon-Kontakt konnte nicht upgedated werden.\n".$telefon_upd."\n";
								}
								else
								{
									$anzahl_update++;
								}
							}
							$update=false;
						}	
					}
					else 
					{
						if($row->telefon!='' && $row->telefon!=NULL)
						{
							//Insert
							$telefon_ins="INSERT INTO public.tbl_kontakt 
								(kontakttyp, kontakt, zustellung, standort_id, insertvon, insertamum) VALUES 
								('telefon', ".$db->addslashes($row->telefon).", false, ".$db->addslashes($akt_standort_id).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
							if(!$db->db_query($telefon_ins))
							{	
								$rollback=true;
								$anzahl_fehler++;
								$error_log.="Telefon-Kontakt konnte nicht angelegt werden.\n".$telefon_ins."\n";						
							}
							else 
							{
								$anzahl_insert++;
								$upd_log.="Telefon-Kontakt mit Nummer '".$row->telefon."' neu angelegt.\n";	
							}
						}
					}
				}
				//Telefax
				$telefax_sel="SELECT * FROM public.tbl_kontakt WHERE kontakttyp='fax' AND standort_id=".$db->addslashes($akt_standort_id);
				if($result_telefax=$db->db_query($telefax_sel))
				{
					if($db->db_num_rows($result_telefax)>0)
					{
						//Delete
						if($row->telefax=='' || $row->telefax==NULL)
						{
							$telefax_del="DELETE FROM public.tbl_kontakt 
								WHERE kontakttyp='fax' AND standort_id=".$db->addslashes($akt_standort_id);
							if(!$db->db_query($telefax_del))
							{
								$anzahl_fehler++;
								$error_log.="Telefax-Kontakt konnte nicht gelöscht werden.\n".$telefax_del."\n";
							}
							else 
							{
								$anzahl_delete++;
								$upd_log.="Telefax-Kontakt wurde gelöscht!\n";	
							}
						}
						//Update
						elseif($row_telefax=$db->db_fetch_object($result_telefax))
						{
							if($row_telefax->kontakt!=$row->telefax)
							{
								$upd_log.="Änderung Telefax von '".$row_telefax->kontakt."' auf'".$row->telefax."'\n";
								$update=true;
							}
							if($update)
							{
								$telefax_upd="UPDATE public.tbl_kontakt SET 
									kontakt=".$db->addslashes($row->telefax)." 
									WHERE kontakttyp='fax' AND standort_id=".$db->addslashes($akt_standort_id);
								if(!$db->db_query($telefax_upd))
								{
									$anzahl_fehler++;
									$error_log.="Telefax-Kontakt konnte nicht upgedated werden.\n".$telefax_upd."\n";
								}
								else
								{
									$anzahl_update++;
								}
							}
							$update=false;
						}	
					}
					else 
					{
						if($row->telefax!='' && $row->telefax!=NULL)
						{
							//Insert
							$telefax_ins="INSERT INTO public.tbl_kontakt 
								(kontakttyp, kontakt, zustellung, standort_id, insertvon, insertamum) VALUES 
								('fax', ".$db->addslashes($row->telefax).", false, ".$db->addslashes($akt_standort_id).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
							if(!$db->db_query($telefax_ins))
							{	
								$rollback=true;
								$anzahl_fehler++;
								$error_log.="Telefax-Kontakt konnte nicht angelegt werden.\n".$telefax_ins."\n";
							}
							else 
							{
								$anzahl_insert++;
								$upd_log.="Telefax-Kontakt mit Nummer '".$row->telefax."' neu angelegt.\n";	
							}
						}
					}
				}
				//E-Mail
				$email_sel="SELECT * FROM public.tbl_kontakt WHERE kontakttyp='email' AND standort_id=".$db->addslashes($akt_standort_id);
				if($result_email=$db->db_query($email_sel))
				{
					if($db->db_num_rows($result_email)>0)
					{
						//Delete
						if($row->firma_email=='' || $row->firma_email==NULL)
						{
							$email_del="DELETE FROM public.tbl_kontakt 
								WHERE kontakttyp='email' AND standort_id=".$db->addslashes($akt_standort_id);
							if(!$db->db_query($email_del))
							{
								$anzahl_fehler++;
								$error_log.="E-Mail-Kontakt konnte nicht gelöscht werden.\n".$email_del."\n";
							}
							else 
							{
								$anzahl_delete++;
								$upd_log.="E-Mail-Kontakt wurde gelöscht!\n";	
							}
						}
						//Update
						elseif($row_email=$db->db_fetch_object($result_email))
						{
							if($row_email->kontakt!=$row->firma_email)
							{
								if(strstr($row->firma_email, '@'))
								{
									$upd_log.="Änderung E-Mail von '".$row_email->kontakt."' auf '".$row->firma_email."'\n";
									$update=true;
								}
							}
							if($update)
							{
								$email_upd="UPDATE public.tbl_kontakt SET 
									kontakt=".$db->addslashes($row->firma_email)." 
									WHERE kontakttyp='email' AND standort_id=".$db->addslashes($akt_standort_id);
								if(!$db->db_query($email_upd))
								{
									$anzahl_fehler++;
									$error_log.="E-Mail-Kontakt konnte nicht upgedated werden.\n".$email_upd."\n";
								}
								else
								{
									$anzahl_update++;
								}
							}
							$update=false;
						}	
					}
					else 
					{
						if($row->firma_email!='' && $row->firma_email!=NULL)
						{
							//Insert
							$email_ins="INSERT INTO public.tbl_kontakt 
								(kontakttyp, kontakt, zustellung, standort_id, insertvon, insertamum) VALUES 
								('email', ".$db->addslashes($row->firma_email).", false, ".$db->addslashes($akt_standort_id).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
							if(!$db->db_query($email_ins))
							{	
								$anzahl_fehler++;
								$error_log.="E-Mail-Kontakt konnte nicht angelegt werden.\n".$email_ins."\n";
							}
							else 
							{
								$anzahl_insert++;
								$upd_log.="E-Mail-Kontakt '".$row->firma_email."' neu angelegt.\n";	
							}
						}
					}
				}
				//Homepage
				$homepage_sel="SELECT * FROM public.tbl_kontakt WHERE kontakttyp='homepage' AND standort_id=".$db->addslashes($akt_standort_id);
				if($result_homepage=$db->db_query($homepage_sel))
				{
					if($db->db_num_rows($result_homepage)>0)
					{
						//Delete
						if($row->homepage=='' || $row->homepage==NULL)
						{
							$homepage_del="DELETE FROM public.tbl_kontakt 
								WHERE kontakttyp='homepage' AND standort_id=".$db->addslashes($akt_standort_id);
							if(!$db->db_query($homepage_del))
							{
								$anzahl_fehler++;
								$error_log.="Homepage-Kontakt konnte nicht gelöscht werden.\n".$homepage_del."\n";
							}
							else 
							{
								$anzahl_delete++;
								$upd_log.="Homepage wurde gelöscht!\n";	
							}
						}
						//Update
						elseif($row_homepage=$db->db_fetch_object($result_homepage))
						{
							if($row_homepage->kontakt!=$row->homepage)
							{
								$upd_log.="Änderung Homepage von '".$row_homepage->kontakt."' auf '".$row->homepage."'\n";
								$update=true;
							}
							if($update)
							{
								$homepage_upd="UPDATE public.tbl_kontakt SET 
									kontakt=".$db->addslashes($row->firma_email)." 
									WHERE kontakttyp='homepage' AND standort_id=".$db->addslashes($akt_standort_id);
								if(!$db->db_query($homepage_upd))
								{
									$anzahl_fehler++;
									$error_log.="Homepage-Kontakt konnte nicht upgedated werden.\n".$homepage_upd."\n";
								}
								else
								{
									$anzahl_update++;
								}
							}
							$update=false;
						}	
					}
					else 
					{
						if($row->homepage!='' && $row->homepage!=NULL)
						{
							//Insert
							$homepage_ins="INSERT INTO public.tbl_kontakt 
								(kontakttyp, kontakt, zustellung, standort_id, insertvon, insertamum) VALUES 
								('homepage', ".$db->addslashes($row->homepage).", false, ".$db->addslashes($akt_standort_id).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
							if(!$db->db_query($homepage_ins))
							{	
								$anzahl_fehler++;
								$error_log.="Homepage-Kontakt konnte nicht angelegt werden.\n".$homepage_ins."\n";
							}
							else 
							{
								$anzahl_insert++;
								$upd_log.="Homepage-Kontakt '".$row->telefon."' neu angelegt.\n";	
							}
						}
					}
				}
			}
			else 
			{
				//Wenn firma noch nicht vorhanden
				$firma_synced.="\n";
				$error_log.="\n";
				$rollback=false;
				$db->db_query('BEGIN');
				$firma_ins="INSERT INTO public.tbl_firma 
					(name, anmerkung, firmentyp_kurzbz, schule, steuernummer, gesperrt, aktiv, finanzamt, insertvon, insertamum, ext_id) VALUES
					(".$db->addslashes($row->firmenname).", ".$db->addslashes($row->anmerkung."\nAnsprechpartner:".$row->ansprechpartner).", 'Firma', false, NULL, false, true, NULL, ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).", ".$db->addslashes($row->firma_id).")";
				if(!$db->db_query($firma_ins))
				{	
					$rollback=true;
					$anzahl_fehler++;
					$error_log.="Firma konnte nicht angelegt werden.\n".$firma_ins."\n";
				}
				else 
				{
					$anzahl_insert++;
					$firma_synced.=$row->firma_id.", ".$row->firmenname."\n";
				}

				//Kundennummer in tbl_firma_organisationseinheit
				$qryu = "SELECT currval('public.tbl_firma_firma_id_seq') AS id;";
				if($rowu=$db->db_fetch_object($db->db_query($qryu)))
					$akt_firma_id=$rowu->id;
				else
				{
					$rollback=true;
					$anzahl_fehler++;
					$error_log.="Firma-Sequence konnte nicht ausgelesen werden.\n";
				}
				$firma_orgeinheit_ins="INSERT INTO public.tbl_firma_organisationseinheit 
					(firma_id, oe_kurzbz, kundennummer, insertvon, insertamum) VALUES 
					(".$db->addslashes($akt_firma_id).", 'etw', ".$db->addslashes($row->kundennr).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
				if(!$db->db_query($firma_orgeinheit_ins))
				{	
					$rollback=true;
					$error_log.="Firma_Organisationseinheit konnte nicht angelegt werden.\n".$firma_orgeinheit_ins."\n";
				}
				else
				{
					$anzahl_insert++;
				}
				//Adresse -- hängt an tbl_standort
				$adresse_ins="INSERT INTO public.tbl_adresse 
					(strasse, plz, ort, gemeinde, typ, heimatadresse, zustelladresse, insertvon, insertamum) VALUES 
					(".$db->addslashes($row->strasse).", ".$db->addslashes($row->plz).", ".$db->addslashes($row->ort).", ".$db->addslashes($row->ort).", 'f', false, false, ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
				if(!$db->db_query($adresse_ins))
				{	
					$rollback=true;
					$anzahl_fehler++;
					$error_log.="Adresse konnte nicht angelegt werden.\n".$adresse_ins."\n";
				}
				else 
				{
					$anzahl_insert++;
				}
				
				//Standort=Filiale 
				//akt_adresse_id=???
				$qryu = "SELECT currval('public.tbl_adresse_adresse_id_seq') AS id;";
				if($rowu=$db->db_fetch_object($db->db_query($qryu)))
					$akt_adresse_id=$rowu->id;
				else
				{
					$rollback=true;
					$anzahl_fehler++;
					$error_log.="Adresse-Sequence konnte nicht ausgelesen werden.\n";
				}
				$standort_ins="INSERT INTO public.tbl_standort 
					(kurzbz, adresse_id, bezeichnung, firma_id, insertvon, insertamum) VALUES 
					(".$db->addslashes($row->kurzbezeichnung).", ".$db->addslashes($akt_adresse_id).", ".$db->addslashes($row->firmenname).", ".$db->addslashes($akt_firma_id).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
				if(!$db->db_query($standort_ins))
				{	
					$rollback=true;
					$anzahl_fehler++;
					$error_log.="Standort konnte nicht angelegt werden.\n".$standort_ins."\n";
				}
				else
				{
					$anzahl_insert++;
				}
				
				//Kontakte (tel,fax,mail,hp) -- hängen an tb_standort
				//akt_standort_id=???
				$qryu = "SELECT currval('public.tbl_standort_standort_id_seq') AS id;";
				if($rowu=$db->db_fetch_object($db->db_query($qryu)))
					$akt_standort_id=$rowu->id;
				else
				{
					$rollback=true;
					$anzahl_fehler++;
					$error_log.="Standort-Sequence konnte nicht ausgelesen werden.\n";
				}
				if(strlen(trim($row->telefon))>0)
				{
					$telefon_ins="INSERT INTO public.tbl_kontakt 
						(kontakttyp, kontakt, zustellung, standort_id, insertvon, insertamum) VALUES 
						('telefon', ".$db->addslashes($row->telefon).", false, ".$db->addslashes($akt_standort_id).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
					if(!$db->db_query($telefon_ins))
					{	
						$rollback=true;
						$anzahl_fehler++;
						$error_log.="Telefonkontakt konnte nicht angelegt werden.\n".$telefon_ins."\n";
					}
					else
					{
						$anzahl_insert++;
					}
				}
				if(strlen(trim($row->telefax))>0)
				{
					$telefax_ins="INSERT INTO public.tbl_kontakt 
						(kontakttyp, kontakt, zustellung, standort_id, insertvon, insertamum) VALUES 
						('fax', ".$db->addslashes($row->telefax).", false, ".$db->addslashes($akt_standort_id).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
					if(!$db->db_query($telefax_ins))
					{	
						$rollback=true;
						$anzahl_fehler++;
						$error_log.="Telefaxkontakt konnte nicht angelegt werden.\n".$telefax_ins."\n";
					}
					else
					{
						$anzahl_insert++;
					}
				}
				if(strlen(trim($row->firma_email))>0)
				{
					if(strstr($row->firma_email, '@'))
					{
						$email_ins="INSERT INTO public.tbl_kontakt 
							(kontakttyp, kontakt, zustellung, standort_id, insertvon, insertamum) VALUES 
							('email', ".$db->addslashes($row->firma_email).", false, ".$db->addslashes($akt_standort_id).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
						if(!$db->db_query($email_ins))
						{	
							$rollback=true;
							$anzahl_fehler++;
							$error_log.="Emailkontakt konnte nicht angelegt werden.\n".$email_ins."\n";
						}
						else
						{
							$anzahl_insert++;
						}
					}
				}
				if(strlen(trim($row->homepage))>0)
				{
					$homepage_ins="INSERT INTO public.tbl_kontakt 
						(kontakttyp, kontakt, zustellung, standort_id, insertvon, insertamum) VALUES 
						('homepage', ".$db->addslashes($row->homepage).", false, ".$db->addslashes($akt_standort_id).", ".$db->addslashes($row->username).", ".$db->addslashes($row->lupdate).")";
					if(!$db->db_query($homepage_ins))
					{	
						$rollback=true;
						$anzahl_fehler++;
						$error_log.="Homepage konnte nicht angelegt werden.\n".$homepage_ins."\n";
					}
					else
					{
						$anzahl_insert++;
					}
				}
			}
			if($rollback)
			{
				$db->db_query("ROLLBACK");
			}
			else 
			{
				$db->db_query("COMMIT");
			}			
		}
	}

	if($firma_synced!='' || $upd_log!='' || $error_log!='')
	{
		$statistik="Firma Sync\n--------------\n";
		$statistik.="Firmensynchro Beginn: ".date("d.m.Y H:i:s")." von ".DB_NAME." - Anzahl Firmen: ".$anzahl_quelle."\n\n";
		$statistik.="\nEingefügte Datensätze: $anzahl_insert";
		$statistik.="\nGeänderte Datensätze: $anzahl_update";
		$statistik.="\nGelöschte Datensätze: $anzahl_delete";
		$statistik.="\nFehler: $anzahl_fehler\n";
		$firma_synced=$statistik.$error_log.$firma_synced;
		$mail = new mail(MAIL_ADMIN, "vilesci@".DOMAIN, "SYNC Firmen von ".DB_NAME, $firma_synced."\n\n\n Updatebereich: \n\n".$upd_log);
		$mail->setReplyTo("vilesci@".DOMAIN);
		if(!$mail->send())
		{
			echo "<font color=\"#FF0000\">Fehler beim Versenden des Durchführungs-Mails!</font><br>";	
		}
	}
}
?>