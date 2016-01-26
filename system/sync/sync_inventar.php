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
 * Authors: Christian Paminger 	< christian.paminger@technikum-wien.at >
 *          Andreas Oesterreicher 	< andreas.oesterreicher@technikum-wien.at >
 *          Rudolf Hangl 		< rudolf.hangl@technikum-wien.at >
 *          Gerald Simane-Sequens 	< gerald.simane-sequens@technikum-wien.at >
 */
/**
 * Syncronisiert die Inventardaten ins FH-Complete
 */
	header( 'Expires:  -1' );
	header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
	header( 'Cache-Control: no-store, no-cache, must-revalidate' );
	header( 'Pragma: no-cache' );
   	header('Content-Type: text/html;charset=UTF-8');

	require_once('../../config/vilesci.config.inc.php');
	require_once('../../include/basis_db.class.php');
  	require_once('../../include/functions.inc.php');
	require_once('../../include/mitarbeiter.class.php');
	require_once('../../include/berechtigung.class.php');
	require_once('../../include/benutzerberechtigung.class.php');
	require_once('../../include/ort.class.php');
	require_once('../../include/studiengang.class.php');
  	require_once('../../include/organisationseinheit.class.php');	
  	require_once('../../include/wawi.class.php');
  	require_once('../../include/betriebsmittel.class.php');
  	require_once('../../include/betriebsmitteltyp.class.php');
  	require_once('../../include/betriebsmittelstatus.class.php');
  	require_once('../../include/betriebsmittel_betriebsmittelstatus.class.php');
  	
	if (!$uid = get_uid())
		die('Keine UID gefunden !  <a href="javascript:history.back()">Zur&uuml;ck</a>');

	//Berechtigung pruefen				
	$oBenutzerberechtigung = new benutzerberechtigung();
	// Init
	$oBenutzerberechtigung->errormsg='';
	$oBenutzerberechtigung->berechtigungen=array();
	// read Berechtigung
	if (!$oBenutzerberechtigung->isBerechtigt('admin',null, 'suid') && !$oBenutzerberechtigung->getBerechtigungen($uid))
		die('Sie haben keine Berechtigung f&uuml;r diese Seite !  <a href="javascript:history.back()">Zur&uuml;ck</a>');
	
	$art='suid';	
	$oe_kurzbz='';
	
	$berechtigung_kurzbz='wawi/inventar';
	if(!$oBenutzerberechtigung->isBerechtigt('admin',null, 'suid') && !$oBenutzerberechtigung->isBerechtigt($berechtigung_kurzbz,($oe_kurzbz?$oe_kurzbz:null), $art))
		die('Sie haben keine Berechtigung f&uuml;r diese Seite !  <a href="javascript:history.back()">Zur&uuml;ck</a>');
	
		
	//Rollen und Berechtigungen anlegen
	$oBerechtigung = new berechtigung();

	$oBerechtigung->rolle_kurzbz='wawi';
	$oBerechtigung->beschreibung='Betriebsmittel - Inventar';
	@$oBerechtigung->saveRolle(true);
	
	$oBerechtigung->art='suid';
	$oBerechtigung->rolle_kurzbz='wawi';
	$oBerechtigung->berechtigung_kurzbz='wawi/inventar';	

	$qry = "INSERT INTO system.tbl_rolle(rolle_kurzbz, beschreibung) VALUES('".$oBerechtigung->rolle_kurzbz."','".$oBerechtigung->beschreibung."');";
	@$oBerechtigung->db_query($qry);
	$qry = "INSERT INTO system.tbl_berechtigung(berechtigung_kurzbz, beschreibung) VALUES('".$oBerechtigung->berechtigung_kurzbz."','".$oBerechtigung->beschreibung."');";
	@$oBerechtigung->db_query($qry);

	$oBerechtigung->art='suid';
	$oBerechtigung->rolle_kurzbz='wawi';
	$oBerechtigung->berechtigung_kurzbz='wawi/inventar';
	@$oBerechtigung->saveRolle(true);	

		
	unset($oBenutzerberechtigung);

// ------------------------------------------------------------------------------------------
// Parameter Aufruf uebernehmen
// ------------------------------------------------------------------------------------------
  	$debug=trim(isset($_REQUEST['debug']) ? $_REQUEST['debug']:false);
  	$first=trim(isset($_REQUEST['first']) ? $_REQUEST['first']:true);
// ------------------------------------------------------------------------------------------
// Initialisierung
// ------------------------------------------------------------------------------------------
	$query='';
	$errormsg=array();
	$default_afa_jahre=5;

	$betriebsmittelstatus_kurzbz_vorhanden='vorhanden';
	$betriebsmittelstatus_kurzbz_verliehen='Inventar Extern';
	$betriebsmittelstatus_kurzbz_inventur='Inventur';

// ------------------------------------------------------------------------------------------
//	Datenbankanbindung
// ------------------------------------------------------------------------------------------
	//  Original Inventardaten
	define("CONN_STRING_INVENTAR","host=10.63.0.65 port=5432 dbname=inventar8 user=oesi password=1q2w3");
##	define("CONN_STRING_INVENTAR","host=10.4.8.22 port=5432 dbname=inventar user=schmudermayer password=inventar");
	$schema_inventar='public';

	// DB Result
	$result = array();
	if(!$conn_inventar = pg_pconnect(CONN_STRING_INVENTAR))
		die('Fehler beim Herstellen der Inventar Connection');

#	$query = "SET CLIENT_ENCODING TO 'UNICODE';";
#	if(!pg_query($conn_inventar,$query))
#		echo "<br />"."Encoding konnte nicht gesetzt werden";


	$oStudiengang = new Studiengang();
	$oStudiengang->result=array();
	$oStudiengang->errormsg='';	

	$oOrganisationseinheit = new organisationseinheit();
	$oOrganisationseinheit->result=array();
	$oOrganisationseinheit->errormsg='';		
	
	// Classen
	$oWawi = new wawi();
	$oWawi->debug=$debug;
	$oWawi->errormsg='';		

// ------------------------------------------------------------------------------------------
// Start Inventardaten - Tabellen konvertieren, und ubernehmen in die Betriebsmittel
// ------------------------------------------------------------------------------------------
		echo '<p  style="color:navy;">START *** File:='.__FILE__.' Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').'</p>';
	
// ------------------------------------------------------------------------------------------
//
// -------------- Alter Table
//
// ------------------------------------------------------------------------------------------
		// neue Felder fuer die Datenuebernahme in die Tabelle einfuegen (Originalwerte erhalten)
		$query='ALTER TABLE '.$schema_inventar.'.inventgrouptable add betriebsmitteltyp character(16) DEFAULT \'\' '."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		// ---- Neues Typenfeld und die Betriebsmittel in die Inventortabelle uebertragen
		$query='ALTER TABLE '.$schema_inventar.'.inventtable add betriebsmitteltyp character(16)  DEFAULT \'\''."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		// ---- Neues Typenfeld und die Betriebsmittel in die Inventortabelle uebertragen
		$query='ALTER TABLE '.$schema_inventar.'.inventtable add betriebsmittelstatus_kurzbz character(16)  DEFAULT \'\''."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		$query='ALTER TABLE '.$schema_inventar.'.inventtable add ort_kurzbz character(16)  DEFAULT \'\''."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		// neue Felder fuer die Datenuebernahme in die Tabelle einfuegen (Originalwerte erhalten)
		$query='ALTER TABLE '.$schema_inventar.'.statustable add betriebsmittelstatus_kurzbz character(16)   DEFAULT \'\' '."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
		
		$query='ALTER TABLE '.$schema_inventar.'.locationtable add ort_kurzbz character(16)  DEFAULT \'\''."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		$query='ALTER TABLE '.$schema_inventar.'.locationtable add ort_kurzbz_gefunden character(16)  DEFAULT \'\''."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		$query='ALTER TABLE '.$schema_inventar.'.locationtable add bezeichnung character(256)  DEFAULT \'\''."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;


		$query='ALTER TABLE '.$schema_inventar.'.inventtable add statusid integer DEFAULT \'0\' '."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />Fehler bei Tabelle ".$schema_inventar.".inventtable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		$query='ALTER TABLE '.$schema_inventar.'.inventtable add oe_kurzbz character(32)  DEFAULT \'\' '."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />Fehler bei Tabelle ".$schema_inventar.".inventtable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

	
		$oBetriebsmittel = new betriebsmitteltyp();
		$oBetriebsmittel->debug=$debug;
		$oBetriebsmittel->errormsg='';	

		$oBetriebsmittel->db_query('delete from wawi.tbl_betriebsmittelperson where betriebsmittel_id in (select betriebsmittel_id from wawi.tbl_betriebsmittel_betriebsmittelstatus );
					delete from wawi.tbl_betriebsmittel where betriebsmittel_id in (select betriebsmittel_id from wawi.tbl_betriebsmittel_betriebsmittelstatus );
					delete from wawi.tbl_betriebsmittel_betriebsmittelstatus ;');
					

// ------------------------------------------------------------------------------------------
//
// -------------- Betriebsmitteltypen
//
// ------------------------------------------------------------------------------------------
	
		$oBetriebsmitteltyp = new betriebsmitteltyp();
		$oBetriebsmitteltyp->debug=$debug;
		$oBetriebsmitteltyp->errormsg='';	
	
		echo '<hr /><p style="color:navy;">Betriebsmitteltypen  '.$schema_inventar.'.inventgrouptable Start Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').'</p>';
		if ($oBetriebsmitteltyp->getAll())
			echo "<b>Betriebsmitteltypen Start Anzahl</b> ".count($oBetriebsmitteltyp->result);

		//-----------------------
		//  Betriebmittelstypen
		//-----------------------
		$query='Update '.$schema_inventar.'.inventgrouptable set inventgroupid=trim(inventgroupid),inventgroupname=trim(inventgroupname),betriebsmitteltyp=substr(translate(inventgroupname,\'ä\',\'ae\'),0,16) '."; \r\n ";
		if (!pg_query($conn_inventar,$query))
			die("<br />Fehler bei Tabelle ".$schema_inventar.".inventgrouptable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);

		// Lesen der Inventgrouptable und mit der Classe in die Betriebsmitteltyp - Tabelle uebernehmen
		$query='select * from '.$schema_inventar.'.inventgrouptable order by betriebsmitteltyp '."; \r\n ";
		if (!$result=pg_query($conn_inventar,$query))
			die("<br />Fehler bei Tabelle ".$schema_inventar.".inventgrouptable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);

		/* ------------------ tbl_betriebsmitteltyp
		  betriebsmitteltyp character varying(16) NOT NULL,
		  beschreibung character varying(256),
		  anzahl smallint,
		  kaution numeric(6,2),
		  typ_code character(2), -- Fuer Inventarnummerncode
		*/
		while($row = pg_fetch_object($result))
		{
			$row->betriebsmitteltyp=trim($row->betriebsmitteltyp);
			$row->inventgroupname=trim($row->inventgroupname);
			$row->inventgroupid=trim($row->inventgroupid);
	
			if (empty($row->betriebsmitteltyp))
				continue;
			// Check ob NEU oder AENDERN
			if ($oBetriebsmitteltyp->load($row->betriebsmitteltyp))
				$oBetriebsmitteltyp->new=false;
			else
				$oBetriebsmitteltyp->new=true;
	
			$oBetriebsmitteltyp->betriebsmitteltyp=$row->betriebsmitteltyp;
			$oBetriebsmitteltyp->beschreibung=$row->inventgroupname;
			$oBetriebsmitteltyp->anzahl=0;
			$oBetriebsmitteltyp->kaution=0;
			$oBetriebsmitteltyp->typ_code=$row->inventgroupid;
			if (!$oBetriebsmitteltyp->save())
				echo "<br />".$oBetriebsmitteltyp->errormsg.' Key:='.$row->betriebsmitteltyp.' Line:='.__LINE__;
		}
		if ($result)
			unset($result);

		// Laptop - bestehender BetriebsmitteltypenDatensatz   mit einem TypCode erweitern - soll gueltig auch fuer Schmudi werden
		$oBetriebsmitteltyp->betriebsmitteltyp='Laptop';
		$oBetriebsmitteltyp->beschreibung='Laptop';
		$oBetriebsmitteltyp->anzahl=0;
		$oBetriebsmitteltyp->kaution=0;
		$oBetriebsmitteltyp->typ_code='08';
		if (!$oBetriebsmitteltyp->save(false))
			echo "<br />".$oBetriebsmitteltyp->errormsg.' '.$oBetriebsmitteltyp->db_last_error().' Key:='.$row->betriebsmitteltyp.' Line:='.__LINE__;
		// Zutrittskarte - bestehender BetriebsmitteltypenDatensatz   mit einem TypCode erweitern - soll gueltig auch fuer Schmudi werden
		$oBetriebsmitteltyp->betriebsmitteltyp='Zutrittskarte';
		$oBetriebsmitteltyp->beschreibung='Zutrittskarte';
		$oBetriebsmitteltyp->anzahl=0;
		$oBetriebsmitteltyp->kaution=0;
		$oBetriebsmitteltyp->typ_code='09';
		if (!$oBetriebsmitteltyp->save(false))
			echo "<br />".$oBetriebsmitteltyp->errormsg.' '.$oBetriebsmitteltyp->db_last_error().' Key:='.$row->betriebsmitteltyp.' Line:='.__LINE__;
		// Schluessel - bestehender BetriebsmitteltypenDatensatz   mit einem TypCode erweitern - soll gueltig auch fuer Schmudi werden
		$oBetriebsmitteltyp->betriebsmitteltyp='Schluessel';
		$oBetriebsmitteltyp->beschreibung='Schluessel';
		$oBetriebsmitteltyp->anzahl=0;
		$oBetriebsmitteltyp->kaution=0;
		$oBetriebsmitteltyp->typ_code='10';
		if (!$oBetriebsmitteltyp->save(false))
			echo "<br />".$oBetriebsmitteltyp->errormsg.' '.$oBetriebsmitteltyp->db_last_error().' Key:='.$row->betriebsmitteltyp.' Line:='.__LINE__;

		// Prueft die Beschreibung der Betriebsmitteltyp - leer wird der Typ als Beschreibung verwendet
		if (!$oBetriebsmitteltyp->check_beschreibung())
			echo "<br />".$oBetriebsmitteltyp->errormsg.' '.$oBetriebsmitteltyp->db_last_error().' Line:='.__LINE__;

		//------------------------------------------------------
		// Betriebmittelstypen in die Inventtable uebernehmen
		// die Ermittelten Typen von der Betriebsmitteltyp-Tabelle in die Inventartabelle laden
		//------------------------------------------------------
		$query='Update '.$schema_inventar.'.inventtable set betriebsmitteltyp=trim((SELECT betriebsmitteltyp FROM '.$schema_inventar.'.inventgrouptable where trim(inventgrouptable.inventgroupid)=trim(inventtable.inventgroup))) ';
		if (!pg_query($conn_inventar,$query))
			echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
		// Ende mit ermittlung der aktuellen Anzahl - Datensaetze
		if ($oBetriebsmitteltyp->getAll())
			echo "<br /><b>Betriebsmitteltypen Ende Anzahl</b> ".count($oBetriebsmitteltyp->result);

		echo '<p style="color:navy;">Betriebsmitteltypen  '.$schema_inventar.'.inventgrouptable Ende Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').'</p>';
		if ($oBetriebsmitteltyp)
			unset($oBetriebsmitteltyp);
		
// ------------------------------------------------------------------------------------------
//
// ---------------- Betriebsmittelstatus
//
// ------------------------------------------------------------------------------------------
	
		$oBetriebsmittelstatus = new betriebsmittelstatus();
		$oBetriebsmittelstatus->debug=$debug;
		$oBetriebsmittelstatus->errormsg='';
			
		echo '<hr /><p style="color:navy;">Betriebsmittelstatus  '.$schema_inventar.'.statustable Start Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').'</p>';
		if ($oBetriebsmittelstatus->getAll())
			echo "<br /><b>Betriebsmittelstatus Start Anzahl</b> ".count($oBetriebsmittelstatus->result);

		// Statusbezeichnung anpassen
		$query='UPDATE  '.$schema_inventar.'.statustable set bezeichnung=\'Reparatur\' where statusid=2'."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
		$query='UPDATE  '.$schema_inventar.'.statustable set bezeichnung=\''.$betriebsmittelstatus_kurzbz_verliehen.'\' where statusid=3'."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
		$query='UPDATE  '.$schema_inventar.'.statustable set bezeichnung=\'ausgeschieden\' where statusid=4'."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		// Status f&uuml;r Locationen die in der Orttabelle nicht mehr abgebildet werden z.B. ??? = Diebstahl
		$query='INSERT INTO  '.$schema_inventar.'.statustable (statusid,changed, bezeichnung) VALUES(5,0,\'Vandalismus\')'."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />Fehler bei Tabelle ".$schema_inventar.".statustable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		$query='INSERT INTO  '.$schema_inventar.'.statustable (statusid,changed, bezeichnung) VALUES(6,0,\'Diebstahl\')'."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />Fehler bei Tabelle ".$schema_inventar.".statustable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		$query='INSERT INTO  '.$schema_inventar.'.statustable (statusid,changed, bezeichnung) VALUES(7,0,\'Aenderung\')'."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />Fehler bei Tabelle ".$schema_inventar.".statustable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		$query='INSERT INTO  '.$schema_inventar.'.statustable (statusid,changed, bezeichnung) VALUES(8,0,\''.$betriebsmittelstatus_kurzbz_inventur.'\')'."; \r\n ";
		if (!@pg_query($conn_inventar,$query))
			$errormsg[]="<br />Fehler bei Tabelle ".$schema_inventar.".statustable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

		$query='Update '.$schema_inventar.'.statustable set bezeichnung=trim(bezeichnung),betriebsmittelstatus_kurzbz=substr(trim(bezeichnung),0,25) '."; \r\n ";
		if (!pg_query($conn_inventar,$query))
			die("<br />Fehler bei Tabelle ".$schema_inventar.".statustable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);

		// Lesen der Statustable und mit der Classe in die Betriebsmittelstatus - Tabelle uebernehmen
		$query='select * from '.$schema_inventar.'.statustable order by betriebsmittelstatus_kurzbz '."; \r\n ";
		if (!$result=pg_query($conn_inventar,$query))
			die("<br />Fehler bei Tabelle ".$schema_inventar.".statustable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);

		/* ------------------ tbl_betriebsmittelstatus
		  betriebsmittelstatus_kurzbz character varying(16) NOT NULL,
		  beschreibung character varying(256),
		*/
		while($row = pg_fetch_object($result))
		{
			// entfernen eventuelle Leerzeichen im Keyfeld  
			$row->betriebsmittelstatus_kurzbz=trim($row->betriebsmittelstatus_kurzbz);
			if (empty($row->betriebsmittelstatus_kurzbz))
				continue;
			// Check ob Neualage oder Update des Betriebsmittelstatus erfolgen soll
			if ($oBetriebsmittelstatus->load($row->betriebsmittelstatus_kurzbz))
				$oBetriebsmittelstatus->new=false;
			else
				$oBetriebsmittelstatus->new=true;

			$oBetriebsmittelstatus->betriebsmittelstatus_kurzbz=$row->betriebsmittelstatus_kurzbz;
			$oBetriebsmittelstatus->beschreibung=$row->bezeichnung;
			if (!$oBetriebsmittelstatus->save())
				echo "<br />".$oBetriebsmittelstatus->errormsg .$oBetriebsmittelstatus->db_last_error().' Key:='.$row->betriebsmittelstatus_kurzbz;
		}
		if ($result)
			unset($result);

		//------------------------------------------------------
		//  Betriebmittelstatus in die Inventtable uebernehmen
		// die Ermittelten Typen von der Betriebsmitteltyp-Tabelle in die Inventartabelle laden
		//------------------------------------------------------
		$query='Update '.$schema_inventar.'.inventtable set betriebsmittelstatus_kurzbz=trim((SELECT betriebsmittelstatus_kurzbz FROM '.$schema_inventar.'.statustable where statustable.statusid=inventtable.status)) ';
		if (!pg_query($conn_inventar,$query))
				die("<br />Fehler bei Tabelle ".$schema_inventar.".inventtable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);

		// Ende mit ermittlung der aktuellen Anzahl - Datensaetze
		if ($oBetriebsmittelstatus->getAll())
			echo "<br /><b>Betriebsmittelstatus Ende Anzahl</b>".count($oBetriebsmittelstatus->result);

		echo '<p style="color:navy;">Betriebsmittelstatus  '.$schema_inventar.'.statustable Ende Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').'</p>';
		if($oBetriebsmittelstatus)
			unset($oBetriebsmittelstatus);
	
// ------------------------------------------------------------------------------------------
//
// -------------------- Locationstable
//
// ------------------------------------------------------------------------------------------
		echo '<hr /><p style="color:navy;">Locationstable  '.$schema_inventar.'.locationtable Start Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').' <p>';

		$oOrt = new ort();
		$oOrt->result=array();
		$oOrt->errormsg='';
	
		//----------------------------------------------------------------------------
		//  ort_kurzbz kann vorbelegt werden - dieses wird genommen zur Ort ermittlung
		//  - fuer Sonderorte z.B. ??? wird DUMMY als Ort genommen
		//----------------------------------------------------------------------------
		// 00 Inventar Extern (TGM / Home etc.) => Schmudi Raum
		$query='Update '.$schema_inventar.'.locationtable set ort_kurzbz=trim(\'EXT1\') where locationid=\'00\'; ';
		if (!pg_query($conn_inventar,$query))
			die("<br />Fehler bei Tabelle ".$schema_inventar.".locationtable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);

		// E.04 Robotunit-Raum => E.04 LAB_A0.04 Robotunits-Labor
		$query='Update '.$schema_inventar.'.locationtable set ort_kurzbz=trim(\'LAB_A0.04\') where locationid=\'E.04\'; ';
		if (!pg_query($conn_inventar,$query))
			die("<br />Fehler bei Tabelle ".$schema_inventar.".locationtable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);

		// Diverse Raeume
		$query='Update '.$schema_inventar.'.locationtable set ort_kurzbz=trim(\'DUMMY\') where trim(locationid)=\'??\' or trim(locationid)=\'???\' or trim(locationid)=\'$$$$\'  or trim(locationid)=\'x1\' or trim(locationid)=\'xx\' or trim(locationid)=\'xxx\'  or trim(locationid)=\'xxx6\' ; ';
		if (!pg_query($conn_inventar,$query))
			die("<br />Fehler bei Tabelle ".$schema_inventar.".locationtable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);

		// Lesen Location - Inventarort
		$query='select * from '.$schema_inventar.'.locationtable where ort_kurzbz_gefunden=\'\'  order by locationid '."; \r\n ";
		if (!$result=pg_query($conn_inventar,$query))
			die("<br />Fehler bei Tabelle ".$schema_inventar.".locationtable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);
		else
		{
			// Lesen alle Stellplaetze
			while($row = pg_fetch_object($result))
			{
					$row->ort_kurzbz=trim($row->ort_kurzbz);
					$row->bezeichnung=trim($row->bezeichnung);
					$row->ort_kurzbz_gefunden=trim($row->ort_kurzbz_gefunden);

					echo '<br /><b style="color:navy;">LOCATION::  locationid==>'.$row->locationid.'  |||    locationname ==>'.$row->locationname  .($row->ort_kurzbz?' ('.$row->ort_kurzbz .' |||| '.$row->bezeichnung.')  ':'').'</b>';

					if (!empty($row->ort_kurzbz_gefunden))
					{
						echo "<br /><b style='color:navy;'> Erfolgreich bereits erledigt *********  ".$row->locationid.' '.$row->locationname." </b><hr />";
						continue;
					}

					$rowss=array(); // Datencontainer fuer ermittelte Standorte
					$variante='';	// Treffer - Variantenvariable fuer Endausgabe

					// suchen in Ort nach der Location
#					$query = 'SELECT * FROM public.tbl_ort where ort_kurzbz like '."'%".str_replace(array('.E','.'),'%',trim($row->locationid))."%'";
					// Versuch - 1
					if ($row->ort_kurzbz && !is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 1';
						$loc=$row->ort_kurzbz;
						$query = 'SELECT * FROM public.tbl_ort where aktiv and ort_kurzbz='."'".$loc."'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.' (ort_kurzbz==>'.$loc.')   ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}

					// Versuch - 2
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 2';
						$loc=str_replace(array(' ',';',',','.'),'%',trim($row->locationid));
						$query = 'SELECT * FROM public.tbl_ort where aktiv and ort_kurzbz like '."'%".$loc."%'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.' (ort_kurzbz==>'.$loc.')   ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;

							}
						}
					}

					// Versuch - 3
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 3';
						$loc=str_replace(array('E.',',','.'),'%',trim($row->locationid));
						$query = 'SELECT * FROM public.tbl_ort where aktiv and ort_kurzbz like '."'%".$loc."%'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.' (ort_kurzbz==>'.$loc.')    ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}

					// Versuch - 4
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 4';
						$loc=str_replace(array('E.',',','.'),'%',str_replace(array('E.E.',',','.'),'E%',trim($row->locationid)));
						$query = 'SELECT * FROM public.tbl_ort where aktiv and planbezeichnung  like '."'%".$loc."%'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.' (Planbezeichnung==> '.$loc.')  ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}

					// Versuch - 5
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 5';
						$query = "SELECT * FROM public.tbl_ort where aktiv and trim(planbezeichnung)='".trim($row->locationid)."'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.'  ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}

					// Versuch - 6
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 6';
						$query = 'SELECT * FROM public.tbl_ort where aktiv and trim(planbezeichnung) like '."'%".str_replace(array(' ',';',',','.'),'%',trim($row->locationid))."%'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;							else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.'  ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}

					// Versuch - 7
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 7';
						$query = 'SELECT * FROM public.tbl_ort where aktiv and ort_kurzbz like '."'%A".str_replace(array('E.',',','.'),'%',trim($row->locationid))."%'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.'  ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}

					// Versuch - 8
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 8';
						$query = 'SELECT * FROM public.tbl_ort where aktiv and ort_kurzbz like '."'%A".str_replace(array('E.',',','.'),'%',trim($row->locationid))."A%'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.'  ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}

					// Versuch - 9
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 9';
						$query = 'SELECT * FROM public.tbl_ort where ort_kurzbz like '."'%".str_replace(array(' ',';',',','.'),'%',trim($row->locationid))."%'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.'  ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}

					// Versuch - 10
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 10';
						$query = 'SELECT * FROM public.tbl_ort where ort_kurzbz like '."'%".str_replace(array('E.',',','.'),'%',trim($row->locationid))."%'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.'  ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}


					// Versuch - 11
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 11';
						$query = "SELECT * FROM public.tbl_ort where trim(planbezeichnung)='".trim($row->locationid)."'";
#						$query = 'SELECT * FROM public.tbl_ort where aktiv and planbezeichnung like '."'%".str_replace(array(' ',';',',','.'),'%',trim($row->locationid))."%'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.'  ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}

					// Versuch - 12
					if (!is_array($rowss) || count($rowss)!=1)
					{
						$rowss=array();
						$variante='Variante 12';
						$query = 'SELECT * FROM public.tbl_ort where trim(planbezeichnung) like '."'%".str_replace(array(' ',';',',','.'),'%',trim($row->locationid))."%'";
						if(!$resultOrt=$oOrt->db_query($query))
							echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
						else
						{
							while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
							{
								$rowss[]=$rowstmp1;
								echo '<br /><b style="color:blue;">'.$variante.'  ort_kurzbz   ==>'.$rowstmp1->ort_kurzbz.'  |||  bezeichnung==>'.$rowstmp1->bezeichnung.'  |||   Planbezeichnung  ==>'.$rowstmp1->planbezeichnung.'  |||  aktiv==>'.$rowstmp1->aktiv.'</b>';
								$query = 'UPDATE '.$schema_inventar.'.locationtable set ort_kurzbz=\''.$rowstmp1->ort_kurzbz.'\',bezeichnung=\''.$rowstmp1->bezeichnung.'\' where  locationid='."'".$row->locationid."'";
								if(!$resultUpd=pg_query($conn_inventar,$query))
									echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
							}
						}
					}

					// Informationsausgabe
					if (is_array($rowss) && count($rowss)==1)
					{
						echo "<br /><b style='color:navy;'> Erfolgreich mit $variante dem ermitteln des Ortes ".$row->locationid.' '.$row->locationname." </b><hr />";
					}
					else
					{
						if (is_array($rowss) && count($rowss)>1)
						{
							echo "<br /><b style='color:red;'> Probleme mit dem ermitteln des Ortes ".$row->locationid.' '.$row->locationname." </b><hr />";
						}
						else if (is_array($rowss) && count($rowss)<1)
						{
							echo "<br /><b style='color:red;'> keinen Orte gefunden ".$row->locationid.' '.$row->locationname." </b><hr />";
						}
						// Alle restlichen auf Dummy aendern
					}
					if (isset($rows))
						unset($rows);
					if (isset($rowss))
						unset($rowss);
			} // Ende Loop Standort - Location

			// Ort Step
			// a) ort_kurzbz beinhaltet die ermittelten Orte lt. tbl_ort als History
			// b) fuer weitere Verarbeitung wird ort_kurzbz auf ort_kurzbz_gefunden kopiert - weiter Verarbeitungen nur mehr mit diesem Feld
			// c) ort_kurzbz_gefunden wird auf DUMMY gesetzt wenn der Inhlat leere ist(kein Ermittlung => den Ort gibt es nicht mehr, Falsch,....)
			$query = 'Update '.$schema_inventar.'.locationtable set ort_kurzbz_gefunden=ort_kurzbz ';
			if(!$resultUpd=pg_query($conn_inventar,$query))
				die("<br />Fehler bei Tabelle ".$schema_inventar.".locationtable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);

			// Dummy Ort lesen und diese in die Locationstabelle uebertragen wo noch keine Orte bzw. Falsche Orte vorhanden sind
			$query = 'SELECT * FROM public.tbl_ort where aktiv and ort_kurzbz='."'DUMMY'";
			if(!$resultOrt=$oOrt->db_query($query))
				echo 'Fehler beim Laden der Datensaetze '.$oOrt->errormsg.' '.$oOrt->db_last_error() .' Line:='.__LINE__.' Fehler SQL ';
			else
			{
				while($rowstmp1 = $oOrt->db_fetch_object($resultOrt))
				{
					$query='Update '.$schema_inventar.'.locationtable set ort_kurzbz_gefunden=trim(\''.$rowstmp1->ort_kurzbz.'\'),bezeichnung=\''.$rowstmp1->bezeichnung.'\' where ort_kurzbz_gefunden=\'\' ; ';
					if(!$resultUpd=pg_query($conn_inventar,$query))
						echo "<br />".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__;
				}
			}

		}	// Ende IF Daten Location Tabelle gefunden


		// die Ermittelten Locationen von der Locations-Tabelle in die Inventartabelle laden
		$query='Update '.$schema_inventar.'.inventtable set ort_kurzbz=trim((select ort_kurzbz_gefunden from '.$schema_inventar.'.locationtable where trim(locationtable.locationid)=trim(inventtable.location))) ; ';
		if(!$resultUpd=pg_query($conn_inventar,$query))
			die("<br />Fehler bei Tabelle ".$schema_inventar.".locationtable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);
	
		echo '<p style="color:navy;">Locationstable  '.$schema_inventar.'.locationtable Ende Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').' <p>';
		
		unset($oOrt);
		if (isset($row))
			unset($rowi);		
		if (isset($rows))
			unset($rows);		
		
		
// ------------------------------------------------------------------------------------------
//
// -------------------- Betriebsmittel
//
// ------------------------------------------------------------------------------------------
		$oBetriebsmittel = new betriebsmittel();
		$oBetriebsmittel->debug=$debug;
		$oBetriebsmittel->errormsg='';
	
		// -----------------------------------------------------
		// alle FAS Studiengaenge einmalig einlesen 
		// -----------------------------------------------------		
		$studiengang_kurzbzlang=array();
		$studiengang_kuerzel=array();			

		if ($oStudiengang->getAll())
		{
				reset($oStudiengang->result);			
				foreach($oStudiengang->result AS $key => $value)
				{
					$value->kurzbzlang=trim($value->kurzbzlang);
					$studiengang_kurzbzlang[$value->kurzbzlang]=$value;
				}

				reset($oStudiengang->result);
				foreach($oStudiengang->result AS $key => $value)
				{
					$value->kuerzel=trim($value->kuerzel);
					$studiengang_kuerzel[$value->kuerzel]=$value;
				}
				unset($key);
				unset($value);
		}
		else
			die("<br /> Fehler Studiengang  ".$oStudiengang->errormsg.' Line:='.__LINE__);

		$rows=array();
		$query='select * from '.$schema_inventar.'.inventtable ';
		
		if (!$result=pg_query($conn_inventar,$query))
			die("<br />Fehler bei Tabelle ".$schema_inventar.".inventtable ! ".pg_last_error().' Fehler SQL '.$query.' Line:='.__LINE__);
		else
		{
			// Lesen alle Stellplaetze
			while($row = pg_fetch_object($result))
			{
				// Leerzeichen vorne und hineten entfernen
				$row->itemid=iconv("UTF-8","ISO-8859-1",trim($row->itemid));
				$row->itemid=str_replace(array('`','�','�','*','~','´'),'+',$row->itemid);
				$row->itemid=iconv("ISO-8859-1","UTF-8",trim($row->itemid));

				$row->inventarnummer=trim($row->itemid);				
				$row->betriebsmitteltyp=trim($row->betriebsmitteltyp);
				$row->ort_kurzbz=trim($row->ort_kurzbz);
				$row->leasing=trim($row->leasing);
				$row->purch_pos=0; // Position gibt es noch nicht in Inventar 
				
				if ($oBetriebsmittel->load_inventarnummer($row->inventarnummer) && count($oBetriebsmittel->result)>0)
				{
					$row->betriebsmittel_id=$oBetriebsmittel->result[0]->betriebsmittel_id;
					$oBetriebsmittel->new=false;

			
					if ($debug)
					{
						$odel = new betriebsmittel_betriebsmittelstatus();
						$odel->delete_betriebsmittel($row->betriebsmittel_id);
		
						$odel = new betriebsmittel($row->betriebsmittel_id);
						$odel->delete($row->betriebsmittel_id);
		
						$row->betriebsmittel_id=null;
						$oBetriebsmittel->new=true;
					}
				}
				else
				{
					$row->betriebsmittel_id=null;
					$oBetriebsmittel->new=true;
				}
				$oBetriebsmittel->inventarnummer=$row->inventarnummer;

				// Ist das Inventar zu einer Bestellung entstanden
				$row->bestellung_id=trim($row->purchid);
				$row->bestelldetail_id=$row->purch_pos;
				
				$row->oe_kurzbz='etw'; // Initialisieren
				$row->oe_kurzbz=''; // Initialisieren				

				$row->updateamum='1999-01-01 01:02';
				$row->insertamum='1999-01-01 01:01';
				$row->datum='1999-01-01';
				
				
				// Zusatzinformation aus WAWI zu Bestellungen lesen
				$wawi=array();
				$oWawi->errormsg='';
				if ($row->bestellung_id && $oWawi->load($row->bestellung_id))
				{
					if (is_array($oWawi->result) && count($oWawi->result)>0)
						$oWawi->result=$oWawi->result[0];
					$wawi=$oWawi->result;
					// StgKz leer - pruefen ob in den Kostenstellen das StgKZ belegt ist
					if ((!isset($wawi->studiengang_id) || !$wawi->studiengang_id) 
					&& isset($wawi->studiengang_kostenstelle_studiengang_id))
					{
						$wawi->studiengang_id=$wawi->studiengang_kostenstelle_studiengang_id;
						$wawi->studiengang_bezeichnung=$wawi->studiengang_kostenstelle_bezeichnung;
						$wawi->studiengang_kurzzeichen=$wawi->studiengang_kostenstelle_kurzzeichen;
					}

					$wawi->oe_kurzbz='etw'; // Man.anlage durch Schmudi - gehoert TW
					
						if (isset($studiengang_kurzbzlang[$wawi->studiengang_kurzzeichen]) && isset($studiengang_kurzbzlang[$wawi->studiengang_kurzzeichen]->oe_kurzbz) )
						{
							$wawi->oe_kurzbz=trim($studiengang_kurzbzlang[$wawi->studiengang_kurzzeichen]->oe_kurzbz);
							if (empty($wawi->studiengang_bezeichnung))
								$wawi->studiengang_bezeichnung=$studiengang_kurzbzlang[$wawi->studiengang_kurzzeichen]->bezeichnung;
							if (empty($wawi->studiengang_kurzzeichen))						
								$wawi->studiengang_kurzzeichen=$studiengang_kurzbzlang[$wawi->studiengang_kurzzeichen]->kurzzeichen;
						}
						elseif (isset($studiengang_kurzbzlang[$wawi->studiengang_bezeichnung]) && isset($studiengang_kurzbzlang[$wawi->studiengang_bezeichnung]->oe_kurzbz) )
						{
							$wawi->oe_kurzbz=trim($studiengang_kurzbzlang[$wawi->studiengang_bezeichnung]->oe_kurzbz);
							if (empty($wawi->studiengang_bezeichnung))
								$wawi->studiengang_bezeichnung=$studiengang_kurzbzlang[$wawi->studiengang_bezeichnung]->bezeichnung;
							if (empty($wawi->studiengang_kurzzeichen))						
								$wawi->studiengang_kurzzeichen=$studiengang_kurzbzlang[$wawi->studiengang_bezeichnung]->kurzzeichen;
						}
						elseif (isset($studiengang_kuerzel[$wawi->studiengang_kurzzeichen]) && isset($studiengang_kuerzel[$wawi->studiengang_kurzzeichen]->oe_kurzbz) )
						{
							$wawi->oe_kurzbz=trim($studiengang_kuerzel[$wawi->studiengang_kurzzeichen]->oe_kurzbz);
							if (empty($wawi->studiengang_bezeichnung))
								$wawi->studiengang_bezeichnung=$studiengang_kuerzel[$wawi->studiengang_kurzzeichen]->bezeichnung;
							if (empty($wawi->studiengang_kurzzeichen))						
								$wawi->studiengang_kurzzeichen=$studiengang_kuerzel[$wawi->studiengang_kurzzeichen]->kurzzeichen;
						}
						elseif (isset($studiengang_kuerzel[$wawi->studiengang_bezeichnung]) && isset($studiengang_kuerzel[$wawi->studiengang_bezeichnung]->oe_kurzbz) )
						{
							$wawi->oe_kurzbz=trim($studiengang_kuerzel[$wawi->studiengang_bezeichnung]->oe_kurzbz);
							if (empty($wawi->studiengang_bezeichnung))
								$wawi->studiengang_bezeichnung=$studiengang_kuerzel[$wawi->studiengang_bezeichnung]->bezeichnung;
							if (empty($wawi->studiengang_kurzzeichen))						
								$wawi->studiengang_kurzzeichen=$studiengang_kuerzel[$wawi->studiengang_bezeichnung]->kurzzeichen;
						}
						elseif ($oOrganisationseinheit->load($wawi->studiengang_bezeichnung))
						{
							$wawi->oe_kurzbz=trim($wawi->studiengang_bezeichnung);
						}
				
					$row->oe_kurzbz=$wawi->oe_kurzbz;
					$row->notes.=(!empty($row->notes)?' ,  ':'').$wawi->firmenname.(!empty($wawi->firmenname)?' ,  ':'').
					$wawi->studiengang_kurzzeichen.(!empty($wawi->studiengang_kurzzeichen)?' ,  ':'').$wawi->studiengang_bezeichnung.(!empty($wawi->studiengang_bezeichnung)?' ,  ':'').
					$wawi->kostenstelle_bezeichnung.(!empty($wawi->kostenstelle_bezeichnung)?' ,  ':'').$wawi->konto_beschreibung;
	
					if (!empty($wawi->geliefert))
					{
						$row->updateamum=$wawi->geliefert;
						$row->insertamum=$wawi->geliefert;
						$row->datum=substr($wawi->geliefert,0,10);
					}	
					elseif (!empty($wawi->bestellung))
					{
						$row->updateamum=$wawi->bestellung;
						$row->insertamum=$wawi->bestellung;
						$row->datum=substr($wawi->bestellung,0,10);
					}	
					elseif (!empty($wawi->freigb_kst))
					{
						$row->updateamum=$wawi->freigb_kst;
						$row->insertamum=$wawi->freigb_kst;
						$row->datum=substr($wawi->freigb_kst,0,10);
					}	
					elseif (!empty($wawi->freigb_gst))
					{
						$row->updateamum=$wawi->freigb_gst;
						$row->insertamum=$wawi->freigb_gst;
						$row->datum=substr($wawi->freigb_gst,0,10);
					}	
					elseif (!empty($wawi->freigb_stg))
					{
						$row->updateamum=$wawi->freigb_stg;
						$row->insertamum=$wawi->freigb_stg;
						$row->datum=substr($wawi->freigb_stg,0,10);
					}	
					elseif (!empty($wawi->erstellung))
					{
						$row->updateamum=$wawi->erstellung;
						$row->insertamum=$wawi->erstellung;
						$row->datum=substr($wawi->erstellung,0,10);
					}	

					elseif (!empty($wawi->lupdate))
					{
						$row->updateamum=substr($wawi->lupdate,0,19);
						$row->insertamum=substr($wawi->lupdate,0,19);
						$row->datum=substr($wawi->lupdate,0,10);
					}	
					else
					{
						var_dump($row);							
						var_dump($wawi);
						echo "<br />datum fehlt wawi Bestell ID ".$row->bestellung_id;
						$row->updateamum='1999-01-01 01:02';
						$row->insertamum='1999-01-01 01:01';
						$row->datum='1999-01-01';
	
					}
					$row->datum=$row->datum;
					$row->updateamum=(strlen($row->updateamum)<11?$row->updateamum.' 00:02:00':substr($row->updateamum,0,19));
					$row->insertamum=(strlen($row->insertamum)<11?$row->insertamum.' 00:01:00':substr($row->insertamum,0,19));
				}
				else if ($row->bestellung_id && $oWawi->load($row->bestellung_id))
				{
					echo '<p class="error">FEHLER INVENTAR '.$row->inventarnummer.' DATEN WAWI BESTELLUNG '.$row->bestellung_id.'</p>';
					var_dump($row);
					echo '<hr>';
				}
				
				$row->wawi=$wawi; // Bestellung in die Inventardaten einfuegen 

				$oBetriebsmittel->oe_kurzbz=$row->oe_kurzbz;
				$oBetriebsmittel->updateamum=$row->updateamum;
				$oBetriebsmittel->insertamum=$row->insertamum;
				
				$oBetriebsmittel->updatevon='schmuderm';
				$oBetriebsmittel->insertvon='schmuderm';
				
				$oBetriebsmittel->betriebsmittel_id=$row->betriebsmittel_id;
				$oBetriebsmittel->betriebsmittelstatus_kurzbz=$row->betriebsmittelstatus_kurzbz;
				$oBetriebsmittel->betriebsmitteltyp=($row->betriebsmitteltyp?$row->betriebsmitteltyp:'Dummy');
				$oBetriebsmittel->reservieren=false;

				$oBetriebsmittel->ort_kurzbz=$row->ort_kurzbz;
				$oBetriebsmittel->hersteller=$row->manufacturer;
				$oBetriebsmittel->seriennummer=$row->serialid;
				$oBetriebsmittel->bestellung_id=$row->purchid;
				$oBetriebsmittel->bestelldetail_id=$row->purch_pos;
				$oBetriebsmittel->afa=$default_afa_jahre;

				$oBetriebsmittel->beschreibung=$row->itemname;
				$oBetriebsmittel->verwendung=$row->purpose;
				$oBetriebsmittel->anmerkung=$row->notes;

				if ($row->leasing && (strtoupper($row->leasing=='JA') || $row->leasing=='1'))
					$oBetriebsmittel->leasing_date=date('d-m-Y');

				$oBetriebsmittel->errormsg='';
				if (!$oBetriebsmittel->save())
					die("<br />Fehler bei Tabelle ".$schema_inventar.".betriebsmittel ! ".$oBetriebsmittel->db_last_error().' Fehler SQL '.$oBetriebsmittel->errormsg.' Line:='.__LINE__);
				if ($oBetriebsmittel->errormsg)
					die($oBetriebsmittel->errormsg.' Line:='.__LINE__);
					
				if ($oBetriebsmittel->new)
				{
					$row->betriebsmittel_id=$oBetriebsmittel->betriebsmittel_id;
					echo '<hr /> Anlage Inventarnummer '.$row->itemid .' wurde aufgenommen in die Betriebsmittel - Betriebsmittel_id '. $row->betriebsmittel_id .' *** File:='.__FILE__.' Line:='.__LINE__;
				}
				if (empty($row->betriebsmittel_id))
				{
					echo '<hr /> Fehler Inventarnummer '.$row->itemid .' wurde nicht aufgenommen in die Betriebsmittel - Betriebsmittel_id '. $row->betriebsmittel_id .' *** File:='.__FILE__.' Line:='.__LINE__;
					var_dump($row);
					break;
				}
				// Inventardaten merken in Array - wird bei der Anlage der Betriebsmittelstatus-History benoetigt ( vermeiden Daten noch mal zu lesen )
				$rows[]=$row;
			}
			if (isset($row))
				unset($row);
		}

		echo "<br />Verarbeitet wurden  ".$schema_inventar.".inventtable *********** Datensaetze - Anzahl ".count($rows);

		if (isset($row))
			unset($row);		
		if (isset($wawi))
			unset($wawi);		
		
		unset($oWawi);		
		unset($oBetriebsmittel);
		unset($oOrganisationseinheit);
		unset($oStudiengang);
		unset($studiengang_kurzbzlang);
		unset($studiengang_kuerzel);
		
// ------------------------------------------------------------------------------------------
//
// ----------------- Betriebsmittelstatus - Historytabelle (fuer alle vorhanden anlegen/start)
//
// ------------------------------------------------------------------------------------------

/*----------------------------------------------------------------------------------------
	tbl_betriebsmittel_betriebsmittelstatus - Inventar History anlegen
		fuer jeden Inventardatensatz einen "vorhanden" anlegen
		- der aktuelle Status kommt im naechsten Step
----------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------
// **** VORHANDEN - DEFAULT WERT
	$oBetriebsmittel = new betriebsmittel();
	$oBetriebsmittel->debug=$debug;
	$oBetriebsmittel->errormsg='';		

	$oBetriebsmittel_betriebsmittelstatus = new betriebsmittel_betriebsmittelstatus();
	$oBetriebsmittel_betriebsmittelstatus->debug=$debug;
	$oBetriebsmittel_betriebsmittelstatus->errormsg='';				
		
		echo '<hr /><p style="color:navy;">Betriebsmittel Betriebsmittelstatus *** '. $betriebsmittelstatus_kurzbz_vorhanden.' Start Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').' <p>';
		if ($oBetriebsmittel_betriebsmittelstatus->getAll())
			echo "<br /> Anzahl Betriebsmittel Betriebsmittelstatus ".count($oBetriebsmittel_betriebsmittelstatus->result);

		// Die Inventdaten vom letzen Step abarbeiten
		reset($rows);
		for ($i=0;$i<count($rows);$i++)
		{
				if (empty($rows[$i]->betriebsmittel_id))
					continue;
			
				// fuer eine Historie muss als erstes ein Vorhandendatensatz angelegt werden
				$oBetriebsmittel_betriebsmittelstatus->errormsg='';
				if ($oBetriebsmittel_betriebsmittelstatus->load_betriebsmittel_id($rows[$i]->betriebsmittel_id,$betriebsmittelstatus_kurzbz_vorhanden))
				{
					if(count($oBetriebsmittel_betriebsmittelstatus->result)>0)
					{
						$oBetriebsmittel_betriebsmittelstatus->load($oBetriebsmittel_betriebsmittelstatus->result[0]->betriebsmittelbetriebsmittelstatus_id);
						$oBetriebsmittel_betriebsmittelstatus->new=false;
					}
					else 
						$oBetriebsmittel_betriebsmittelstatus->new=true;
				}
				else
					$oBetriebsmittel_betriebsmittelstatus->new=true;
				if ($oBetriebsmittel_betriebsmittelstatus->errormsg)
					die($oBetriebsmittel_betriebsmittelstatus->errormsg.' Line:='.__LINE__);
					
				if ($oBetriebsmittel_betriebsmittelstatus->new)
					$oBetriebsmittel_betriebsmittelstatus->betriebsmittelbetriebsmittelstatus_id=null;
					
				$oBetriebsmittel_betriebsmittelstatus->betriebsmittel_id=$rows[$i]->betriebsmittel_id;
				$oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz=$betriebsmittelstatus_kurzbz_vorhanden;

				//$oBetriebsmittel_betriebsmittelstatus->anmerkung='Datenuebernahme '.date('Y-m-d H:i');		

				$oBetriebsmittel_betriebsmittelstatus->datum=$rows[$i]->datum;
				$oBetriebsmittel_betriebsmittelstatus->updateamum=$rows[$i]->updateamum;
				$oBetriebsmittel_betriebsmittelstatus->insertamum=$rows[$i]->insertamum;

				// Schmudi als Default - Inventaruser
				$oBetriebsmittel_betriebsmittelstatus->updatevon='schmuderm';
				$oBetriebsmittel_betriebsmittelstatus->insertvon='schmuderm';

				$oBetriebsmittel_betriebsmittelstatus->errormsg='';
				if (!$oBetriebsmittel_betriebsmittelstatus->save())
					die("<br />FEHLER Betriebsmittel Betriebsmittelstatus <hr>".$oBetriebsmittel_betriebsmittelstatus->errormsg.' Key:='.$rows[$i]->betriebsmittel_id.' '.$oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz.' '.$oBetriebsmittel_betriebsmittelstatus->errormsg.' Line:='.__LINE__);
				else
					echo "<br />Status saved: $oBetriebsmittel_betriebsmittelstatus->betriebsmittelbetriebsmittelstatus_id $oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz";
				
				if ($oBetriebsmittel_betriebsmittelstatus->errormsg)
					die($oBetriebsmittel_betriebsmittelstatus->errormsg.' Line:='.__LINE__);
					
				if ($oBetriebsmittel_betriebsmittelstatus->new)
					echo '<hr /> Anlage Default Status fuer Inventarnummer '.$rows[$i]->inventarnummer .' wurde aufgenommen in die Betriebsmittel - Status ID '. $oBetriebsmittel_betriebsmittelstatus->betriebsmittelbetriebsmittelstatus_id. ' / '.$oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz .' *** File:='.__FILE__.' Line:='.__LINE__;
		}
		if ($oBetriebsmittel_betriebsmittelstatus->getAll())
			echo "<br /> Anzahl Betriebsmittel Betriebsmittelstatus ".count($oBetriebsmittel_betriebsmittelstatus->result);
		echo '<p style="color:navy;">Betriebsmittel Betriebsmittelstatus *** '. $betriebsmittelstatus_kurzbz_vorhanden.' Ende Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').' <p>';

//------------------------------------------------------------------------------------------------
// **** INVENTUR DATEN - STATUS
	$oBetriebsmittel_betriebsmittelstatus = new betriebsmittel_betriebsmittelstatus();
	$oBetriebsmittel_betriebsmittelstatus->debug=$debug;
	$oBetriebsmittel_betriebsmittelstatus->errormsg='';				

		echo '<hr /><p style="color:navy;">Betriebsmittel Betriebsmittelstatus *** Inventurdaten '.$betriebsmittelstatus_kurzbz_inventur.' Status Start Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').' <p>';
		if ($oBetriebsmittel_betriebsmittelstatus->getAll())
			echo "<br /> Anzahl Betriebsmittel Betriebsmittelstatus ".count($oBetriebsmittel_betriebsmittelstatus->result);
		

		$query = 'SELECT * FROM '.$schema_inventar.'.inventory,'.$schema_inventar.'.inventorydata ,'.$schema_inventar.'.inventorystatus,'.$schema_inventar.'.inventorydatastatus
					 where inventorydata.invd_inventory=inventory.inv_id
					   and inventorystatus.invs_id=inventory.inv_status
					   and inventorydatastatus.invds_id=inventorydata.invd_status
				 ';

		if(!$resultLean=pg_query($conn_inventar,$query))
		{
			if (pg_last_error())
				echo "<br />".pg_last_error().' *** File:='.__FILE__.' Line:='.__LINE__.' Fehler SQL '.$query;
		}	
		else
		{
			$verarbeitetedaten=0;
			echo "<br />$betriebsmittelstatus_kurzbz_inventur Anzahl:".pg_numrows($resultLean).' *** File:='.__FILE__.' Line:='.__LINE__;
			while($rowstmp1 = pg_fetch_object($resultLean))
			{
				$rowstmp1->invd_item=iconv("UTF-8","ISO-8859-1",trim($rowstmp1->invd_item));
				$rowstmp1->invd_item=str_replace(array('`','�','�','*','~','´'),'+',$rowstmp1->invd_item);
				$rowstmp1->invd_item=iconv("ISO-8859-1","UTF-8",trim($rowstmp1->invd_item));
				
				$oBetriebsmittel->errormsg='';				
				// fuer eine Historie muss als erstes ein Vorhandendatensatz angelegt werden
				if (!$oBetriebsmittel->load_inventarnummer($rowstmp1->invd_item))
				{
					echo "<br /> Betriebsmittel wurde nicht gefunden ? :". $rowstmp1->invd_item.' '.$oBetriebsmittel->errormsg.' *** File:='.__FILE__.' Line:='.__LINE__;
					continue;
				}	
				if (empty($oBetriebsmittel->betriebsmittel_id))
				{
					echo "<br />Betriebsmittel wurde nicht gefunden ? :". $rowstmp1->invd_item.' '.$oBetriebsmittel->errormsg.' *** File:='.__FILE__.' Line:='.__LINE__;
					continue;
				}	
				$oBetriebsmittel_betriebsmittelstatus->errormsg='';
				if ($oBetriebsmittel_betriebsmittelstatus->load_betriebsmittel_id($oBetriebsmittel->betriebsmittel_id,$betriebsmittelstatus_kurzbz_inventur))
				{
					if(count($oBetriebsmittel_betriebsmittelstatus->result)>0)
					{
						$oBetriebsmittel_betriebsmittelstatus->load($oBetriebsmittel_betriebsmittelstatus->result[0]->betriebsmittelbetriebsmittelstatus_id);
						$oBetriebsmittel_betriebsmittelstatus->new=false;
					}
					else 
						$oBetriebsmittel_betriebsmittelstatus->new=true;
				}
				else
					$oBetriebsmittel_betriebsmittelstatus->new=true;
				if ($oBetriebsmittel_betriebsmittelstatus->errormsg)
					die($oBetriebsmittel_betriebsmittelstatus->errormsg.' Line:='.__LINE__);

				if ($oBetriebsmittel_betriebsmittelstatus->new)
					$oBetriebsmittel_betriebsmittelstatus->betriebsmittelbetriebsmittelstatus_id=null;

				$oBetriebsmittel_betriebsmittelstatus->betriebsmittel_id=$oBetriebsmittel->betriebsmittel_id;
				$oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz=$betriebsmittelstatus_kurzbz_inventur;

				$oBetriebsmittel_betriebsmittelstatus->anmerkung=' Location: '.$rowstmp1->inv_locationid.' Inventurstatus:'.$rowstmp1->inv_status.' '.$rowstmp1->invs_bezeichnung.', Inventarstatus: '.$rowstmp1->inv_status.' '.$rowstmp1->invds_bezeichnung.', Inventurnummer: '.$rowstmp1->invd_inventory ."\n";
				
				$oBetriebsmittel_betriebsmittelstatus->datum=$rowstmp1->inv_date;
				$oBetriebsmittel_betriebsmittelstatus->updateamum=$rowstmp1->inv_date .' 01:01:01';
				$oBetriebsmittel_betriebsmittelstatus->insertamum=$rowstmp1->inv_date .' 01:01:01';

				$oBetriebsmittel_betriebsmittelstatus->updatevon='schmuderm';
				$oBetriebsmittel_betriebsmittelstatus->insertvon='schmuderm';

				$oBetriebsmittel_betriebsmittelstatus->errormsg='';
				if (!$oBetriebsmittel_betriebsmittelstatus->save())
					die("<br />Wartung Betriebsmittel Betriebsmittelstatus ".$oBetriebsmittel_betriebsmittelstatus->errormsg.' Key:='.$rows[$i]->betriebsmittel_id.' '.$rows[$i]->betriebsmittelstatus_kurzbz.' Line:='.__LINE__);
				if ($oBetriebsmittel_betriebsmittelstatus->errormsg)
					die($oBetriebsmittel_betriebsmittelstatus->errormsg.' Line:='.__LINE__);
				if ($oBetriebsmittel_betriebsmittelstatus->new)
					echo '<hr /> Anlage Inventur Status fuer Betriebsmittel '.$rowstmp1->invd_item.' wurde aufgenommen in die Betriebsmittel - Status ID '. $oBetriebsmittel_betriebsmittelstatus->betriebsmittelbetriebsmittelstatus_id. ' / '.$oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz .' *** File:='.__FILE__.' Line:='.__LINE__;

				$verarbeitetedaten++;
			}
			echo "<br />$betriebsmittelstatus_kurzbz_inventur Anzahl:".pg_numrows($resultLean)." davon verarbeitet $verarbeitetedaten ".' *** File:='.__FILE__.' Line:='.__LINE__;
		}

		if ($oBetriebsmittel_betriebsmittelstatus->getAll())
			echo "<br /> Anzahl Betriebsmittel Inventur Betriebsmittelstatus ".count($oBetriebsmittel_betriebsmittelstatus->result);
		echo ' <p style="color:navy;">Betriebsmittel Betriebsmittelstatus *** Inventurdaten '.$betriebsmittelstatus_kurzbz_inventur.' Status Ende Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').' <p>';
		if (isset($rowstmp1))
			unset($rowstmp1);		
		
//------------------------------------------------------------------------------------------------
// **** EXTERN DATEN - STATUS
	$oBetriebsmittel_betriebsmittelstatus = new betriebsmittel_betriebsmittelstatus();
	$oBetriebsmittel_betriebsmittelstatus->debug=$debug;
	$oBetriebsmittel_betriebsmittelstatus->errormsg='';				

		echo '<hr /><p style="color:navy;">Betriebsmittel Betriebsmittelstatus *** Extern '. $betriebsmittelstatus_kurzbz_verliehen.'  verliehen '.$schema_inventar.'.leantable Start Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').' <p>';
		if ($oBetriebsmittel_betriebsmittelstatus->getAll())
			echo "<br /> Anzahl Betriebsmittel Betriebsmittelstatus ".count($oBetriebsmittel_betriebsmittelstatus->result);

		$query = 'SELECT * FROM '.$schema_inventar.'.leantable where leantable.itemid>\'\' ';
		if(!$resultLean=pg_query($conn_inventar,$query))
			echo "<br />".pg_last_error().' *** File:='.__FILE__.' Line:='.__LINE__.' Fehler SQL '.$query;
		else
		{
			$verarbeitetedaten=0;
			echo "<br />$betriebsmittelstatus_kurzbz_verliehen Anzahl:".pg_numrows($resultLean).' *** File:='.__FILE__.' Line:='.__LINE__;
			while($rowstmp1 = pg_fetch_object($resultLean))
			{

				$rowstmp1->itemid=iconv("UTF-8","ISO-8859-1",trim($rowstmp1->itemid));
				$rowstmp1->itemid=str_replace(array('`','�','�','*','~','´'),'+',$rowstmp1->itemid);
				$rowstmp1->itemid=iconv("ISO-8859-1","UTF-8",trim($rowstmp1->itemid));

				$oBetriebsmittel->errormsg='';
				if (!$oBetriebsmittel->load_inventarnummer($rowstmp1->itemid))
				{
					echo "<br />Betriebsmittel wurde nicht gefunden ? :". $rowstmp1->itemid.' '.$oBetriebsmittel->errormsg.' *** File:='.__FILE__.' Line:='.__LINE__;
					continue;
				}	
				if (empty($oBetriebsmittel->betriebsmittel_id))
				{
					echo "<br />Betriebsmittel wurde nicht gefunden ? :". $rowstmp1->itemid.' '.$oBetriebsmittel->errormsg.' *** File:='.__FILE__.' Line:='.__LINE__;
					continue;
				}	

				$oBetriebsmittel_betriebsmittelstatus->errormsg='';						
				if ($oBetriebsmittel_betriebsmittelstatus->load_betriebsmittel_id($oBetriebsmittel->betriebsmittel_id,$betriebsmittelstatus_kurzbz_verliehen))
				{
					if(count($oBetriebsmittel_betriebsmittelstatus->result)>0)
					{
						$oBetriebsmittel_betriebsmittelstatus->load($oBetriebsmittel_betriebsmittelstatus->result[0]->betriebsmittelbetriebsmittelstatus_id);
						$oBetriebsmittel_betriebsmittelstatus->new=false;
					}
					else 
						$oBetriebsmittel_betriebsmittelstatus->new=true;
				}
				else
					$oBetriebsmittel_betriebsmittelstatus->new=true;
				if ($oBetriebsmittel_betriebsmittelstatus->errormsg)
					die($oBetriebsmittel_betriebsmittelstatus->errormsg.' Line:='.__LINE__);

				if ($oBetriebsmittel_betriebsmittelstatus->new)
					$oBetriebsmittel_betriebsmittelstatus->betriebsmittelbetriebsmittelstatus_id=null;

					
				$oBetriebsmittel_betriebsmittelstatus->betriebsmittel_id=$oBetriebsmittel->betriebsmittel_id;
				$oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz=$betriebsmittelstatus_kurzbz_verliehen;

				$oBetriebsmittel_betriebsmittelstatus->anmerkung=' Location: '.$rowstmp1->location.' von '.$rowstmp1->person .' von '.$rowstmp1->person ."\n";

				$oBetriebsmittel_betriebsmittelstatus->datum=getSQLDate($rowstmp1->leandate);
				$oBetriebsmittel_betriebsmittelstatus->updateamum=getSQLDate($rowstmp1->leandate).' 01:01';
				$oBetriebsmittel_betriebsmittelstatus->insertamum=getSQLDate($rowstmp1->leandate).' 01:01';
				$oBetriebsmittel_betriebsmittelstatus->updatevon='schmuderm';
				$oBetriebsmittel_betriebsmittelstatus->insertvon='schmuderm';

				$oBetriebsmittel_betriebsmittelstatus->errormsg='';
				if (!$oBetriebsmittel_betriebsmittelstatus->save())
					die("<br />Wartung Betriebsmittel Betriebsmittelstatus ".$oBetriebsmittel_betriebsmittelstatus->errormsg.' Key:='.$rows[$i]->betriebsmittel_id.' '.$rows[$i]->betriebsmittelstatus_kurzbz.' Line:='.__LINE__);
				if ($oBetriebsmittel_betriebsmittelstatus->errormsg)
					die($oBetriebsmittel_betriebsmittelstatus->errormsg.' Line:='.__LINE__);
				if ($oBetriebsmittel_betriebsmittelstatus->new)
					echo '<hr /> Anlage Extern Status fuer Betriebsmittel '.$rowstmp1->itemid.' wurde aufgenommen in die Betriebsmittel - Status ID '. $oBetriebsmittel_betriebsmittelstatus->betriebsmittelbetriebsmittelstatus_id. ' / '.$oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz .' *** File:='.__FILE__.' Line:='.__LINE__;

				$verarbeitetedaten++;					
			}
			echo "<br />$betriebsmittelstatus_kurzbz_verliehen Anzahl:".pg_numrows($resultLean)." davon verarbeitet $verarbeitetedaten ".' *** File:='.__FILE__.' Line:='.__LINE__;
		}

		if ($oBetriebsmittel_betriebsmittelstatus->getAll())
			echo "<br /> Anzahl Betriebsmittel Extern Betriebsmittelstatus ".count($oBetriebsmittel_betriebsmittelstatus->result);
		echo '<p style="color:navy;">Betriebsmittel Betriebsmittelstatus *** Extern '. $betriebsmittelstatus_kurzbz_verliehen.'   verliehen '.$schema_inventar.'.leantable Ende Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').' <p>';
		
		if (isset($rowstmp1))
			unset($rowstmp1);		
		if (isset($oBetriebsmittel_betriebsmittelstatus))
			unset($oBetriebsmittel_betriebsmittelstatus);		
		
//------------------------------------------------------------------------------------------------
// **** AKTUELLER STATUS
	$oBetriebsmittel_betriebsmittelstatus = new betriebsmittel_betriebsmittelstatus();
	$oBetriebsmittel_betriebsmittelstatus->debug=$debug;
	$oBetriebsmittel_betriebsmittelstatus->errormsg='';				

		echo '<hr /><p style="color:navy;">Betriebsmittel Betriebsmittelstatus *** Aktueller Status Start Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').' <p>';
		if ($oBetriebsmittel_betriebsmittelstatus->getAll())
			echo "<br /> Anzahl Betriebsmittel Betriebsmittelstatus ".count($oBetriebsmittel_betriebsmittelstatus->result);

		reset($rows);
		for ($i=0;$i<count($rows);$i++)
		{
				$rows[$i]->betriebsmittelstatus_kurzbz=trim($rows[$i]->betriebsmittelstatus_kurzbz);
				
				// Wenn der Status "vorhanden" oder "extern" ist kann dieser ueberlesen werden (wurde in den letzten Steps bereits angelegt)
				// Inventur Status wird hier nicht beruecksichtigt - aktueller Inventarstatus zaehlt

				
				if (empty($rows[$i]->betriebsmittel_id) 
				|| strtoupper($rows[$i]->betriebsmittelstatus_kurzbz)==strtoupper($betriebsmittelstatus_kurzbz_vorhanden) 
			 	|| strtoupper($rows[$i]->betriebsmittelstatus_kurzbz)==strtoupper($betriebsmittelstatus_kurzbz_verliehen)
				)
						continue;
				
				$oBetriebsmittel_betriebsmittelstatus->errormsg='';
				if ($oBetriebsmittel_betriebsmittelstatus->load_last_betriebsmittel_id($rows[$i]->betriebsmittel_id))
				{
					if ($oBetriebsmittel_betriebsmittelstatus->errormsg)
						die($oBetriebsmittel_betriebsmittelstatus->errormsg);
					// Pruefen ob dieser Status nicht als letzter bereits angelegt wurde 
					if (trim($oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz)==$betriebsmittelstatus_kurzbz_vorhanden 
					||trim($oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz)==$rows[$i]->betriebsmittelstatus_kurzbz )
						continue;
				}		

				if ($oBetriebsmittel_betriebsmittelstatus->errormsg)
					die($oBetriebsmittel_betriebsmittelstatus->errormsg);
									
				$oBetriebsmittel_betriebsmittelstatus->new=true;
				$oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz=$rows[$i]->betriebsmittelstatus_kurzbz;						
				$oBetriebsmittel_betriebsmittelstatus->betriebsmittel_id=$rows[$i]->betriebsmittel_id;
				$oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz=$rows[$i]->betriebsmittelstatus_kurzbz;

				//$oBetriebsmittel_betriebsmittelstatus->anmerkung='Datenuebernahme '.date('Y-m-d H:i');		

				$vor=$rows[$i]->updateamum;	
				$rows[$i]->updateamum=str_replace(':00',':59',$rows[$i]->updateamum);
				$rows[$i]->insertamum=str_replace(':00',':59',$rows[$i]->insertamum);
				
				$oBetriebsmittel_betriebsmittelstatus->datum=$rows[$i]->datum;
				$oBetriebsmittel_betriebsmittelstatus->updateamum=$rows[$i]->updateamum;
				$oBetriebsmittel_betriebsmittelstatus->insertamum=$rows[$i]->insertamum;
				
				$oBetriebsmittel_betriebsmittelstatus->updatevon='schmuderm';
				$oBetriebsmittel_betriebsmittelstatus->insertvon='schmuderm';
				
				$oBetriebsmittel_betriebsmittelstatus->errormsg='';
				if (!$oBetriebsmittel_betriebsmittelstatus->save())
					die("<br />Wartung Betriebsmittel Betriebsmittelstatus ".$oBetriebsmittel_betriebsmittelstatus->errormsg.' Key:='.$rows[$i]->betriebsmittel_id.' '.$rows[$i]->betriebsmittelstatus_kurzbz.' Line:='.__LINE__);
				if ($oBetriebsmittel_betriebsmittelstatus->errormsg)
					die($oBetriebsmittel_betriebsmittelstatus->errormsg.' Line:='.__LINE__);
				if ($oBetriebsmittel_betriebsmittelstatus->new)
					echo '<hr /> Anlage Aktueller Status fuer Inventarnummer '.$rows[$i]->inventarnummer .' wurde aufgenommen in die Betriebsmittel - Status ID '. $oBetriebsmittel_betriebsmittelstatus->betriebsmittelbetriebsmittelstatus_id. ' / '.$oBetriebsmittel_betriebsmittelstatus->betriebsmittelstatus_kurzbz .' *** File:='.__FILE__.' Line:='.__LINE__;

		}

		if ($oBetriebsmittel_betriebsmittelstatus->getAll())
			echo "<br /> Anzahl Betriebsmittel Betriebsmittelstatus ".count($oBetriebsmittel_betriebsmittelstatus->result);
		echo ' <p style="color:navy;">Betriebsmittel Betriebsmittelstatus *** Aktueller Status Ende Line:='.__LINE__.date(' *** D, d.M.Y,  H:i:s ').' <p>';
		


		if (isset($row))
			unset($rowi);		
		if (isset($rows))
			unset($rows);		
		
		unset($oBetriebsmittel);
		unset($oBetriebsmittel_betriebsmittelstatus);		

//------------------------------------------------------------------------------------------------
// Informationen gesammelt ausgeben , und ENDE
	exit('<hr />************* ENDE *******************'.trim(implode("<br />",$errormsg)));
//===========================================================================================

	/**
	 * Ermittelt das Datumsformat fuer SQL
	 * @param $datum das konvertiert werden soll
	 * @return Datum wenn ok, false im Fehlerfall
	 */
	function getSQLDate($datum)
	{
		if ( is_null($datum) || empty($datum) )
			return $datum;
	
		$date=explode('.',$datum);
		if (@checkdate($date[1], $date[0], $date[2]))
		{
			 return $date[2].'-'.$date[1].'-'.$date[0];	
		}	 	
		if (@checkdate($date[2], $date[0], $date[1]))
		{
			 return $date[0].'-'.$date[1].'-'.$date[2];	
		}	 	

		$date=explode('-',$datum);
		if (@checkdate($date[1], $date[0], $date[2]))
		{
			 return $date[2].'-'.$date[1].'-'.$date[0];	
		}	 	
		if (@checkdate($date[2], $date[0], $date[1]))
		{
			 return $date[0].'-'.$date[1].'-'.$date[2];	
		}	 	
		echo "<br> Falsches Datum $datum";
		return false;
	}		
?>