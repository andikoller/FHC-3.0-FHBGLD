<?php
/* Copyright (C) 2006 Technikum-Wien
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
 * Authors: Christian Paminger 	< christian.paminger@technikum-wien.at >
 *          Andreas Oesterreicher 	< andreas.oesterreicher@technikum-wien.at >
 *          Rudolf Hangl 		< rudolf.hangl@technikum-wien.at >
 *          Gerald Simane-Sequens 	< gerald.simane-sequens@technikum-wien.at >
 */
			
//diese datei unterscheidet sich von studentenmeldung.php nur dadurch daß:
// die erzeugte xml-datei nicht am server ausgegeben wird.
//somit können die daten überprüft werden und eine bereits vorhandene datei leichte heruntergeladen werden.

		require_once('../../config/vilesci.config.inc.php');
		require('../../include/studiensemester.class.php');
		require('../../include/datum.class.php');
		if (!$db = new basis_db())
			die('Es konnte keine Verbindung zum Server aufgebaut werden.');


		
$error_log='';
$error_log1='';
$error_log_all="";
$stgart='';
$fehler='';
$maxsemester=0;
$v='';
$studiensemester=new studiensemester();
$ssem=$studiensemester->getaktorNext();
$psem=$studiensemester->getPrevious();
$zaehl=0;
$erhalter='';
$stgart='';
$orgform='';
$status='';
$datei='';
$aktstatus='';
$mob='';
$gast='';
$avon='';
$abis='';
$zweck='';
$bewerberM=array();
$bewerberW=array();
$bsem=array();
$stsem=array();
$usem=array();
$asem=array();
$absem=array();
$iosem=array();
$bsema=array();
$stsema=array();
$usema=array();
$asema=array();
$absema=array();
$iosema=array();
$bewerbercount=0;
$bewerbercountbb=0;
$bewerbercountvz=0;
$bewerberM1=array();
$bewerberW1=array();
$bsem1=array();
$stsem1=array();
$bewerberM2=array();
$bewerberW2=array();
$bsem2=array();
$stsem2=array();
$datei1='';
$datei2='';
$stgorg="";
$tabelle='';
$stlist='';

//Beginn- und Endedatum des aktuellen Semesters
$qry="SELECT * FROM public.tbl_studiensemester WHERE studiensemester_kurzbz='".$ssem."';";
if($result = $db->db_query($qry))
{
	if($row = $db->db_fetch_object($result))
	{
		$beginn=$row->start;
		$ende=$row->ende;
	}
}
//Ermittlung aktuelles und letztes BIS-Meldedatum
if(mb_strstr($ssem,"WS"))
{
	$bisdatum=date("Y-m-d",  mktime(0, 0, 0, 11, 15, date("Y")));
	$bisprevious=date("Y-m-d",  mktime(0, 0, 0, 04, 15, date("Y")));
}
elseif(mb_strstr($ssem,"SS"))
{
	$bisdatum=date("Y-m-d",  mktime(0, 0, 0, 04, 15, date("Y")));
	$bisprevious=date("Y-m-d",  mktime(0, 0, 0, 11, 15, date("Y")-1));
}
else
{
	echo "Ung&uuml;ltiges Semester!";
}
//ausgewählter Studiengang
if(isset($_GET['stg_kz']))
{
	$stg_kz=$_GET['stg_kz'];
}
else
{
	$stg_kz=0;
	//echo "<H2>Es wurde kein Studiengang ausgew&auml;hlt!</H2>";
	//exit;
}
function myaddslashes($var)
{
	return ($var!=''?"'".addslashes($var)."'":'null');
}

$datumobj=new datum();

//Studiengangsdaten auslesen
$qry="SELECT * FROM public.tbl_studiengang WHERE studiengang_kz='".$stg_kz."'";
if($result = $db->db_query($qry))
{
	if($row = $db->db_fetch_object($result))
	{
		$maxsemester=$row->max_semester;
		if($maxsemester==0)
		{
			echo "Maximale Semesteranzahl des Studiengangs nicht angegeben!";
			exit;
		}
		$stgart=$row->typ;
		$stgemail=$row->email;
		if(strlen(trim($row->erhalter_kz))==1)
		{
			$erhalter='00'.trim($row->erhalter_kz);
		}
		elseif(strlen(trim($row->erhalter_kz))==2)
		{
			$erhalter='0'.trim($row->erhalter_kz);
		}
		else
		{
			$erhalter=$row->erhalter_kz;
		}
		if($row->typ=='b')
		{
			$stgart=1;
		}
		elseif($row->typ=='m')
		{
			$stgart=2;
		}
		elseif($row->typ=='d')
		{
			$stgart=3;
		}
		else
		{
			echo "<H2>Es wurde keine Studiengangart ausgew&auml;hlt!</H2>";
			exit;
		}
		if($row->orgform_kurzbz=='VZ')
		{
			$orgform=1;
		}
		elseif($row->orgform_kurzbz=='BB')
		{
			$orgform=2;
		}
		elseif($row->orgform_kurzbz=='VBB')
		{
			$orgform=3;
		}
		elseif($row->orgform_kurzbz=='ZGS')
		{
			$orgform=4;
		}
		else
		{
			echo "<H2>Es wurde keine Organisationsform ausgew&auml;hlt!</H2>";
			exit;
		}
		$stgorg=$row->orgform_kurzbz;
	}
}

//Hauptselect
$qry="SELECT DISTINCT ON(student_uid, nachname, vorname) *, public.tbl_person.person_id AS pers_id, tbl_abschlusspruefung.datum AS abdatum
	FROM public.tbl_student
	JOIN public.tbl_benutzer ON(student_uid=uid)
	JOIN public.tbl_person USING (person_id)
	JOIN public.tbl_prestudent USING (prestudent_id)
	JOIN public.tbl_prestudentstatus ON(tbl_prestudent.prestudent_id=tbl_prestudentstatus.prestudent_id)

	LEFT JOIN lehre.tbl_abschlusspruefung USING(student_uid)
	LEFT JOIN bis.tbl_bisio USING(student_uid)
	WHERE bismelden IS TRUE
	AND tbl_student.studiengang_kz='".$stg_kz."'
	AND (((tbl_prestudentstatus.studiensemester_kurzbz='".$ssem."') AND (tbl_prestudentstatus.datum<'".$bisdatum."')
		AND (status_kurzbz='Student' OR status_kurzbz='Outgoing'
		OR status_kurzbz='Praktikant' OR status_kurzbz='Diplomand' OR status_kurzbz='Absolvent'
		OR status_kurzbz='Abbrecher' OR status_kurzbz='Unterbrecher'))
		OR ((tbl_prestudentstatus.studiensemester_kurzbz='".$psem."') AND (status_kurzbz='Absolvent'
		OR status_kurzbz='Abbrecher') AND tbl_prestudentstatus.datum>'".$bisprevious."')
		OR (status_kurzbz='Incoming' AND (tbl_bisio.bis>='".$bisprevious."')
		OR (tbl_bisio.von<'".$bisdatum."' AND (tbl_bisio.bis>='".$bisdatum."'  OR tbl_bisio.bis IS NULL))))
	ORDER BY student_uid, nachname, vorname
	";

//LEFT JOIN public.tbl_studentlehrverband USING(student_uid)

if($result = $db->db_query($qry))
{

	$datei.="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<Erhalter>
  <ErhKz>".$erhalter."</ErhKz>
  <MeldeDatum>".date("dmY", $datumobj->mktime_fromdate($bisdatum))."</MeldeDatum>
  <StudierendenBewerberMeldung>
    <StudiengangStamm>
      <StgKz>".$stg_kz."</StgKz>
      <StgArtCode>".$stgart."</StgArtCode>
      <OrgFormCode>".$orgform."</OrgFormCode>";
      if($orgform==3)				//Studiengang in Mischform organisiert
      {
      	while($row = $db->db_fetch_object($result))
      	{
      		//Plausichecks
		$qryadr="SELECT * from public.tbl_adresse WHERE heimatadresse IS TRUE AND person_id='".$row->pers_id."';";
		if($db->db_num_rows($db->db_query($qryadr))!=1)
		{
			$error_log1="Es sind ".$db->db_num_rows($db->db_query($qryadr))." Heimatadressen eingetragen\n";
		}
		if($rowadr=$db->db_fetch_object($db->db_query($qryadr)))
		{
			$plz=$rowadr->plz;
			$gemeinde=$rowadr->gemeinde;
			$strasse=$rowadr->strasse;
			$nation=$rowadr->nation;
		}
		if($row->gebdatum<'1920-01-01' OR $row->gebdatum==null OR $row->gebdatum=='')
		{
				$error_log.=($error_log!=''?', ':'')."Geburtsdatum ('".$row->gebdatum."')";
		}
		if($row->geschlecht!='m' && $row->geschlecht!='w')
		{
				$error_log.=($error_log!=''?', ':'')."Geschlecht ('".$row->geschlecht."')";
		}
		if($row->vorname=='' || $row->vorname==null)
		{
				$error_log.=($error_log!=''?', ':'')."Vorname ('".$row->vorname."')";
		}
		if($row->nachname=='' || $row->nachname==null)
		{
				$error_log.=($error_log!=''?', ':'')."Nachname ('".$row->nachname."')";
		}
		if(($row->svnr=='' || $row->svnr==null)&&($row->ersatzkennzeichen=='' || $row->ersatzkennzeichen==null))
		{
			$error_log.=($error_log!=''?', ':'')."SVNR ('".$row->svnr."') bzw. ErsKz ('".$row->ersatzkennzeichen."')";
			if($row->svnr!='' && $row->svnr!=null && substr($row->svnr,4,6)!=$row->gebdatum)
			{
					$error_log.=($error_log!=''?', ':'')."SVNR ('".$row->svnr."') enthält Geburtsdatum (".$row->gebdatum.") nicht";
			}
			if($row->ersatzkennzeichen!='' && $row->ersatzkennzeichen!=null && substr($row->ersatzkennzeichen,4,6)!=$row->gebdatum)
			{
					$error_log.=($error_log!=''?', ':'')."Ersatzkennzeichen ('".$row->ersatzkennzeichen."') enthält Geburtsdatum (".$row->gebdatum.") nicht";
			}
		}
		if($row->staatsbuergerschaft=='' || $row->staatsbuergerschaft==null)
		{
				$error_log.=($error_log!=''?', ':'')."Staatsb&uuml;rgerschaft ('".$row->staatsbuergerschaft."')";
		}
		if($plz=='' || $plz==null)
		{
				$error_log.=($error_log!=''?', ':'')."Heimat-PLZ ('".$plz."')";
		}
		if($gemeinde=='' || $gemeinde==null)
		{
				$error_log.=($error_log!=''?', ':'')."Heimat-Gemeinde ('".$gemeinde."')";
		}
		if($strasse=='' || $strasse==null)
		{
				$error_log.=($error_log!=''?', ':'')."Heimat-Strasse ('".$strasse."')";
		}
		if($nation=='' || $nation==null)
		{
				$error_log.=($error_log!=''?', ':'')."Heimat-Nation ('".$nation."')";
		}
		if($row->zgv_code=='' || $row->zgv_code==null)
		{
				$error_log.=($error_log!=''?', ':'')."ZugangCode ('".$row->zgv_code."')";
		}
		if($row->zgvdatum=='' || $row->zgvdatum==null)
		{
				$error_log.=($error_log!=''?', ':'')."ZugangDatum ('".$row->zgvdatum."')";
		}
		else
		{
			if($row->zgvdatum>date('Y-m-d'))
			{
					$error_log.=($error_log!=''?', ':'')."ZugangDatum liegt in der Zukunft ('".$row->zgvdatum."')";
			}
			if($row->zgvdatum<$row->gebdatum)
			{
					$error_log.=($error_log!=''?', ':'')."ZugangDatum ('".$row->zgvdatum."') kleiner als Geburtsdatum ('".$row->gebdatum."')";
			}
		}
		if($stgart=='m')
		{
			if($row->zgvmas_code=='' || $row->zgvmas_code==null)
			{
					$error_log.=($error_log!=''?', ':'')."ZugangMagStgCode ('".$row->zgvmas_code."')";
			}
			if($row->zgvmadatum=='' || $row->zgvmadatum==null)
			{
					$error_log.=($error_log!=''?', ':'')."ZugangMagStgDatum ('".$row->zgvmadatum."')";
			}
			else
			{
				if($row->zgvmadatum>date(Y-m-d))
				{
						$error_log.=($error_log!=''?', ':'')."ZugangMagStgDatum liegt in der Zukunft ('".$row->zgvmadatum."')";
				}
				if($row->zgvmadatum<$row->zgvdatum)
				{
						$error_log.=($error_log!=''?', ':'')."ZugangMagStgDatum ('".$row->zgvmadatum."') kleiner als Zugangdatum ('".$row->zgvdatum."')";
				}
				if($row->zgvmadatum<$row->gebdatum)
				{
						$error_log.=($error_log!=''?', ':'')."ZugangMagStgDatum ('".$row->zgvmadatum."') kleiner als Geburtsdatum ('".$row->gebdatum."')";
				}
			}
		}
		if($orgform==3)
		{
			if($row->orgform_kurzbz=='' || $row->orgform_kurzbz==null)
			{
					$error_log.=($error_log!=''?', ':'')."Organisationsform ('".$row->orgform_kurzbz."')";
			}
		}
		//Bestimmen der aktuellen Prestudentrolle (Status) und des akt. Ausbildungssemesters des Studenten
		$qrystatus="SELECT * FROM public.tbl_prestudentstatus
		WHERE prestudent_id='".$row->prestudent_id."' AND studiensemester_kurzbz='".$ssem."'
		AND (tbl_prestudentstatus.datum<'".$bisdatum."')
		ORDER BY datum desc, insertamum desc, ext_id desc;";
		if($resultstatus = $db->db_query($qrystatus))
		{
			if($db->db_num_rows($resultstatus)>0)
			{
				if($rowstatus = $db->db_fetch_object($resultstatus))
				{
					$qry1="SELECT count(*) AS dipl FROM public.tbl_prestudentstatus WHERE prestudent_id='".$row->prestudent_id."' AND status_kurzbz='Diplomand'";
					if($result1 = $db->db_query($qry1))
					{
						if($row1 = $db->db_fetch_object($result1))
						{
							$sem=$rowstatus->ausbildungssemester;
							if($sem>$maxsemester)
							{
								$sem=$maxsemester;
							}
							if($row1->dipl>1)
							{
								$sem=50;
							}
							if($row1->dipl>3)
							{
								$sem=60;
							}
						}
					}
					if($rowstatus->status_kurzbz=="Student" || $rowstatus->status_kurzbz=="Outgoing"
						|| $rowstatus->status_kurzbz=="Incoming" || $rowstatus->status_kurzbz=='Praktikant'
						|| $rowstatus->status_kurzbz=="Diplomand")
					{
						$status=1;
					}
					else if($rowstatus->status_kurzbz=="Unterbrecher" )
					{
						$status=2;
					}
					else if($rowstatus->status_kurzbz=="Absolvent" )
					{
						$status=3;
					}
					else if($rowstatus->status_kurzbz=="Abbrecher" )
					{
						$status=4;
					}
					else
					{
						$error_log='';
						$error_log1='';
						continue;
					}
					$aktstatus=$rowstatus->status_kurzbz;
				}
			}
			else
			{
				$qrystatus="SELECT * FROM public.tbl_prestudentstatus WHERE prestudent_id='".$row->prestudent_id."' AND studiensemester_kurzbz='".$psem."' AND (tbl_prestudentstatus.datum<'".$bisdatum."') ORDER BY datum desc, insertamum desc, ext_id desc;";
				if($resultstatus = $db->db_query($qrystatus))
				{
					if($rowstatus = $db->db_fetch_object($resultstatus))
					{
						$qry1="SELECT count(*) AS dipl FROM public.tbl_prestudentstatus WHERE prestudent_id='".$row->prestudent_id."' AND status_kurzbz='Diplomand'";
						if($result1 = $db->db_query($qry1))
						{
							if($row1 = $db->db_fetch_object($result1))
							{
								$sem=$rowstatus->ausbildungssemester;
								if($sem>$maxsemester)
								{
									$sem=$maxsemester;
								}
								if($row1->dipl>1)
								{
									$sem=50;
								}
								if($row1->dipl>3)
								{
									$sem=60;
								}
							}
						}
						if($rowstatus->status_kurzbz=="Incoming")
						{
							$status=1;
						}
						else if($rowstatus->status_kurzbz=="Absolvent" )
						{
							$status=3;
						}
						else if($rowstatus->status_kurzbz=="Abbrecher" )
						{
							$status=4;
						}
						else
						{
							$error_log='';
							$error_log1='';
							continue;
						}
						$aktstatus=$rowstatus->status_kurzbz;
					}
				}
			}
		}
		//bei Absolventen das Beendigungsdatum (Sponsion oder Abschlussprüfung) überprüfen
		if($aktstatus=='Absolvent')
		{
			if($row->abdatum=='' || $row->abdatum==null)
			{
					$error_log.=($error_log!=''?', ':'')."Datum der Abschlusspr&uuml;fung ('".$row->abdatum."')";
			}
			if($row->sponsion=='' || $row->sponsion==null)
			{
					$error_log.=($error_log!=''?', ':'')."Datum der Sponsion ('".$row->sponsion."')";
			}
		}
		if($stgorg!='VZ')
		{
			if($row->berufstaetigkeit_code=='' || $row->berufstaetigkeit_code==null)
			{
					$error_log.=($error_log!=''?', ':'')."Berufst&auml;tigkeitscode ('".$row->berufstaetigkeit_code."')";
			}
		}
		if($aktstatus!='Incoming')
		{
			if(!$row->reihungstestangetreten)
			{
					$error_log.=($error_log!=''?', ':'')."Zum Reihungstest angetreten";
			}
			if($sem==0)
			{
					$error_log.=($error_log!=''?', ':'')."Aktuelles Semester (Rolle) ('".$sem."')";
			}
		}
		else
		{
			if($nation=='A' || $nation=='a')
			{
					$error_log.=($error_log!=''?', ':'')."Heimat-Nation bei Incoming('".$nation."')";
			}
		}
		if($error_log!='' OR $error_log1!='')
		{
			//Ausgabe der fehlenden Daten
			$v.="<u>Bei Student (UID, Vorname, Nachname) '".$row->student_uid."', '".$row->nachname."', '".$row->vorname."' ($row->status_kurzbz): </u>\n";
			if($error_log!='')
			{
				$v.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Es fehlt: ".$error_log."\n";
			}
			if($error_log1!='')
			{
				$v.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$error_log1;
			}
			$zaehl++;
			$v.="\n";
			$error_log='';
			$error_log1='';
			continue;
		}
		else
		{
			//Erstellung der XML-Datei für Studiengangstyp Mischform
			if($row->orgform_kurzbz=='BB')
		      	{
		      		//Teil Beufsbegleitend
				$datei2.="
	         <Student>
	          <PersKz>".trim($row->matrikelnr)."</PersKz>
	          <GeburtsDatum>".date("dmY", $datumobj->mktime_fromdate($row->gebdatum))."</GeburtsDatum>
	          <Geschlecht>".strtoupper($row->geschlecht)."</Geschlecht>
	          <Vorname>".$row->vorname."</Vorname>
	          <Familienname>".$row->nachname."</Familienname>";
				if($row->svnr!='')
				{
					$datei2.="
	          <SVNR>".$row->svnr."</SVNR>";
				}
				if($row->ersatzkennzeichen!='')
				{
					$datei2.="
	          <ErsKz>".$row->ersatzkennzeichen."</ErsKz>";
				}
				$datei2.="
	          <StaatsangehoerigkeitCode>".$row->staatsbuergerschaft."</StaatsangehoerigkeitCode>
	          <HeimatPLZ>".$plz."</HeimatPLZ>
	          <HeimatGemeinde>".$gemeinde."</HeimatGemeinde>
	          <HeimatStrasse><![CDATA[".$strasse."]]></HeimatStrasse>
	          <HeimatNation>".$nation."</HeimatNation>
	          <ZugangCode>".$row->zgv_code."</ZugangCode>";
	          			if($row->zgvdatum!=null)
				{
					$datei2.="
	          <ZugangDatum>".date("dmY", $datumobj->mktime_fromdate($row->zgvdatum))."</ZugangDatum>";
				}
				else
				{
					$datei2.="
	          <ZugangDatum></ZugangDatum>";
				}
			          if($stgart==2)
			          {
			          		$datei2.="
	          <ZugangMagStgCode>".$row->zgvmas_code."</ZugangMagStgCode>";
	          				if($row->zgvmadatum!=null)
					{
			          			$datei2.="
	          <ZugangMagStgDatum>".date("dmY", $datumobj->mktime_fromdate($row->zgvmadatum))."</ZugangMagStgDatum>";
					}
					else
					{
						$datei2.="
		<ZugangMagStgDatum></ZugangMagStgDatum>";
					}
			          }
			          $qryad="SELECT * FROM public.tbl_prestudentstatus WHERE prestudent_id='".$row->prestudent_id."' AND (status_kurzbz='Student'  OR status_kurzbz='Unterbrecher')  AND (tbl_prestudentstatus.datum<'".$bisdatum."') ORDER BY datum asc;";
			          if($resultad = $db->db_query($qryad))
				{
					if($rowad = $db->db_fetch_object($resultad))
					{
	          			$datei2.="
	          <BeginnDatum>".date("dmY", $datumobj->mktime_fromdate($rowad->datum))."</BeginnDatum>";
					}
				}
	          			if($aktstatus=='Absolvent')
				{
					$datei2.="
	          <BeendigungsDatum>".date("dmY", $datumobj->mktime_fromdate($row->sponsion))."</BeendigungsDatum>";
				}
				if($aktstatus!='Incoming')
				{
					$datei2.="
	          <Ausbildungssemester>".$sem."</Ausbildungssemester>";
				}
				$datei2.="
	          <StudStatusCode>".$status."</StudStatusCode>";
	          if($stgorg!='VZ')
		{
			$datei2.="
	          <BerufstaetigkeitCode>".$row->berufstaetigkeit_code."</BerufstaetigkeitCode>";
		}
		/*else
		{
			$datei2.="
                     <BerufstaetigkeitCode>NULL</BerufstaetigkeitCode>";
		}*/

				$qryio="SELECT * FROM bis.tbl_bisio WHERE student_uid='".$row->student_uid."'
					AND (von>'".$bisprevious."' OR bis IS NULL OR bis>'".$bisprevious."');";
				if($resultio = $db->db_query($qryio))
				{
					if($db->db_num_rows($resultio)==1)
					{
						if($rowio = $db->db_fetch_object($resultio))
						{
							$mob=$rowio->mobilitaetsprogramm_code;
							$gast=$rowio->nation_code;
							$avon=date("dmY", $datumobj->mktime_fromdate($rowio->von));
							$abis=date("dmY", $datumobj->mktime_fromdate($rowio->bis));
							$zweck=$rowio->zweck_code;
						}

						$datei2.="
	          <IO>
	            <MobilitaetsProgrammCode>".$mob."</MobilitaetsProgrammCode>
	            <GastlandCode>".$gast."</GastlandCode>
	            <AufenthaltVon>".$avon."</AufenthaltVon>";
			            		if($datumobj->mktime_fromdate($rowio->bis)<$datumobj->mktime_fromdate($bisdatum) && $datumobj->mktime_fromdate($rowio->bis)>$datumobj->mktime_fromdate($bisprevious))
			            		{
			            			$datei2.="
	            <AufenthaltBis>".$abis."</AufenthaltBis>";
						}
						$datei2.="
	            <AufenthaltZweckCode>".$zweck."</AufenthaltZweckCode>
	          </IO>";
						if($aktstatus=='Outgoing')
						{
							If(!isset($iosema[$sem]))
							{
								$iosema[$sem]=0;
							}
							$iosema[$sem]++;
						}
						else
						{
							If(!isset($iosema[0]))
							{
								$iosema[0]=0;
							}
							$iosema[0]++;
						}
					}
				}
				$datei2.="
	         </Student>";
				if($aktstatus=='Student' || $aktstatus=='Diplomand' || $aktstatus=='Praktikant' || $aktstatus=='Outgoing')
				{
					If(!isset($stsema[$sem]))
					{
						$stsema[$sem]=0;
					}
					$stsema[$sem]++;
				}
				if($aktstatus=='Unterbrecher')
				{
					If(!isset($usema[$sem]))
					{
						$usema[$sem]=0;
					}
					$usema[$sem]++;
				}
				if($aktstatus=='Abbrecher')
				{
					If(!isset($asema[$sem]))
					{
						$asema[$sem]=0;
					}
					$asema[$sem]++;
				}
				if($aktstatus=='Absolvent')
				{
					If(!isset($absema[$sem]))
					{
						$absema[$sem]=0;
					}
					$absema[$sem]++;
				}
		      	}
		      	else
		      	{
		      		//Teil Vollzeit
		      		$datei1.="
	         <Student>
	          <PersKz>".trim($row->matrikelnr)."</PersKz>
	          <GeburtsDatum>".date("dmY", $datumobj->mktime_fromdate($row->gebdatum))."</GeburtsDatum>
	          <Geschlecht>".strtoupper($row->geschlecht)."</Geschlecht>
	          <Vorname>".$row->vorname."</Vorname>
	          <Familienname>".$row->nachname."</Familienname>";
				if($row->svnr!='')
				{
					$datei1.="
	          <SVNR>".$row->svnr."</SVNR>";
				}
				if($row->ersatzkennzeichen!='')
				{
					$datei1.="
	          <ErsKz>".$row->ersatzkennzeichen."</ErsKz>";
				}
				$datei1.="
	          <StaatsangehoerigkeitCode>".$row->staatsbuergerschaft."</StaatsangehoerigkeitCode>
	          <HeimatPLZ>".$plz."</HeimatPLZ>
	          <HeimatGemeinde>".$gemeinde."</HeimatGemeinde>
	          <HeimatStrasse><![CDATA[".$strasse."]]></HeimatStrasse>
	          <HeimatNation>".$nation."</HeimatNation>
	          <ZugangCode>".$row->zgv_code."</ZugangCode>";
				if($row->zgvdatum!=null)
				{
					$datei1.="
	          <ZugangDatum>".date("dmY", $datumobj->mktime_fromdate($row->zgvdatum))."</ZugangDatum>";
				}
				else
				{
					$datei1.="
	          <ZugangDatum></ZugangDatum>";
				}
			          if($stgart==2)
			          {
			          		$datei1.="
	          <ZugangMagStgCode>".$row->zgvmas_code."</ZugangMagStgCode>";
	          				if($row->zgvmadatum!=null)
					{
			          			$datei1.="
	          <ZugangMagStgDatum>".date("dmY", $datumobj->mktime_fromdate($row->zgvmadatum))."</ZugangMagStgDatum>";
					}
					else
					{
						$datei1.="
		<ZugangMagStgDatum></ZugangMagStgDatum>";
					}
			          }
			          $qryad="SELECT * FROM public.tbl_prestudentstatus WHERE prestudent_id='".$row->prestudent_id."' AND (status_kurzbz='Student'  OR status_kurzbz='Unterbrecher')  AND (tbl_prestudentstatus.datum<'".$bisdatum."')  ORDER BY datum asc;";
			          if($resultad = $db->db_query($qryad))
				{
					if($rowad = $db->db_fetch_object($resultad))
					{
	          			$datei1.="
	          <BeginnDatum>".date("dmY", $datumobj->mktime_fromdate($rowad->datum))."</BeginnDatum>";
					}
				}
	          			if($aktstatus=='Absolvent')
				{
					$datei1.="
	          <BeendigungsDatum>".date("dmY", $datumobj->mktime_fromdate($row->sponsion))."</BeendigungsDatum>";
				}
				if($aktstatus!='Incoming')
				{
					$datei1.="
	          <Ausbildungssemester>".$sem."</Ausbildungssemester>";
				}
				$datei1.="
	          <StudStatusCode>".$status."</StudStatusCode>";
	          /*if($stgorg!='VZ')
		{
			$datei1.="
	          <BerufstaetigkeitCode>".$row->berufstaetigkeit_code."</BerufstaetigkeitCode>";
		}
		/*else
		{
			$datei1.="
                      <BerufstaetigkeitCode>NULL</BerufstaetigkeitCode>";
		}*/
				$qryio="SELECT * FROM bis.tbl_bisio WHERE student_uid='".$row->student_uid."'
					AND (von>'".$bisprevious."' OR bis IS NULL OR bis>'".$bisprevious."');";
				if($resultio = $db->db_query($qryio))
				{
					if($db->db_num_rows($resultio)==1)
					{
						if($rowio = $db->db_fetch_object($resultio))
						{
							$mob=$rowio->mobilitaetsprogramm_code;
							$gast=$rowio->nation_code;
							$avon=date("dmY", $datumobj->mktime_fromdate($rowio->von));
							$abis=date("dmY", $datumobj->mktime_fromdate($rowio->bis));
							$zweck=$rowio->zweck_code;
						}

						$datei1.="
	          <IO>
	            <MobilitaetsProgrammCode>".$mob."</MobilitaetsProgrammCode>
	            <GastlandCode>".$gast."</GastlandCode>
	            <AufenthaltVon>".$avon."</AufenthaltVon>";
			            		if($datumobj->mktime_fromdate($rowio->bis)<$datumobj->mktime_fromdate($bisdatum) && $datumobj->mktime_fromdate($rowio->bis)>$datumobj->mktime_fromdate($bisprevious))
			            		{
			            			$datei1.="
	            <AufenthaltBis>".$abis."</AufenthaltBis>";
						}
						$datei1.="
	            <AufenthaltZweckCode>".$zweck."</AufenthaltZweckCode>
	          </IO>";

						if($aktstatus=='Outgoing')
						{
							If(!isset($iosem[$sem]))
							{
								$iosem[$sem]=0;
							}
							$iosem[$sem]++;
						}
						else
						{
							If(!isset($iosem[0]))
							{
								$iosem[0]=0;
							}
							$iosem[0]++;
						}
					}
				}
				$datei1.="
	         </Student>";
				if($aktstatus=='Student' || $aktstatus=='Diplomand' || $aktstatus=='Praktikant' || $aktstatus=='Outgoing')
				{
					If(!isset($stsem[$sem]))
					{
						$stsem[$sem]=0;
					}
					$stsem[$sem]++;
				}
				if($aktstatus=='Unterbrecher')
				{
					If(!isset($usem[$sem]))
					{
						$usem[$sem]=0;
					}
					$usem[$sem]++;
				}
				if($aktstatus=='Abbrecher')
				{
					If(!isset($asem[$sem]))
					{
						$asem[$sem]=0;
					}
					$asem[$sem]++;
				}
				if($aktstatus=='Absolvent')
				{
					If(!isset($absem[$sem]))
					{
						$absem[$sem]=0;
					}
					$absem[$sem]++;
				}
		      	}
		      	//Studentenliste
      			$stlist.="<tr><td align=center>".trim($row->student_uid)."</td><td align=center>".trim($row->matrikelnr)."</td><td>".trim($row->nachname)."</td><td>".trim($row->vorname)."</td><td>".trim($row->status_kurzbz)."</td><td align=center>".trim($sem)."</td></tr>";
		}
      	}
      	//Bewerber
		$qrybw="SELECT * FROM public.tbl_prestudent
			JOIN public.tbl_prestudentstatus ON(tbl_prestudent.prestudent_id=tbl_prestudentstatus.prestudent_id)
			JOIN public.tbl_person USING(person_id)
			WHERE (studiensemester_kurzbz='".$ssem."') AND tbl_prestudent.studiengang_kz='".$stg_kz."' AND (tbl_prestudentstatus.datum<'".$bisdatum."')
			AND status_kurzbz='Bewerber' AND reihungstestangetreten;
			";
		if($resultbw = $db->db_query($qrybw))
		{
			while($rowbw = $db->db_fetch_object($resultbw))
			{
				if($rowbw->orgform_kurzbz=='BB')
	      			{
					If(!isset($bsem2[$rowbw->ausbildungssemester]))
					{
						$bsem2[$rowbw->ausbildungssemester]=0;
					}
					$bsem2[$rowbw->ausbildungssemester]++;
					if($stgart==1 || $stgart==3)
					{
						if(strtoupper($rowbw->geschlecht)=='M')
						{
							If(!isset($bewerberM2[$rowbw->zgv_code]))
							{
								$bewerberM2[$rowbw->zgv_code]=0;
							}
							$bewerberM2[$rowbw->zgv_code]++;
						}
						else
						{
							If(!isset($bewerberW2[$rowbw->zgv_code]))
							{
								$bewerberW2[$rowbw->zgv_code]=0;
							}
							$bewerberW2[$rowbw->zgv_code]++;
						}
					}
					if($stgart==2)
					{
						if(strtoupper($rowbw->geschlecht)=='M')
						{
							If(!isset($bewerberM2[$rowbw->zgvmas_code]))
							{
								$bewerberM2[$rowbw->zgvmas_code]=0;
							}
							$bewerberM2[$rowbw->zgvmas_code]++;
						}
						else
						{
							If(!isset($bewerberW2[$rowbw->zgvmas_code]))
							{
								$bewerberW2[$rowbw->zgvmas_code]=0;
							}
							$bewerberW2[$rowbw->zgvmas_code]++;
						}
					}
					$bewerbercountbb++;
	      			}
	      			else
	      			{
	      				If(!isset($bsem1[$rowbw->ausbildungssemester]))
					{
						$bsem1[$rowbw->ausbildungssemester]=0;
					}
					$bsem1[$rowbw->ausbildungssemester]++;
					if($stgart==1 || $stgart==3)
					{
						if(strtoupper($rowbw->geschlecht)=='M')
						{
							If(!isset($bewerberM1[$rowbw->zgv_code]))
							{
								$bewerberM1[$rowbw->zgv_code]=0;
							}
							$bewerberM1[$rowbw->zgv_code]++;
						}
						else
						{
							If(!isset($bewerberW1[$rowbw->zgv_code]))
							{
								$bewerberW1[$rowbw->zgv_code]=0;
							}
							$bewerberW1[$rowbw->zgv_code]++;
						}
					}
					if($stgart==2)
					{
						if(strtoupper($rowbw->geschlecht)=='M')
						{
							If(!isset($bewerberM1[$rowbw->zgvmas_code]))
							{
								$bewerberM1[$rowbw->zgvmas_code]=0;
							}
							$bewerberM1[$rowbw->zgvmas_code]++;
						}
						else
						{
							If(!isset($bewerberW1[$rowbw->zgvmas_code]))
							{
								$bewerberW1[$rowbw->zgvmas_code]=0;
							}
							$bewerberW1[$rowbw->zgvmas_code]++;
						}
					}
					$bewerbercountvz++;
	      			}
	      			$bewerbercount++;
			}
		}
		if($stgart==1 || $stgart==3)
		{
			for($i=4;$i<100;$i++)
			{
				if(isset($bewerberM1[$i]) || isset($bewerberW1[$i]))
				{
					If(!isset($bewerberM1[$i]))
					{
						$bewerberM1[$i]=0;
					}
					If(!isset($bewerberW1[$i]))
					{
						$bewerberW1[$i]=0;
					}
					$datei1.="
		         <Bewerber>
		           <ZugangCode>".$i."</ZugangCode>
		           <AnzBewerberM>".$bewerberM1[$i]."</AnzBewerberM>
		           <AnzBewerberW>".$bewerberW1[$i]."</AnzBewerberW>
		         </Bewerber>";
				}
				if(isset($bewerberM2[$i]) || isset($bewerberW2[$i]))
				{
					If(!isset($bewerberM2[$i]))
					{
						$bewerberM2[$i]=0;
					}
					If(!isset($bewerberW2[$i]))
					{
						$bewerberW2[$i]=0;
					}
					$datei2.="
		         <Bewerber>
		           <ZugangCode>".$i."</ZugangCode>
		           <AnzBewerberM>".$bewerberM2[$i]."</AnzBewerberM>
		           <AnzBewerberW>".$bewerberW2[$i]."</AnzBewerberW>
		         </Bewerber>";
				}
			}
		}
		if($stgart==2)
		{
			for($i=1;$i<12;$i++)
			{
				if(isset($bewerberM1[$i]) || isset($bewerberW1[$i]))
				{
					if(!isset($bewerberM1[$i]))
					{
						$bewerberM1[$i]=0;
					}
					if(!isset($bewerberW1[$i]))
					{
						$bewerberW1[$i]=0;
					}
					$datei1.="
		         <Bewerber>
		           <ZugangMagStgCode>".$i."</ZugangMagStgCode>
		           <AnzBewerberM>".$bewerberM1[$i]."</AnzBewerberM>
		           <AnzBewerberW>".$bewerberW1[$i]."</AnzBewerberW>
		         </Bewerber>";
				}
				if(isset($bewerberM2[$i]) || isset($bewerberW2[$i]))
				{
					if(!isset($bewerberM2[$i]))
					{
						$bewerberM2[$i]=0;
					}
					if(!isset($bewerberW2[$i]))
					{
						$bewerberW2[$i]=0;
					}
					$datei2.="
		         <Bewerber>
		           <ZugangMagStgCode>".$i."</ZugangMagStgCode>
		           <AnzBewerberM>".$bewerberM2[$i]."</AnzBewerberM>
		           <AnzBewerberW>".$bewerberW2[$i]."</AnzBewerberW>
		         </Bewerber>";
				}
			}
		}

	if($datei1!='')
	{
		$datei.="
		<StudiengangDetail>
      	<OrgFormTeilCode>1</OrgFormTeilCode>
      	  <StgStartSemCode>1</StgStartSemCode>".$datei1."
	</StudiengangDetail>";
	}
	if($datei2!='')
	{
		$datei.="
		<StudiengangDetail>
      	<OrgFormTeilCode>2</OrgFormTeilCode>
      	  <StgStartSemCode>1</StgStartSemCode>".$datei2."
       </StudiengangDetail>";
	}
      }
      else
      {
      	//orgform!='3'
      	//Stg mit einer Orgform
	      $datei.="
	      <StudiengangDetail>
	        <OrgFormTeilCode>".$orgform."</OrgFormTeilCode>
	        <StgStartSemCode>1</StgStartSemCode>
	";
		while($row = $db->db_fetch_object($result))
		{
			$qryadr="SELECT * from public.tbl_adresse WHERE heimatadresse IS TRUE AND person_id='".$row->pers_id."';";
			if($db->db_num_rows($db->db_query($qryadr))!=1)
			{
				$error_log1="Es sind ".$db->db_num_rows($db->db_query($qryadr))." Heimatadressen eingetragen\n";
			}
			if($rowadr=$db->db_fetch_object($db->db_query($qryadr)))
			{
				$plz=$rowadr->plz;
				$gemeinde=$rowadr->gemeinde;
				$strasse=$rowadr->strasse;
				$nation=$rowadr->nation;
			}
			if($row->gebdatum<'1920-01-01' OR $row->gebdatum==null OR $row->gebdatum=='')
			{
				if($error_log!='')
				{
					$error_log=", Geburtsdatum ('".$row->gebdatum."')";
				}
				else
				{
					$error_log.="Geburtsdatum ('".$row->gebdatum."')";
				}
			}
			if($row->geschlecht!='m' && $row->geschlecht!='w')
			{
				if($error_log!='')
				{
					$error_log.=", Geschlecht ('".$row->geschlecht."')";
				}
				else
				{
					$error_log.="Geschlecht ('".$row->geschlecht."')";
				}
			}
			if($row->vorname=='' || $row->vorname==null)
			{
				if($error_log!='')
				{
					$error_log.=", Vorname ('".$row->vorname."')";
				}
				else
				{
					$error_log.="Vorname ('".$row->vorname."')";
				}
			}
			if($row->nachname=='' || $row->nachname==null)
			{
				if($error_log!='')
				{
					$error_log.=", Nachname ('".$row->nachname."')";
				}
				else
				{
					$error_log.="Nachname ('".$row->nachname."')";
				}
			}
			if(($row->svnr=='' || $row->svnr==null)&&($row->ersatzkennzeichen=='' || $row->ersatzkennzeichen==null))
			{
				if($error_log!='')
				{
					$error_log.=", SVNR ('".$row->svnr."') bzw. ErsKz ('".$row->ersatzkennzeichen."')";
				}
				else
				{
					$error_log.="SVNR ('".$row->svnr."') bzw. ErsKz ('".$row->ersatzkennzeichen."')";
				}
				if($row->svnr!='' && $row->svnr!=null && substr($row->svnr,4,6)!=$row->gebdatum)
				{
					if($error_log!='')
					{
						$error_log.=", SVNR ('".$row->svnr."') enthält Geburtsdatum (".$row->gebdatum.") nicht";
					}
					else
					{
						$error_log.="SVNR ('".$row->svnr."') enthält Geburtsdatum (".$row->gebdatum.") nicht";
					}
				}
				if($row->ersatzkennzeichen!='' && $row->ersatzkennzeichen!=null && substr($row->ersatzkennzeichen,4,6)!=$row->gebdatum)
				{
					if($error_log!='')
					{
						$error_log.=", Ersatzkennzeichen ('".$row->ersatzkennzeichen."') enthält Geburtsdatum (".$row->gebdatum.") nicht";
					}
					else
					{
						$error_log.="Ersatzkennzeichen ('".$row->ersatzkennzeichen."') enthält Geburtsdatum (".$row->gebdatum.") nicht";
					}
				}
			}
			if($row->staatsbuergerschaft=='' || $row->staatsbuergerschaft==null)
			{
				if($error_log!='')
				{
					$error_log.=", Staatsb&uuml;rgerschaft ('".$row->staatsbuergerschaft."')";
				}
				else
				{
					$error_log.="Staatsb&uuml;rgerschaft ('".$row->staatsbuergerschaft."')";
				}
			}
			if($plz=='' || $plz==null)
			{
				if($error_log!='')
				{
					$error_log.=", Heimat-PLZ ('".$plz."')";
				}
				else
				{
					$error_log.="Heimat-PLZ ('".$plz."')";
				}
			}
			if($gemeinde=='' || $gemeinde==null)
			{
				if($error_log!='')
				{
					$error_log.=", Heimat-Gemeinde ('".$gemeinde."')";
				}
				else
				{
					$error_log.="Heimat-Gemeinde ('".$gemeinde."')";
				}
			}
			if($strasse=='' || $strasse==null)
			{
				if($error_log!='')
				{
					$error_log.=", Heimat-Strasse ('".$strasse."')";
				}
				else
				{
					$error_log.="Heimat-Strasse ('".$strasse."')";
				}
			}
			if($nation=='' || $nation==null)
			{
				if($error_log!='')
				{
					$error_log.=", Heimat-Nation ('".$nation."')";
				}
				else
				{
					$error_log.="Heimat-Nation ('".$nation."')";
				}
			}
			if($row->zgv_code=='' || $row->zgv_code==null)
			{
				if($error_log!='')
				{
					$error_log.=", ZugangCode ('".$row->zgv_code."')";
				}
				else
				{
					$error_log.="ZugangCode ('".$row->zgv_code."')";
				}
			}
			if($row->zgvdatum=='' || $row->zgvdatum==null)
			{
				if($error_log!='')
				{
					$error_log.=", ZugangDatum ('".$row->zgvdatum."')";
				}
				else
				{
					$error_log.="ZugangDatum ('".$row->zgvdatum."')";
				}
			}
			else
			{
				if($row->zgvdatum>date("Y-m-d"))
				{
					if($error_log!='')
					{
						$error_log.=", ZugangDatum liegt in der Zukunft ('".$row->zgvdatum."')";
					}
					else
					{
						$error_log.="ZugangDatum liegt in der Zukunft ('".$row->zgvdatum."')";
					}
				}
			}
			if($stgart=='m')
			{
				if($row->zgvmas_code=='' || $row->zgvmas_code==null)
				{
					if($error_log!='')
					{
						$error_log.=", ZugangMagStgCode ('".$row->zgvmas_code."')";
					}
					else
					{
						$error_log.="ZugangMagStgCode ('".$row->zgvmas_code."')";
					}
				}
				if($row->zgvmadatum=='' || $row->zgvmadatum==null)
				{
					if($error_log!='')
					{
						$error_log.=", ZugangMagStgDatum ('".$row->zgvmadatum."')";
					}
					else
					{
						$error_log.="ZugangMagStgDatum ('".$row->zgvmadatum."')";
					}
				}
				else
				{
					if($row->zgvmadatum>date("Y-m-d"))
					{
						if($error_log!='')
						{
							$error_log.=", ZugangMagStgDatum liegt in der Zukunft ('".$row->zgvmadatum."')";
						}
						else
						{
							$error_log.="ZugangMagStgDatum liegt in der Zukunft ('".$row->zgvmadatum."')";
						}
					}
					if($row->zgvmadatum<$row->zgvdatum)
					{
						if($error_log!='')
						{
							$error_log.=", ZugangMagStgDatum ('".$row->zgvmadatum."') kleiner als ZugangDatum ('".$row->zgvdatum."')";
						}
						else
						{
							$error_log.="ZugangMagStgDatum ('".$row->zgvmadatum."') kleiner als Zugangdatum ('".$row->zgvdatum."')";
						}
					}
					if($row->zgvmadatum<$row->gebdatum)
					{
						if($error_log!='')
						{
							$error_log.=", ZugangMagStgDatum ('".$row->zgvmadatum."') kleiner als Geburtsdatum ('".$row->gebdatum."')";
						}
						else
						{
							$error_log.="ZugangMagStgDatum ('".$row->zgvmadatum."') kleiner als Geburtsdatum ('".$row->gebdatum."')";
						}
					}
				}
			}
			$qrystatus="SELECT * FROM public.tbl_prestudentstatus WHERE prestudent_id='".$row->prestudent_id."' AND studiensemester_kurzbz='".$ssem."' AND (tbl_prestudentstatus.datum<'".$bisdatum."') ORDER BY datum desc, insertamum desc, ext_id desc;";
			if($resultstatus = $db->db_query($qrystatus))
			{
				if($db->db_num_rows($resultstatus)>0)
				{
					if($rowstatus = $db->db_fetch_object($resultstatus))
					{
						$qry1="SELECT count(*) AS dipl FROM public.tbl_prestudentstatus WHERE prestudent_id='".$row->prestudent_id."' AND (tbl_prestudentstatus.datum<'".$bisdatum."') AND status_kurzbz='Diplomand'";
						if($result1 = $db->db_query($qry1))
						{
							if($row1 = $db->db_fetch_object($result1))
							{
								$sem=$rowstatus->ausbildungssemester;
								if($sem>$maxsemester)
								{
									$sem=$maxsemester;
								}
								if($row1->dipl>1)
								{
									$sem=50;
								}
								if($row1->dipl>3)
								{
									$sem=60;
								}
							}
						}
						if($rowstatus->status_kurzbz=="Student" || $rowstatus->status_kurzbz=="Outgoing"
							|| $rowstatus->status_kurzbz=="Incoming" || $rowstatus->status_kurzbz=='Praktikant'
							|| $rowstatus->status_kurzbz=="Diplomand")
						{
							$status=1;
						}
						else if($rowstatus->status_kurzbz=="Unterbrecher" )
						{
							$status=2;
						}
						else if($rowstatus->status_kurzbz=="Absolvent" )
						{
							$status=3;
						}
						else if($rowstatus->status_kurzbz=="Abbrecher" )
						{
							$status=4;
						}
						else
						{
							continue;
						}
						$aktstatus=$rowstatus->status_kurzbz;
					}
				}
				else
				{
					$qrystatus="SELECT * FROM public.tbl_prestudentstatus WHERE prestudent_id='".$row->prestudent_id."' AND studiensemester_kurzbz='".$psem."' AND (tbl_prestudentstatus.datum<'".$bisdatum."') ORDER BY datum desc, insertamum desc, ext_id desc;";
					if($resultstatus = $db->db_query($qrystatus))
					{
						if($rowstatus = $db->db_fetch_object($resultstatus))
						{
							$qry1="SELECT count(*) AS dipl FROM public.tbl_prestudentstatus WHERE prestudent_id='".$row->prestudent_id."' AND status_kurzbz='Diplomand' AND (tbl_prestudentstatus.datum<'".$bisdatum."')";
							if($result1 = $db->db_query($qry1))
							{
								if($row1 = $db->db_fetch_object($result1))
								{
									$sem=$rowstatus->ausbildungssemester;
									if($sem>$maxsemester)
									{
										$sem=$maxsemester;
									}
									if($row1->dipl>1)
									{
										$sem=50;
									}
									if($row1->dipl>3)
									{
										$sem=60;
									}
								}
							}
							if($rowstatus->status_kurzbz=="Incoming")
							{
								$status=1;
							}
							else if($rowstatus->status_kurzbz=="Absolvent" )
							{
								$status=3;
							}
							else if($rowstatus->status_kurzbz=="Abbrecher" )
							{
								$status=4;
							}
							else
							{
								continue;
							}
							$aktstatus=$rowstatus->status_kurzbz;
						}
					}
				}
			}
			//bei Absolventen das Beendigungsdatum (Sponsion oder Abschlussprüfung) überprüfen
			if($aktstatus=='Absolvent')
			{
				if($row->abdatum=='' || $row->abdatum==null)
				{
					if($error_log!='')
					{
						$error_log.=", Datum der Abschlusspr&uuml;fung ('".$row->abdatum."')";
					}
					else
					{
						$error_log.="Datum der Abschlusspr&uuml;fung ('".$row->abdatum."')";
					}
				}
				if($row->sponsion=='' || $row->sponsion==null)
				{
					if($error_log!='')
					{
						$error_log.=", Datum der Sponsion ('".$row->sponsion."')";
					}
					else
					{
						$error_log.="Datum der Sponsion ('".$row->sponsion."')";
					}
				}
			}
			if($stgorg!='VZ')
			{
				if($row->berufstaetigkeit_code=='' || $row->berufstaetigkeit_code==null)
				{
					if($error_log!='')
					{
						$error_log.=", Berufst&auml;tigkeitscode ('".$row->berufstaetigkeit_code."')";
					}
					else
					{
						$error_log.="Berufst&auml;tigkeitscode ('".$row->berufstaetigkeit_code."')";
					}
				}
			}
			if($aktstatus!='Incoming')
			{
				if(!$row->reihungstestangetreten)
				{
					if($error_log!='')
					{
						$error_log.=", zum Reihungstest angetreten";
					}
					else
					{
						$error_log.="Zum Reihungstest angetreten";
					}
				}
				if($sem==0)
				{
					if($error_log!='')
					{
						$error_log.=", aktuelles Semester (Rolle) ('".$sem."')";
					}
					else
					{
						$error_log.="Aktuelles Semester (Rolle) ('".$sem."')";
					}
				}
			}
			else
			{
				if($nation=='A' || $nation=='a')
				{
					if($error_log!='')
					{
						$error_log.=", Heimat-Nation bei Incoming('".$nation."')";
					}
					else
					{
						$error_log.="Heimat-Nation bei Incoming('".$nation."')";
					}
				}
			}
			if($error_log!='' OR $error_log1!='')
			{
				$v.="<u>Bei Student (UID, Vorname, Nachname) '".$row->student_uid."', '".$row->nachname."', '".$row->vorname."' ($row->status_kurzbz): </u>\n";
				if($error_log!='')
				{
					$v.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Es fehlt: ".$error_log."\n";
				}
				if($error_log1!='')
				{
					$v.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$error_log1;
				}
				$zaehl++;
				$v.="\n";
				$error_log='';
				$error_log1='';
				continue;
			}
			else
			{

				$datei.="
	         <Student>
	          <PersKz>".trim($row->matrikelnr)."</PersKz>
	          <GeburtsDatum>".date("dmY", $datumobj->mktime_fromdate($row->gebdatum))."</GeburtsDatum>
	          <Geschlecht>".strtoupper($row->geschlecht)."</Geschlecht>
	          <Vorname>".$row->vorname."</Vorname>
	          <Familienname>".$row->nachname."</Familienname>";
				if($row->svnr!='')
				{
					$datei.="
	          <SVNR>".$row->svnr."</SVNR>";
				}
				if($row->ersatzkennzeichen!='')
				{
					$datei.="
	          <ErsKz>".$row->ersatzkennzeichen."</ErsKz>";
				}
				$datei.="
	          <StaatsangehoerigkeitCode>".$row->staatsbuergerschaft."</StaatsangehoerigkeitCode>
	          <HeimatPLZ>".$plz."</HeimatPLZ>
	          <HeimatGemeinde>".$gemeinde."</HeimatGemeinde>
	          <HeimatStrasse><![CDATA[".$strasse."]]></HeimatStrasse>
	          <HeimatNation>".$nation."</HeimatNation>
	          <ZugangCode>".$row->zgv_code."</ZugangCode>";
				if($row->zgvdatum!=null)
				{
					$datei.="
	          <ZugangDatum>".date("dmY", $datumobj->mktime_fromdate($row->zgvdatum))."</ZugangDatum>";
				}
				else
				{
					$datei.="
	          <ZugangDatum></ZugangDatum>";
				}
			          if($stgart==2)
			          {
			          		$datei.="
	          <ZugangMagStgCode>".$row->zgvmas_code."</ZugangMagStgCode>";
			          		if($row->zgvmadatum!=null)
					{
			          			$datei.="
	          <ZugangMagStgDatum>".date("dmY", $datumobj->mktime_fromdate($row->zgvmadatum))."</ZugangMagStgDatum>";
					}
					else
					{
						$datei.="
		<ZugangMagStgDatum></ZugangMagStgDatum>";
					}
			          }
			          $qryad="SELECT * FROM public.tbl_prestudentstatus WHERE prestudent_id='".$row->prestudent_id."' AND (status_kurzbz='Student' OR status_kurzbz='Unterbrecher') AND (tbl_prestudentstatus.datum<'".$bisdatum."') ORDER BY datum asc;";
			          if($resultad = $db->db_query($qryad))
				{
					if($rowad = $db->db_fetch_object($resultad))
					{
	          			$datei.="
	          <BeginnDatum>".date("dmY", $datumobj->mktime_fromdate($rowad->datum))."</BeginnDatum>";
					}
				}
	          			if($aktstatus=='Absolvent')
				{
					$datei.="
	          <BeendigungsDatum>".date("dmY", $datumobj->mktime_fromdate($row->sponsion))."</BeendigungsDatum>";
				}
				if($aktstatus!='Incoming')
				{
					$datei.="
	          <Ausbildungssemester>".$sem."</Ausbildungssemester>";
				}
				$datei.="
	          <StudStatusCode>".$status."</StudStatusCode>";
	          if($stgorg!='VZ')
		{
			$datei.="
	          <BerufstaetigkeitCode>".$row->berufstaetigkeit_code."</BerufstaetigkeitCode>";
		}

				$qryio="SELECT * FROM bis.tbl_bisio WHERE student_uid='".$row->student_uid."'
					AND (von>'".$bisprevious."' OR bis IS NULL OR bis>'".$bisprevious."');";
				if($resultio = $db->db_query($qryio))
				{
					if($db->db_num_rows($resultio)==1)
					{
						if($rowio = $db->db_fetch_object($resultio))
						{
							$mob=$rowio->mobilitaetsprogramm_code;
							$gast=$rowio->nation_code;
							$avon=date("dmY", $datumobj->mktime_fromdate($rowio->von));
							$abis=date("dmY", $datumobj->mktime_fromdate($rowio->bis));
							$zweck=$rowio->zweck_code;
						}

						$datei.="
	          <IO>
	            <MobilitaetsProgrammCode>".$mob."</MobilitaetsProgrammCode>
	            <GastlandCode>".$gast."</GastlandCode>
	            <AufenthaltVon>".$avon."</AufenthaltVon>";
			            		if($datumobj->mktime_fromdate($rowio->bis)<$datumobj->mktime_fromdate($bisdatum) && $datumobj->mktime_fromdate($rowio->bis)>$datumobj->mktime_fromdate($bisprevious))
			            		{
			            			$datei.="
	            <AufenthaltBis>".$abis."</AufenthaltBis>";
						}
						$datei.="
	            <AufenthaltZweckCode>".$zweck."</AufenthaltZweckCode>
	          </IO>";
						if($aktstatus=='Outgoing')
						{
							If(!isset($iosem[$sem]))
							{
								$iosem[$sem]=0;
							}
							$iosem[$sem]++;
						}
						else
						{
							If(!isset($iosem[0]))
							{
								$iosem[0]=0;
							}
							$iosem[0]++;
						}
					}
				}
				$datei.="
	         </Student>";
				if($aktstatus=='Student' || $aktstatus=='Diplomand' || $aktstatus=='Praktikant' || $aktstatus=='Outgoing')
				{
					If(!isset($stsem[$sem]))
					{
						$stsem[$sem]=0;
					}
					$stsem[$sem]++;
				}
				if($aktstatus=='Unterbrecher')
				{
					If(!isset($usem[$sem]))
					{
						$usem[$sem]=0;
					}
					$usem[$sem]++;
				}
				if($aktstatus=='Abbrecher')
				{
					If(!isset($asem[$sem]))
					{
						$asem[$sem]=0;
					}
					$asem[$sem]++;
				}
				if($aktstatus=='Absolvent')
				{
					If(!isset($absem[$sem]))
					{
						$absem[$sem]=0;
					}
					$absem[$sem]++;
				}
			}
			//Studentenliste
      			$stlist.="<tr><td align=center>".trim($row->student_uid)."</td><td align=center>".trim($row->matrikelnr)."</td><td>".trim($row->nachname)."</td><td>".trim($row->vorname)."</td><td>".trim($row->status_kurzbz)."</td><td align=center>".trim($sem)."</td></tr>";
		}

		//Bewerber
		$qrybw="SELECT * FROM public.tbl_prestudent
			JOIN public.tbl_prestudentstatus ON(tbl_prestudent.prestudent_id=tbl_prestudentstatus.prestudent_id)
			JOIN public.tbl_person USING(person_id)
			WHERE (studiensemester_kurzbz='".$ssem."') AND tbl_prestudent.studiengang_kz='".$stg_kz."' AND (tbl_prestudentstatus.datum<'".$bisdatum."')
			AND status_kurzbz='Bewerber' AND reihungstestangetreten;
			";
		if($resultbw = $db->db_query($qrybw))
		{
			while($rowbw = $db->db_fetch_object($resultbw))
			{
				If(!isset($bsem[$rowbw->ausbildungssemester]))
				{
					$bsem[$rowbw->ausbildungssemester]=0;
				}
				$bsem[$rowbw->ausbildungssemester]++;
				if($stgart==1 || $stgart==3)
				{
					if(strtoupper($rowbw->geschlecht)=='M')
					{
						If(!isset($bewerberM[$rowbw->zgv_code]))
						{
							$bewerberM[$rowbw->zgv_code]=0;
						}
						$bewerberM[$rowbw->zgv_code]++;
					}
					else
					{
						If(!isset($bewerberW[$rowbw->zgv_code]))
						{
							$bewerberW[$rowbw->zgv_code]=0;
						}
						$bewerberW[$rowbw->zgv_code]++;
					}
				}
				if($stgart==2)
				{
					if(strtoupper($rowbw->geschlecht)=='M')
					{
						If(!isset($bewerberM[$rowbw->zgvmas_code]))
						{
							$bewerberM[$rowbw->zgvmas_code]=0;
						}
						$bewerberM[$rowbw->zgvmas_code]++;
					}
					else
					{
						If(!isset($bewerberW[$rowbw->zgvmas_code]))
						{
							$bewerberW[$rowbw->zgvmas_code]=0;
						}
						$bewerberW[$rowbw->zgvmas_code]++;
					}
				}
				$bewerbercount++;
			}
		}

		if($stgart==1 || $stgart==3)
		{
			for($i=4;$i<100;$i++)
			{
				if(isset($bewerberM[$i]) || isset($bewerberW[$i]))
				{
					If(!isset($bewerberM[$i]))
					{
						$bewerberM[$i]=0;
					}
					If(!isset($bewerberW[$i]))
					{
						$bewerberW[$i]=0;
					}
					$datei.="
		         <Bewerber>
		           <ZugangCode>".$i."</ZugangCode>
		           <AnzBewerberM>".$bewerberM[$i]."</AnzBewerberM>
		           <AnzBewerberW>".$bewerberW[$i]."</AnzBewerberW>
		         </Bewerber>";
				}
			}
		}
		if($stgart==2)
		{
			for($i=1;$i<12;$i++)
			{
				if(isset($bewerberM[$i]) || isset($bewerberW[$i]))
				{
					if(!isset($bewerberM[$i]))
					{
						$bewerberM[$i]=0;
					}
					if(!isset($bewerberW[$i]))
					{
						$bewerberW[$i]=0;
					}
					$datei.="
		         <Bewerber>
		           <ZugangMagStgCode>".$i."</ZugangMagStgCode>
		           <AnzBewerberM>".$bewerberM[$i]."</AnzBewerberM>
		           <AnzBewerberW>".$bewerberW[$i]."</AnzBewerberW>
		         </Bewerber>";
				}
			}
		}
		$datei.="
	</StudiengangDetail>";
	}
}
for($xxx=0; $xxx<9; $xxx++)
{
	If(!isset($stsem[$xxx]))
	{
		$stsem[$xxx]=0;
	}
	If(!isset($usem[$xxx]))
	{
		$usem[$xxx]=0;
	}
	If(!isset($asem[$xxx]))
	{
		$asem[$xxx]=0;
	}
	If(!isset($absem[$xxx]))
	{
		$absem[$xxx]=0;
	}
	If(!isset($iosem[$xxx]))
	{
		$iosem[$xxx]=0;
	}
	if($orgform==3)
	{
		If(!isset($stsema[$xxx]))
		{
			$stsema[$xxx]=0;
		}
		If(!isset($usema[$xxx]))
		{
			$usema[$xxx]=0;
		}
		If(!isset($asema[$xxx]))
		{
			$asema[$xxx]=0;
		}
		If(!isset($absema[$xxx]))
		{
			$absema[$xxx]=0;
		}
		If(!isset($iosema[$xxx]))
		{
			$iosema[$xxx]=0;
		}
	}
}
If(!isset($stsem[50]))
{
	$stsem[50]=0;
}
If(!isset($usem[50]))
{
	$usem[50]=0;
}
If(!isset($asem[50]))
{
	$asem[50]=0;
}
If(!isset($absem[50]))
{
	$absem[50]=0;
}
If(!isset($iosem[50]))
{
	$iosem[50]=0;
}
If(!isset($stsem[60]))
{
	$stsem[60]=0;
}
If(!isset($usem[60]))
{
	$usem[60]=0;
}
If(!isset($asem[60]))
{
	$asem[60]=0;
}
If(!isset($absem[60]))
{
	$absem[60]=0;
}
If(!isset($iosem[60]))
{
	$iosem[60]=0;
}
if($orgform==3)
{
	If(!isset($stsema[50]))
	{
		$stsema[50]=0;
	}
	If(!isset($usema[50]))
	{
		$usema[50]=0;
	}
	If(!isset($asema[50]))
	{
		$asema[50]=0;
	}
	If(!isset($absema[50]))
	{
		$absema[50]=0;
	}
	If(!isset($iosema[50]))
	{
		$iosema[50]=0;
	}
	If(!isset($stsema[60]))
	{
		$stsema[60]=0;
	}
	If(!isset($usema[60]))
	{
		$usema[60]=0;
	}
	If(!isset($asema[60]))
	{
		$asema[60]=0;
	}
	If(!isset($absema[60]))
	{
		$absema[60]=0;
	}
	If(!isset($iosema[60]))
	{
		$iosema[60]=0;
	}
}
$datei.="
    </StudiengangStamm>
  </StudierendenBewerberMeldung>
</Erhalter>";
echo '	<html><head><title>BIS - Meldung Student - ('.$stg_kz.')</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="../../skin/vilesci.css" rel="stylesheet" type="text/css">
	</head><body>';
echo "<H1>BIS - Studentendaten werden &uuml;berpr&uuml;ft! Studiengang: ".$stg_kz."</H1>\n";
echo "<H2>Nicht plausible BIS-Daten (f&uuml;r Meldung ".$ssem."): </H2><br>";
echo nl2br($v."\n\n");

//Tabelle mit Ergebnissen ausgeben
$tabelle="<H2>BIS-Meldungs&uuml;bersicht: </H2><br>
<table border=1>
<tr align=center>
	<colgroup>
		<col width='120'>
		<col width='50'>
		<col width='50'>
		<col width='50'>
		<col width='50'>
		<col width='50'>
		<col width='50'>
		<col width='50'>
		<col width='50'>
		<col width='50'>
		<col width='50'>
	</colgroup>
	<th bgcolor='AFFA49'>Semester</th>
	<th bgcolor='AFFA49'>1</th>
	<th bgcolor='AFFA49'>2</th>
	<th bgcolor='AFFA49'>3</th>
	<th bgcolor='AFFA49'>4</th>
	<th bgcolor='AFFA49'>5</th>
	<th bgcolor='AFFA49'>6</th>
	<th bgcolor='AFFA49'>7</th>
	<th bgcolor='AFFA49'>8</th>
	<th bgcolor='AFFA49'>50</th>
	<th bgcolor='AFFA49'>60</th>
</tr>";
if($orgform==3)
{
	//Studiengangtyp Mischform
	$tabelle.="
	<tr align=center>
		<td bgcolor='AFFA49'>aktive Studenten (vz/bb)</td>
		<td>".$stsem[1].' / '.$stsema[1]."</td>
		<td>".$stsem[2].' / '.$stsema[2]."</td>
		<td>".$stsem[3].' / '.$stsema[3]."</td>
		<td>".$stsem[4].' / '.$stsema[4]."</td>
		<td>".$stsem[5].' / '.$stsema[5]."</td>
		<td>".$stsem[6].' / '.$stsema[6]."</td>
		<td>".$stsem[7].' / '.$stsema[7]."</td>
		<td>".$stsem[8].' / '.$stsema[8]."</td>
		<td>".$stsem[50].' / '.$stsema[50]."</td>
		<td>".$stsem[60].' / '.$stsema[60]."</td>
	</tr>
	<tr align=center>
		<td bgcolor='AFFA49'>Unterbrecher (vz/bb)</td>
		<td>".$usem[1].' / '.$usema[1]."</td>
		<td>".$usem[2].' / '.$usema[2]."</td>
		<td>".$usem[3].' / '.$usema[3]."</td>
		<td>".$usem[4].' / '.$usema[4]."</td>
		<td>".$usem[5].' / '.$usema[5]."</td>
		<td>".$usem[6].' / '.$usema[6]."</td>
		<td>".$usem[7].' / '.$usema[7]."</td>
		<td>".$usem[8].' / '.$usema[8]."</td>
		<td>".$usem[50].' / '.$usema[50]."</td>
		<td>".$usem[60].' / '.$usema[60]."</td>
	</tr>
	<tr align=center>
		<td bgcolor='AFFA49'>Abbrecher (vz/bb)</td>
		<td>".$asem[1].' / '.$asema[1]."</td>
		<td>".$asem[2].' / '.$asema[2]."</td>
		<td>".$asem[3].' / '.$asema[3]."</td>
		<td>".$asem[4].' / '.$asema[4]."</td>
		<td>".$asem[5].' / '.$asema[5]."</td>
		<td>".$asem[6].' / '.$asema[6]."</td>
		<td>".$asem[7].' / '.$asema[7]."</td>
		<td>".$asem[8].' / '.$asema[8]."</td>
		<td>".$asem[50].' / '.$asema[50]."</td>
		<td>".$asem[60].' / '.$asema[60]."</td>
	</tr>
	<tr align=center>
		<td bgcolor='AFFA49'>Absolventen (vz/bb)</td>
		<td>".$absem[1].' / '.$absema[1]."</td>
		<td>".$absem[2].' / '.$absema[2]."</td>
		<td>".$absem[3].' / '.$absema[3]."</td>
		<td>".$absem[4].' / '.$absema[4]."</td>
		<td>".$absem[5].' / '.$absema[5]."</td>
		<td>".$absem[6].' / '.$absema[6]."</td>
		<td>".$absem[7].' / '.$absema[7]."</td>
		<td>".$absem[8].' / '.$absema[8]."</td>
		<td>".$absem[50].' / '.$absema[50]."</td>
		<td>".$absem[60].' / '.$absema[60]."</td></b>
	</tr>
	<tr align=center>
		<td bgcolor='AFFA49'>I/O (vz/bb)</td>
		<td>".$iosem[1].' / '.$iosema[1]."</td>
		<td>".$iosem[2].' / '.$iosema[2]."</td>
		<td>".$iosem[3].' / '.$iosema[3]."</td>
		<td>".$iosem[4].' / '.$iosema[4]."</td>
		<td>".$iosem[5].' / '.$iosema[5]."</td>
		<td>".$iosem[6].' / '.$iosema[6]."</td>
		<td>".$iosem[7].' / '.$iosema[7]."</td>
		<td>".$iosem[8].' / '.$iosema[8]."</td>
		<td>".$iosem[50].' / '.$iosema[50]."</td>
		<td>".$iosem[60].' / '.$iosema[60]."</td>
	</tr>
	<tr align=center style='border-top:1px solid black'>
		<td bgcolor='AFFA49'>Incoming (vz/bb)</td>
		<td>".($iosem[0]+$iosema[0])."</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr align=center>";
}
else
{
	$tabelle.="
	<tr align=center>
		<td bgcolor='AFFA49'>aktive Studenten</td>
		<td>".$stsem[1]."</td>
		<td>".$stsem[2]."</td>
		<td>".$stsem[3]."</td>
		<td>".$stsem[4]."</td>
		<td>".$stsem[5]."</td>
		<td>".$stsem[6]."</td>
		<td>".$stsem[7]."</td>
		<td>".$stsem[8]."</td>
		<td>".$stsem[50]."</td>
		<td>".$stsem[60]."</td>
	</tr>
	<tr align=center>
		<td bgcolor='AFFA49'>Unterbrecher</td>
		<td>".$usem[1]."</td>
		<td>".$usem[2]."</td>
		<td>".$usem[3]."</td>
		<td>".$usem[4]."</td>
		<td>".$usem[5]."</td>
		<td>".$usem[6]."</td>
		<td>".$usem[7]."</td>
		<td>".$usem[8]."</td>
		<td>".$usem[50]."</td>
		<td>".$usem[60]."</td>
	</tr>
	<tr align=center>
		<td bgcolor='AFFA49'>Abbrecher</td>
		<td>".$asem[1]."</td>
		<td>".$asem[2]."</td>
		<td>".$asem[3]."</td>
		<td>".$asem[4]."</td>
		<td>".$asem[5]."</td>
		<td>".$asem[6]."</td>
		<td>".$asem[7]."</td>
		<td>".$asem[8]."</td>
		<td>".$asem[50]."</td>
		<td>".$asem[60]."</td>
	</tr>
	<tr align=center>
		<td bgcolor='AFFA49'>Absolventen</td>
		<td>".$absem[1]."</td>
		<td>".$absem[2]."</td>
		<td>".$absem[3]."</td>
		<td>".$absem[4]."</td>
		<td>".$absem[5]."</td>
		<td>".$absem[6]."</td>
		<td>".$absem[7]."</td>
		<td>".$absem[8]."</td>
		<td>".$absem[50]."</td>
		<td>".$absem[60]."</td></b>
	</tr>
	<tr align=center>
		<td bgcolor='AFFA49'>I/O</td>
		<td>".$iosem[1]."</td>
		<td>".$iosem[2]."</td>
		<td>".$iosem[3]."</td>
		<td>".$iosem[4]."</td>
		<td>".$iosem[5]."</td>
		<td>".$iosem[6]."</td>
		<td>".$iosem[7]."</td>
		<td>".$iosem[8]."</td>
		<td>".$iosem[50]."</td>
		<td>".$iosem[60]."</td>
	</tr>
	<tr align=center style='border-top:1px solid black'>
		<td bgcolor='AFFA49'>Incoming</td>
		<td>".$iosem[0]."</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr align=center>";
}
if($orgform==3)
{
	$tabelle.= "
	<td bgcolor='AFFA49'>Bewerber(ges./vz/bb)</td>
	<td bgcolor='DED8FE'>".$bewerbercount."</td>
	<td bgcolor='DED8FE'>".$bewerbercountvz.' / '.$bewerbercountbb."</td>";
}
else
{
	$tabelle.= "
	<td bgcolor='AFFA49'>Bewerber</td>
	<td bgcolor='DED8FE'>".$bewerbercount."</td>
	<td></td>";
}
	$tabelle.= "
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td bgcolor='#FF0000'>".$zaehl."</td>
</tr>
</table>
<br>";
echo $tabelle;

//------------------------------------------------------------------------------------------------------------------------
$ddd='bisdaten/bismeldung_'.$ssem.'_Stg'.$stg_kz.'.xml';
$eee='bisdaten/tabelle_'.$ssem.'_Stg'.$stg_kz.'.html';

if(file_exists($ddd))
{
	echo "<a href=$ddd>XML-Datei f&uuml;r BIS-Meldung Stg ".$stg_kz."</a><br>";
}
if(file_exists($eee))
{
	echo "<a href=$eee>BIS-Melde&uuml;bersicht der BIS-Meldung Stg ".$stg_kz."</a><br><br>";
}

$stlist="<table border=1>
	<tr align=center>
		<colgroup>
			<col width='40'>
			<col width='40'>
			<col width='120'>
			<col width='120'>
			<col width='50'>
			<col width='30'>

		</colgroup>
		<th>UID</th>
		<th>Matrikelnr</th>
		<th>Nachname</th>
		<th>Vorname</th>
		<th>Status</th>
		<th>Semester</th>
	</tr>
	".$stlist."
	</table>";


echo $stlist;

#if(trim(substr(CONN_STRING,strpos(CONN_STRING,'dbname=')+7,strpos(CONN_STRING,'user=')-strpos(CONN_STRING,'dbname=')-7))=='vilesci'
#	|| trim(substr(CONN_STRING,strpos(CONN_STRING,'dbname=')+7,strpos(CONN_STRING,'user=')-strpos(CONN_STRING,'dbname=')-7))=='devvilesci')
#if (DB_NAME=='vilesci' || DB_NAME=='devvilesci')
if (DB_NAME=='vilesci')
{
	mail('ruhan@technikum-wien.at', 'Plausicheck BIS-Meldung von '.$_SERVER['HTTP_HOST'].', Stg: '.
	$stg_kz, "<html><body>".$tabelle."</body></html>","From: vilesci@technikum-wien.at\nX-Mailer: PHP 5.x\nContent-type: text/html; charset=utf-8");
}

//}
?>