<?php
/* Copyright (C) 2009 Technikum-Wien
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
 * Studentenmeldung
 * 
 * Erstellt ein XML File fuer die Studentenmeldung an den FHR
 * Das XML-File wird im Filesystem abgelegt. 
 * Zusaetzlich wird eine Uebersichtsliste ueber die im File enthaltenen Daten erstellt und
 * nicht plausible Daten
 * 
 * Parameter: stg_kz ... Kennzahl des Studienganges
 */
require_once('../../config/vilesci.config.inc.php');
require_once('../../include/studiensemester.class.php');
require_once('../../include/datum.class.php');
require_once('../../include/studiengang.class.php');
require_once('../../include/functions.inc.php');
require_once('../../include/benutzerberechtigung.class.php');

if (!$db = new basis_db())
	die('Es konnte keine Verbindung zum Server aufgebaut werden.');

$uid = get_uid();
$rechte = new benutzerberechtigung();
$rechte->getBerechtigungen($uid);

if(!$rechte->isBerechtigt('student/stammdaten',null,'suid') && !$rechte->isBerechtigt('assistenz',null,'suid') && !$rechte->isBerechtigt('admin',null,'suid'))
	die('Sie haben keine Berechtigung für diese Seite');

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
$anzahl_fehler=0;
$erhalter='';
$stgart='';
$orgform_code='';
$status='';
$datei='';
$aktstatus='';
$aktstatus_datum='';
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
$bewerbercount=array();
$orgform_kurzbz='';
$tabelle='';
$stlist='';
$bwlist='';
$storgfor='';
$verwendete_orgformen=array();
$student_data=array();

$datum_obj = new datum();

//Beginn- und Endedatum des aktuellen Semesters
$qry="SELECT * FROM public.tbl_studiensemester WHERE studiensemester_kurzbz=".$db->db_add_param($ssem).";";
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
	die('Ung&uuml;ltiges Studiensemester!');
}
//ausgewaehlter Studiengang
if(isset($_GET['stg_kz']))
{
	$stg_kz=$_GET['stg_kz'];
}
else
{
	die('<H2>Es wurde kein Studiengang ausgew&auml;hlt!</H2>');
}

/*
 standortcode 22=Wien
derzeit fuer alle Studierende der gleiche Standort
ToDo: Standort sollte pro Student konfigurierbar sein.
*/
$standortcode='22';
if(in_array($stg_kz,array('265','268','761','760','266','267','764','269','400')))
	$standortcode='14'; // Pinkafeld
elseif(in_array($stg_kz,array('639','640','263','743','364','635','402','401','725','264','271')))
	$standortcode='3'; // Eisenstadt

$datumobj=new datum();

$qry='SELECT * FROM bis.tbl_orgform';

if($result = $db->db_query($qry))
{
	while($row = $db->db_fetch_object($result))
	{
		$orgform_code_array[$row->orgform_kurzbz]=$row->code;
	}
}

//Studiengangsdaten auslesen
<<<<<<< HEAD
$qry="
	SELECT 
		*
	FROM 
		public.tbl_studiengang 
	WHERE studiengang_kz=".$db->db_add_param($stg_kz);
=======
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
$stg_obj = new studiengang();
if($stg_obj->load($stg_kz))
{
	$maxsemester=$stg_obj->max_semester;
	if($maxsemester==0)
	{
		echo "Die maximale Semesteranzahl des Studienganges ist nicht angegeben!";
		exit;
	}
	
	$erhalter = sprintf('%03s',$stg_obj->erhalter_kz);

	switch($stg_obj->typ)
	{
		case 'b': $stgart=1; break;
		case 'm': $stgart=2; break;
		case 'd': $stgart=3; break;
		case 'e': $stgart=4; break;
		default: die('<h2>Dieser Studiengangstyp kann nicht gemeldet werden. Typ muss (b, m, d oder e) sein</h2>'); break;
	}

<<<<<<< HEAD
=======
	// DoubleDegree Studierende werden per Default aus BB gemeldet.
	// Wenn es ein reiner VZ Studiengang ist, dann sollen diese aber als VZ gemeldet werden.
	if($stg_obj->orgform_kurzbz=='VZ')
		$orgform_code_array['DDP']=$orgform_code_array['VZ'];

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	$orgform_code = $orgform_code_array[$stg_obj->orgform_kurzbz];
	$orgform_kurzbz=$stg_obj->orgform_kurzbz;
}
else 
	die('Fehler:'.$stg_obj->errormsg);


//Ausgabe aktiver Studenten, die nicht gemeldet werden
$qry_akt="
	SELECT 
		DISTINCT ON(student_uid, nachname, vorname) *, public.tbl_person.person_id AS pers_id
	FROM 
		public.tbl_student
		JOIN public.tbl_benutzer ON(student_uid=uid)
		JOIN public.tbl_person USING (person_id)
		JOIN public.tbl_prestudent USING (prestudent_id)
		JOIN public.tbl_prestudentstatus ON(tbl_prestudent.prestudent_id=tbl_prestudentstatus.prestudent_id)
	WHERE 
		bismelden=FALSE
		AND tbl_student.studiengang_kz=".$db->db_add_param($stg_kz)."
		AND (tbl_prestudentstatus.studiensemester_kurzbz=".$db->db_add_param($ssem)." AND status_kurzbz IN ('Student','Diplomand','Unterbrecher','Praktikant','Outgoing'))
		AND tbl_prestudent.prestudent_id NOT IN
			(
			SELECT prestudent_id 
			FROM public.tbl_prestudentstatus 
			WHERE 
			 	tbl_prestudentstatus.studiensemester_kurzbz=".$db->db_add_param($ssem)."
			 	AND (status_kurzbz='Abbrecher' OR status_kurzbz='Absolvent')
			 )
	ORDER BY student_uid, nachname, vorname
	";
if($result_akt = $db->db_query($qry_akt))
{
	while($row_akt = $db->db_fetch_object($result_akt))
	{
		$v.="<u><b>Person (UID, Vorname, Nachname) '".$row_akt->student_uid."', '".$row_akt->nachname."', '".$row_akt->vorname."'</u></b> hat Status $row_akt->status_kurzbz, wird aber nicht BIS gemeldet!!! <br>\n";
		$anzahl_fehler++;
	}
}

//Incoming ohne I/O Datensatz anzeigen
$qry_in="
	SELECT 
		DISTINCT ON(student_uid, nachname, vorname) *, public.tbl_person.person_id AS pers_id
	FROM 
		public.tbl_student
		JOIN public.tbl_benutzer ON(student_uid=uid)
		JOIN public.tbl_person USING (person_id)
		JOIN public.tbl_prestudent USING (prestudent_id)
		JOIN public.tbl_prestudentstatus ON(tbl_prestudent.prestudent_id=tbl_prestudentstatus.prestudent_id)
	WHERE 
		bismelden=TRUE
		AND tbl_student.studiengang_kz=".$db->db_add_param($stg_kz)."
		AND (status_kurzbz='Incoming' AND student_uid NOT IN (SELECT student_uid FROM bis.tbl_bisio))
	ORDER BY student_uid, nachname, vorname
	";
if($result_in = $db->db_query($qry_in))
{
	while($row_in = $db->db_fetch_object($result_in))
	{
		$v.="<u>Bei Student (UID, Vorname, Nachname) '".$row_in->student_uid."', '".$row_in->nachname."', '".$row_in->vorname."' ($row_in->status_kurzbz): </u>\n";
		$v.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Es fehlt der I/O-Datensatz\n\n";
		$anzahl_fehler++;
	}
}

//Hauptselect
$qry="
	SELECT 
		DISTINCT ON(student_uid, nachname, vorname) *, public.tbl_person.person_id AS pers_id, to_char(gebdatum, 'ddmmyy') AS vdat
	FROM 
		public.tbl_student
		JOIN public.tbl_benutzer ON(student_uid=uid)
		JOIN public.tbl_person USING (person_id)
		JOIN public.tbl_prestudent USING (prestudent_id)
		JOIN public.tbl_prestudentstatus ON(tbl_prestudent.prestudent_id=tbl_prestudentstatus.prestudent_id)
	WHERE 
		bismelden=TRUE
		AND tbl_student.studiengang_kz=".$db->db_add_param($stg_kz)."
		AND (((tbl_prestudentstatus.studiensemester_kurzbz=".$db->db_add_param($ssem).") AND (tbl_prestudentstatus.datum<=".$db->db_add_param($bisdatum).")
			AND (status_kurzbz='Student' OR status_kurzbz='Outgoing'
			OR status_kurzbz='Praktikant' OR status_kurzbz='Diplomand' OR status_kurzbz='Absolvent'
			OR status_kurzbz='Abbrecher' OR status_kurzbz='Unterbrecher'))
			OR ((tbl_prestudentstatus.studiensemester_kurzbz=".$db->db_add_param($psem).") AND (status_kurzbz='Absolvent'
			OR status_kurzbz='Abbrecher') AND tbl_prestudentstatus.datum>".$db->db_add_param($bisprevious).")
			OR (status_kurzbz='Incoming' AND student_uid IN (SELECT student_uid FROM bis.tbl_bisio WHERE (tbl_bisio.bis>=".$db->db_add_param($bisprevious).")
				OR (tbl_bisio.von<=".$db->db_add_param($bisdatum)." AND (tbl_bisio.bis>=".$db->db_add_param($bisdatum)."  OR tbl_bisio.bis IS NULL))
		)))
	ORDER BY student_uid, nachname, vorname
	";

if($result = $db->db_query($qry))
{

	$datei.="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<Erhalter>
  <ErhKz>".$erhalter."</ErhKz>
  <MeldeDatum>".date("dmY", $datumobj->mktime_fromdate($bisdatum))."</MeldeDatum>
  <StudierendenBewerberMeldung>
    <Studiengang>
      <StgKz>".$stg_kz."</StgKz>";
	/*
	if($orgform_code==3) //Studiengang in Mischform organisiert
	{
		while($row = $db->db_fetch_object($result))
		{
			if($row->orgform_kurzbz=='' && $row->status_kurzbz=='Incoming')
			{
				$row->orgform_kurzbz=$orgform_kurzbz;
			}
			elseif($row->orgform_kurzbz=='')
			{
				echo 'Fehler: Keine Organisationsform fuer '.$row->uid.' '.$row->vorname.' '.$row->nachname.' eingetragen<br>';
				continue;
			}
			if(!isset($student_data[$orgform_code_array[$row->orgform_kurzbz]]))
				$student_data[$orgform_code_array[$row->orgform_kurzbz]]='';
			//Plausichecks
			$student_data[$orgform_code_array[$row->orgform_kurzbz]].= GenerateXMLStudentBlock($row);
		}
		foreach($student_data as $key=>$value)
		{
			$datei.="
		<StudiengangDetail>
			<OrgFormTeilCode>".$key."</OrgFormTeilCode>
			<StgStartSemCode>1</StgStartSemCode>".$value;
			$datei.= GenerateXMLBewerberBlock($key);
			$datei.="
		</StudiengangDetail>";
		}
	}
	else
	{
      	//orgform!='3'
      	//Stg mit einer Orgform
      	 
		$datei.="
		<StudiengangDetail>
			<OrgFormTeilCode>".$orgform_code."</OrgFormTeilCode>
			<StgStartSemCode>1</StgStartSemCode>
		";*/
		while($row = $db->db_fetch_object($result))
		{
			$datei.= GenerateXMLStudentBlock($row);
		}
		
		//Bewerberblock bei Ausserordentlichen nicht anzeigen
		if($stg_kz!=('9'.$erhalter))
		{
			if($orgform_code==3)
			{
				$orgcodes = array_unique($orgform_code_array);
				//Mischform
				foreach($orgcodes as $code)
					$datei.= GenerateXMLBewerberBlock($code);
			}
			else
				$datei.= GenerateXMLBewerberBlock();
		}
		//$datei.="	</StudiengangDetail>";
	//}
}

$datei.="
    </Studiengang>
  </StudierendenBewerberMeldung>
</Erhalter>";
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>BIS - Meldung Student - ('.$stg_kz.')</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="../../skin/vilesci.css" rel="stylesheet" type="text/css">
	</head>
	<body>';
echo "<H1>BIS - Studentendaten werden &uuml;berpr&uuml;ft! Studiengang: ".$db->convert_html_chars($stg_kz)."</H1>\n";
echo "<H2>Nicht plausible BIS-Daten (f&uuml;r Meldung ".$db->convert_html_chars($ssem)."): </H2><br>";
echo nl2br($v."\n\n");

//Tabelle mit Ergebnissen ausgeben
$tabelle="<H2>BIS-Meldungs&uuml;bersicht: </H2><br>
<table border=1>
	<colgroup>
		<col width='180'>
		<col width='80'>
		<col width='80'>
		<col width='80'>
		<col width='80'>
		<col width='80'>
		<col width='80'>
		<col width='80'>
		<col width='80'>
		<col width='80'>
		<col width='80'>
	</colgroup>
<tr align=center>
	<th bgcolor='#AFFA49'>Semester</th>
	<th bgcolor='#AFFA49'>1</th>
	<th bgcolor='#AFFA49'>2</th>
	<th bgcolor='#AFFA49'>3</th>
	<th bgcolor='#AFFA49'>4</th>
	<th bgcolor='#AFFA49'>5</th>
	<th bgcolor='#AFFA49'>6</th>
	<th bgcolor='#AFFA49'>7</th>
	<th bgcolor='#AFFA49'>8</th>
	<th bgcolor='#AFFA49'>50</th>
	<th bgcolor='#AFFA49'>60</th>
</tr>";

$semester_arr = array(1,2,3,4,5,6,7,8,50,60);


$orgformen = implode('/',$verwendete_orgformen);

$aktiv="
	<tr align=center>
		<td bgcolor='#AFFA49'>aktive Studenten ($orgformen)</td>";
$unterbrecher="
	<tr align=center>
		<td bgcolor='#AFFA49'>Unterbrecher ($orgformen)</td>";
$abbrecher="
	<tr align=center>
		<td bgcolor='#AFFA49'>Abbrecher ($orgformen)</td>";
$absolventen="
	<tr align=center>
		<td bgcolor='#AFFA49'>Absolventen ($orgformen)</td>";
$outgoing="
	<tr align=center>
		<td bgcolor='#AFFA49'>Outgoing ($orgformen)</td>";
foreach ($semester_arr as $semester)
{
	$aktiv.='<td>&nbsp;';
	$unterbrecher.='<td>&nbsp;';
	$abbrecher.='<td>&nbsp;';
	$absolventen.='<td>&nbsp;';
	$outgoing.='<td>&nbsp;';
	
	$i=0;
	foreach($verwendete_orgformen as $orgform)
	{
		if($i!=0)
		{
			$aktiv.=' / ';
			$unterbrecher.=' / ';
			$abbrecher.=' / ';
			$absolventen.=' / ';
			$outgoing.=' / ';
		}
		
		$aktiv .= (isset($stsem[$orgform][$semester])?$stsem[$orgform][$semester]:'');
		$unterbrecher .= (isset($usem[$orgform][$semester])?$usem[$orgform][$semester]:'');
		$abbrecher .= (isset($asem[$orgform][$semester])?$asem[$orgform][$semester]:'');
		$absolventen .= (isset($absem[$orgform][$semester])?$absem[$orgform][$semester]:'');
		$outgoing .= (isset($iosem[$orgform][$semester])?$iosem[$orgform][$semester]:'');
		
		$i++;
	}
	$aktiv.='</td>';
	$unterbrecher.='</td>';
	$abbrecher.='</td>';
	$absolventen.='</td>';
	$outgoing.='</td>';
}
$aktiv.='</tr>';
$unterbrecher.='</tr>';
$abbrecher.='</tr>';
$absolventen.='</tr>';
$outgoing.='</tr>';


$tabelle.=$aktiv.$unterbrecher.$abbrecher.$absolventen.$outgoing.
"
<tr align=center style='border-top:1px solid black'>
	<td bgcolor='#AFFA49'>Incoming</td>
	<td>".(isset($iosem[0])?$iosem[0]:'')."</td>
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

$tabelle.= "
<td bgcolor='#AFFA49'>Bewerber(ges.)($orgformen)</td>
<td bgcolor='#DED8FE'>".(isset($bewerbercount[0])?$bewerbercount[0]:0)."</td>
<td bgcolor='#DED8FE'>";
for($i=0;$i<sizeof($verwendete_orgformen);$i++)
{
	if($i!=0)
		$tabelle.=' / ';
	
	$tabelle.= isset($bewerbercount[$verwendete_orgformen[$i]])?$bewerbercount[$verwendete_orgformen[$i]]:'';
}
$tabelle.='</td>';

$tabelle.= "
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td bgcolor='#FF0000'>".$anzahl_fehler."</td>
</tr>
</table>
<br>";
echo $tabelle;

$ddd='bisdaten/bismeldung_'.$ssem.'_Stg'.$stg_kz.'.xml';

$dateiausgabe=fopen($ddd,'w');
fwrite($dateiausgabe,$datei);
fclose($dateiausgabe);

$eee='bisdaten/tabelle_'.$ssem.'_Stg'.$stg_kz.'.html';

$dateiausgabe=fopen($eee,'w');
fwrite($dateiausgabe,$tabelle);
fclose($dateiausgabe);

if(file_exists($ddd))
{
	echo '<a href="archiv.php?meldung='.$ddd.'&html='.$eee.'&stg='.$stg_kz.'&sem='.$ssem.'&typ=studenten&action=archivieren">BIS-Meldung Stg '.$stg_kz.' archivieren</a><br>';
	echo '<a href="'.$ddd.'">XML-Datei f&uuml;r BIS-Meldung Stg '.$stg_kz.'</a><br>';
}
if(file_exists($eee))
{
	echo '<a href="'.$eee.'">BIS-Melde&uuml;bersicht der BIS-Meldung Stg '.$stg_kz.'</a><br><br>';
}

echo '<table border=1>
	<tr align=center>
		<th>UID</th>
		<th>Matrikelnr</th>
		<th>Nachname</th>
		<th>Vorname</th>
		<th>Status</th>
		<th>Semester</th>
		<th>Orgform</th>
	</tr>
	',$stlist,'
	</table>';

echo '<br>Bewerber&uuml;bersicht';
echo '<table border=1>
	<tr align=center>
		<th>Nachname</th>
		<th>Vorname</th>
	</tr>
	',$bwlist,'
	</table>';

echo '</body></html>';

/**************************************************************************
 *  FUNKTIONEN 
 **************************************************************************/

/**
 * Generiert den Studenten Block
 */
function GenerateXMLStudentBlock($row)
{
	global $bisdatum, $db;
	global $ssem, $psem;
	global $v;
	global $stgart, $maxsemester, $orgform_kurzbz, $bisprevious,$anzahl_fehler;
	global $iosem, $stsem, $usem, $asem, $absem, $stlist;
	global $verwendete_orgformen, $datum_obj,$orgform_code_array,$standortcode;
	$error_log='';
	$error_log1='';
	$datei = '';
	$datumobj = new datum();
	
	//Pruefen ob Ausserordnetlicher Studierender (4.Stelle in Personenkennzeichen = 9)
	if(mb_substr($row->matrikelnr,3,1)=='9')
		$ausserordentlich=true;
	else
		$ausserordentlich=false;
		
	$qryadr="SELECT * FROM public.tbl_adresse WHERE heimatadresse IS TRUE AND person_id=".$db->db_add_param($row->pers_id).";";
	$results=$db->db_query($qryadr);

	if($db->db_num_rows($results)!=1)
	{
		$error_log1="Es sind ".$db->db_num_rows($results)." Heimatadressen eingetragen\n";
	}
	if($rowadr=$db->db_fetch_object($results))
	{
		$plz=$rowadr->plz;
		$gemeinde=$rowadr->gemeinde;
		$strasse=$rowadr->strasse;
		$nation=$rowadr->nation;
	}
	else
	{
		$plz='';
		$gemeinde='';
		$strasse='';
		$nation='';
	}
	if($row->gebdatum<'1920-01-01' OR $row->gebdatum==null OR $row->gebdatum=='')
	{
		$error_log.=(!empty($error_log)?', ':'')."Geburtsdatum ('".$row->gebdatum."')";
	}
	if($row->geschlecht!='m' && $row->geschlecht!='w')
	{
		$error_log.=(!empty($error_log)?', ':'')."Geschlecht ('".$row->geschlecht."')";
	}
	if($row->vorname=='' || $row->vorname==null)
	{
		$error_log.=(!empty($error_log)?', ':'')."Vorname ('".$row->vorname."')";
	}
	if($row->nachname=='' || $row->nachname==null)
	{
		$error_log.=(!empty($error_log)?', ':'')."Nachname ('".$row->nachname."')";
	}
	if($row->svnr!='' && $row->svnr!=null && mb_strlen(trim($row->svnr))!=10)
	{
		$error_log.=(!empty($error_log)?', ':'')."SVNR ('".trim($row->svnr)."') ist nicht 10 Zeichen lang";
	}
	if($row->ersatzkennzeichen!='' && $row->ersatzkennzeichen!=null && mb_strlen(trim($row->ersatzkennzeichen))!=10)
	{
		$error_log.=(!empty($error_log)?', ':'')."Ersatzkennzeichen ('".trim($row->ersatzkennzeichen)."') ist nicht 10 Zeichen lang";
	}
	if($row->svnr!='' && $row->svnr!=null && substr($row->svnr,4,6)!=$row->vdat && substr($row->vdat,0,4)!='0101' && substr($row->vdat,0,4)!='0107')
	{
		$error_log.=(!empty($error_log)?', ':'')."SVNR ('".$row->svnr."') enth&auml;lt Geburtsdatum (".$datum_obj->formatDatum($row->gebdatum,'d.m.Y').") nicht";
	}
	if($row->ersatzkennzeichen!='' && $row->ersatzkennzeichen!=null && substr($row->ersatzkennzeichen,4,6)!=$row->vdat)
	{
		$error_log.=(!empty($error_log)?', ':'')."Ersatzkennzeichen ('".$row->ersatzkennzeichen."') enth&auml;lt Geburtsdatum (".$datum_obj->formatDatum($row->gebdatum,'d.m.Y').") nicht";
	}
	if(($row->svnr=='' || $row->svnr==null)&&($row->ersatzkennzeichen=='' || $row->ersatzkennzeichen==null))
	{
		$error_log.=(!empty($error_log)?', ':'')."SVNR ('".$row->svnr."') bzw. ErsKz ('".$row->ersatzkennzeichen."') fehlt";
	}
	if($row->staatsbuergerschaft=='' || $row->staatsbuergerschaft==null)
	{
		$error_log.=(!empty($error_log)?', ':'')."Staatsb&uuml;rgerschaft ('".$row->staatsbuergerschaft."')";
	}
	if($plz=='' || $plz==null)
	{
		$error_log.=(!empty($error_log)?', ':'')."Heimat-PLZ ('".$plz."')";
	}
	if($gemeinde=='' || $gemeinde==null)
	{
		$error_log.=(!empty($error_log)?', ':'')."Heimat-Gemeinde ('".$gemeinde."')";
	}
	if($strasse=='' || $strasse==null)
	{
		$error_log.=(!empty($error_log)?', ':'')."Heimat-Strasse ('".$strasse."')";
	}
	if($nation=='' || $nation==null)
	{
		$error_log.=(!empty($error_log)?', ':'')."Heimat-Nation ('".$nation."')";
	}
	if(!$ausserordentlich)
	{
		if($row->zgv_code=='' || $row->zgv_code==null)
		{
			$error_log.=(!empty($error_log)?', ':'')."ZugangCode ('".$row->zgv_code."')";
		}
		if($row->zgvdatum=='' || $row->zgvdatum==null)
		{
			$error_log.=(!empty($error_log)?', ':'')."ZugangDatum ('".$row->zgvdatum."')";
		}
		else
		{
			if($row->zgvdatum>date("Y-m-d"))
			{
					$error_log.=(!empty($error_log)?', ':'')."ZugangDatum liegt in der Zukunft ('".$row->zgvdatum."')";
			}
		}
		if($stgart==2) // Master-Studiengang
		{
			if($row->zgvmas_code=='' || $row->zgvmas_code==null)
			{
					$error_log.=(!empty($error_log)?', ':'')."ZugangMaStgCode ('".$row->zgvmas_code."')";
			}
			if($row->zgvmadatum=='' || $row->zgvmadatum==null)
			{
					$error_log.=(!empty($error_log)?', ':'')."ZugangMaStgDatum ('".$row->zgvmadatum."')";
			}
			else
			{
				if($row->zgvmadatum>date("Y-m-d"))
				{
						$error_log.=(!empty($error_log)?', ':'')."ZugangMaStgDatum liegt in der Zukunft ('".$row->zgvmadatum."')";
				}
				if($row->zgvmadatum<$row->zgvdatum)
				{
						$error_log.=(!empty($error_log)?', ':'')."ZugangMaStgDatum ('".$row->zgvmadatum."') kleiner als Zugangdatum ('".$row->zgvdatum."')";
				}
				if($row->zgvmadatum<$row->gebdatum)
				{
						$error_log.=(!empty($error_log)?', ':'')."ZugangMaStgDatum ('".$row->zgvmadatum."') kleiner als Geburtsdatum ('".$row->gebdatum."')";
				}
			}
		}
	}
	
	//StudStatusCode und Semester ermitteln
	$qrystatus="SELECT * FROM public.tbl_prestudentstatus
		WHERE prestudent_id=".$db->db_add_param($row->prestudent_id)." AND studiensemester_kurzbz=".$db->db_add_param($ssem)." AND (tbl_prestudentstatus.datum<=".$db->db_add_param($bisdatum).")
		ORDER BY datum desc, insertamum desc, ext_id desc;";
	if($resultstatus = $db->db_query($qrystatus))
	{
		if($db->db_num_rows($resultstatus)>0)
		{
			if($rowstatus = $db->db_fetch_object($resultstatus))
			{
				$qry1="SELECT count(*) AS dipl FROM public.tbl_prestudentstatus WHERE prestudent_id=".$db->db_add_param($row->prestudent_id)." AND (tbl_prestudentstatus.datum<=".$db->db_add_param($bisdatum).") AND status_kurzbz='Diplomand'";
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
					$error_log.= "$row->vorname $row->nachname wird nicht gemeldet da kein gueltiger Status vorhanden ist!";
					return '';
				}
				$aktstatus=$rowstatus->status_kurzbz;
				$aktstatus_datum=$rowstatus->datum;
				$storgform=$rowstatus->orgform_kurzbz;
			}
		}
		else
		{
			$qrystatus="SELECT * FROM public.tbl_prestudentstatus WHERE prestudent_id=".$db->db_add_param($row->prestudent_id)." AND studiensemester_kurzbz=".$db->db_add_param($psem)." AND (tbl_prestudentstatus.datum<=".$db->db_add_param($bisdatum).") ORDER BY datum desc, insertamum desc, ext_id desc;";
			if($resultstatus = $db->db_query($qrystatus))
			{
				if($rowstatus = $db->db_fetch_object($resultstatus))
				{
					$qry1="SELECT count(*) AS dipl FROM public.tbl_prestudentstatus WHERE prestudent_id=".$db->db_add_param($row->prestudent_id)." AND status_kurzbz='Diplomand' AND (tbl_prestudentstatus.datum<=".$db->db_add_param($bisdatum).")";
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
					
					if($ausserordentlich)
					{
						$status=1;
					}
					else if($rowstatus->status_kurzbz=="Incoming")
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
						$error_log.= "$row->vorname $row->nachname wird nicht gemeldet da kein gueltiger Status vorhanden ist!";
						return '';
					}
					$aktstatus=$rowstatus->status_kurzbz;
					$aktstatus_datum=$rowstatus->datum;
					$storgform=$rowstatus->orgform_kurzbz;
				}
			}
		}
	}
	//Wenn im Status keine Organisationsform eingetragen ist, wird die des Studienganges uebernommen
	if($storgform=='')
		$storgform=$orgform_kurzbz;
	
	//bei Absolventen das Beendigungsdatum (Sponsion oder Abschlussprüfung) überprüfen
	if($aktstatus=='Absolvent')
	{
		$qry_ap="SELECT * FROM lehre.tbl_abschlusspruefung WHERE student_uid=".$db->db_add_param($row->student_uid)." AND abschlussbeurteilung_kurzbz!='nicht' AND abschlussbeurteilung_kurzbz IS NOT NULL";
		if($result_ap = $db->db_query($qry_ap))
		{
			$ap=0;
			while($row_ap = $db->db_fetch_object($result_ap))
			{
				if($row_ap->datum=='' || $row_ap->datum==null)
				{
					$error_log.=(!empty($error_log)?', ':'')."Datum der Abschlusspr&uuml;fung ('".$row_ap->datum."')";
				}
				if($row_ap->sponsion=='' || $row_ap->sponsion==null)
				{
					$error_log.=(!empty($error_log)?', ':'')."Datum der Sponsion ('".$row_ap->sponsion."')";
				}
				$ap++;
			}
			if($ap!=1)
			{
				$error_log.=(!empty($error_log)?', ':'').$ap." bestandene Abschlußprüfungen";
			}
		}
		else
		{
			die("\nQry Failed:".$qry_ap);
		}
	}
<<<<<<< HEAD
	if($storgform!='VZ')
=======
	if($orgform_code_array[$storgform]!=1) // Wenn nicht Vollzeit
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	{
		if($row->berufstaetigkeit_code=='' || $row->berufstaetigkeit_code==null)
		{
			$error_log.=(!empty($error_log)?', ':'')."Berufst&auml;tigkeitscode ('".$row->berufstaetigkeit_code."')";
		}
	}
	if($aktstatus!='Incoming')
	{
		if(!$row->reihungstestangetreten)
		{
			$error_log.=(!empty($error_log)?', ':'')."Zum Reihungstest angetreten";
		}
		if($sem==0)
		{
			$error_log.=(!empty($error_log)?', ':'')."Aktuelles Semester (Rolle) ('".$sem."')";
		}
	}
	else
	{
		if($nation=='A' || $nation=='a')
		{
			$error_log.=(!empty($error_log)?', ':'')."Heimat-Nation bei Incoming('".$nation."')";
		}
	}
	
	$qryad="SELECT * FROM public.tbl_prestudentstatus 
				WHERE prestudent_id=".$db->db_add_param($row->prestudent_id)." 
				AND (status_kurzbz='Student' OR status_kurzbz='Unterbrecher') 
				AND (tbl_prestudentstatus.datum<=".$db->db_add_param($bisdatum).") ORDER BY datum asc;";
	if($resultad = $db->db_query($qryad))
	{
		if($rowad = $db->db_fetch_object($resultad))
		{
			$beginndatum = $rowad->datum;
		}
		else
			$beginndatum='';
	}
	if($row->ausstellungsstaat=='' && ($datumobj->mktime_fromdate($beginndatum) > $datumobj->mktime_fromdate('2011-04-15')) && !$ausserordentlich)
	{
		$error_log.=(!empty($error_log)?', ':'')."Ausstellungsstaat ist nicht eingetragen";
	}
	
	if($error_log!='' OR $error_log1!='')
	{
		$v.="<u>Bei Student (UID, Vorname, Nachname) '".$row->student_uid."', '".$row->nachname."', '".$row->vorname."' ($row->status_kurzbz): </u>\n";
		if($error_log!='')
		{
			$v.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fehler: ".$error_log."\n";
		}
		if($error_log1!='')
		{
			$v.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$error_log1;
		}
		$anzahl_fehler++;
		$v.="\n";
		$error_log='';
		$error_log1='';
		return '';
	}
	else
	{
		$datei.="
		<StudentIn>
			<PersKz>".trim($row->matrikelnr)."</PersKz>";
		if(!$ausserordentlich)
		{
			$datei.="
			<OrgFormCode>".$orgform_code_array[$storgform]."</OrgFormCode>";
		}
		
		$datei.="
			<GeburtsDatum>".date("dmY", $datumobj->mktime_fromdate($row->gebdatum))."</GeburtsDatum>
			<Geschlecht>".strtoupper($row->geschlecht)."</Geschlecht>";
		if(($row->svnr!='')&&($row->ersatzkennzeichen!=''))
		{
			$datei.="
			<Vorname>".$row->vorname."</Vorname>
			<Familienname>".$row->nachname."</Familienname>";
			$datei.="
			<SVNR>".$row->svnr."</SVNR>";
			$datei.="
			<ErsKz>".$row->ersatzkennzeichen."</ErsKz>";
		}
		else
		{
			if($row->svnr!='')
			{
				$datei.="
			<SVNR>".$row->svnr."</SVNR>";
			}
			if($row->ersatzkennzeichen!='')
			{
				$datei.="
			<Vorname>".$row->vorname."</Vorname>
			<Familienname>".$row->nachname."</Familienname>";
				$datei.="
			<ErsKz>".$row->ersatzkennzeichen."</ErsKz>";
			}
		}
		$datei.="
			<StaatsangehoerigkeitCode>".$row->staatsbuergerschaft."</StaatsangehoerigkeitCode>
			<HeimatPLZ>".$plz."</HeimatPLZ>
			<HeimatGemeinde>".$gemeinde."</HeimatGemeinde>
			<HeimatStrasse><![CDATA[".$strasse."]]></HeimatStrasse>
			<HeimatNation>".$nation."</HeimatNation>";
		if(!$ausserordentlich)
		{
			$datei.="
				<ZugangCode>".$row->zgv_code."</ZugangCode>";
			$datei.="
				<ZugangDatum>".date("dmY", $datumobj->mktime_fromdate($row->zgvdatum))."</ZugangDatum>";
		}

		if($stgart==2) // Master-Studiengang
		{
			$datei.="
			<ZugangMaStgCode>".$row->zgvmas_code."</ZugangMaStgCode>";
			$datei.="
			<ZugangMaStgDatum>".date("dmY", $datumobj->mktime_fromdate($row->zgvmadatum))."</ZugangMaStgDatum>";
		}
		
		if($aktstatus!='Incoming' && !$ausserordentlich)
		{
			if($row->ausstellungsstaat!='' && ($datumobj->mktime_fromdate($beginndatum) > $datumobj->mktime_fromdate('2011-04-15')))
			{
				$datei.='
				<Ausstellungsstaat>'.$row->ausstellungsstaat.'</Ausstellungsstaat>';
			}
		}
				
		if($beginndatum!='' && !$ausserordentlich)
		{
			$datei.="
			<BeginnDatum>".date("dmY", $datumobj->mktime_fromdate($beginndatum))."</BeginnDatum>";
		}
			
		if($aktstatus=='Absolvent' || $aktstatus=='Abbrecher')
		{
			$datei.="
			<BeendigungsDatum>".date("dmY", $datumobj->mktime_fromdate($aktstatus_datum))."</BeendigungsDatum>";
		}
		if($aktstatus!='Incoming' && !$ausserordentlich)
		{
			$datei.="
			<Ausbildungssemester>".$sem."</Ausbildungssemester>";
		}
		
		$datei.="
			<StudStatusCode>".$status."</StudStatusCode>";
<<<<<<< HEAD
		if($storgform!='VZ' && !$ausserordentlich)
=======
		if($orgform_code_array[$storgform]!=1 && !$ausserordentlich) // Wenn nicht Vollzeit und nicht Ausserordentlich
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$datei.="
			<BerufstaetigkeitCode>".$row->berufstaetigkeit_code."</BerufstaetigkeitCode>";
		}

		if(!$ausserordentlich)
		{
			$datei.="
					<StandortCode>".$standortcode."</StandortCode>";
		}
		/*
		 * BMWFFoerderrung derzeit fuer alle Studierende auf Ja gesetzt
		 * Ausnahme: ausserordnetliche Studierende und Incoming
		 * 
		 * ToDo: sollte pro Studierenden konfigurierbar sein
		 */
		if($aktstatus=='Incoming' || $ausserordentlich)
			$bmwf='N';
		else
			$bmwf='J';
		
		$datei.="
				<BMWFWfoerderrelevant>".$bmwf."</BMWFWfoerderrelevant>";
		
		$qryio="SELECT * FROM bis.tbl_bisio WHERE student_uid=".$db->db_add_param($row->student_uid)."
					AND (von>".$db->db_add_param($bisprevious)." OR bis IS NULL OR bis>".$db->db_add_param($bisprevious).")
					AND von<=".$db->db_add_param($bisdatum).";";
		if($resultio = $db->db_query($qryio))
		{
			while($rowio = $db->db_fetch_object($resultio))
			{
				$mob=$rowio->mobilitaetsprogramm_code;
				$gast=$rowio->nation_code;
				$avon=date("dmY", $datumobj->mktime_fromdate($rowio->von));
				$abis=date("dmY", $datumobj->mktime_fromdate($rowio->bis));
				$zweck=$rowio->zweck_code;

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
				if($aktstatus!='Incoming')
				{
					if(!isset($iosem[$storgform][$sem]))
					{
						$iosem[$storgform][$sem]=0;
					}
					$iosem[$storgform][$sem]++;
				}
				else
				{
					if(!isset($iosem[0]))
					{
						$iosem[0]=0;
					}
					$iosem[0]++;
				}
			}
		}
		
		$datei.="
		</StudentIn>";

		if($aktstatus=='Student' || $aktstatus=='Diplomand' || $aktstatus=='Praktikant' || $aktstatus=='Outgoing')
		{
			if(!isset($stsem[$storgform][$sem]))
			{
				$stsem[$storgform][$sem]=0;
			}
			$stsem[$storgform][$sem]++;
		}
		if($aktstatus=='Unterbrecher')
		{
			if(!isset($usem[$storgform][$sem]))
			{
				$usem[$storgform][$sem]=0;
			}
			$usem[$storgform][$sem]++;
		}
		if($aktstatus=='Abbrecher')
		{
			if(!isset($asem[$storgform][$sem]))
			{
				$asem[$storgform][$sem]=0;
			}
			$asem[$storgform][$sem]++;
		}
		if($aktstatus=='Absolvent')
		{
			if(!isset($absem[$storgform][$sem]))
			{
				$absem[$storgform][$sem]=0;
			}
			$absem[$storgform][$sem]++;
		}
	}
	if(!in_array($storgform, $verwendete_orgformen))
		$verwendete_orgformen[]=$storgform;
	
	//Studentenliste
	$stlist.="<tr><td align=center>".trim($row->student_uid)."</td><td align=center>".trim($row->matrikelnr)."</td><td>".trim($row->nachname)."</td><td>".trim($row->vorname)."</td><td>".trim($aktstatus)."</td><td align=center>".trim($sem)."</td><td align=center>".trim($storgform)."</td></tr>";
	return $datei;
}

/**
 * Erstellt die Bewerbermeldung
 *
 * Wenn der Parameter orgformcode uebergeben wird, werden nur die Bewerberzahlen dieser Orgform geliefert
 * sonst alle
 */
function GenerateXMLBewerberBlock($orgformcode=null)
{
	global $db;
	global $ssem, $stgart, $psem;
	global $stg_kz, $bisdatum;
	global $bwlist, $orgform_kurzbz;
	global $bewerbercount,$orgform_code_array;
	$datei = '';
	$bewerberM=array();
	$bewerberW=array();
	
	if(mb_strstr($ssem,"WS"))
	{
		//Bewerber
		$qrybw="SELECT * FROM public.tbl_prestudent
			JOIN public.tbl_prestudentstatus ON(tbl_prestudent.prestudent_id=tbl_prestudentstatus.prestudent_id)
			JOIN public.tbl_person USING(person_id)
			LEFT JOIN bis.tbl_orgform USING(orgform_kurzbz)
			WHERE (studiensemester_kurzbz=".$db->db_add_param($ssem)." OR studiensemester_kurzbz=".$db->db_add_param($psem).") AND tbl_prestudent.studiengang_kz=".$db->db_add_param($stg_kz)."
			AND (tbl_prestudentstatus.datum<=".$db->db_add_param($bisdatum).")
			AND status_kurzbz='Bewerber' AND reihungstestangetreten
			";
		if(!is_null($orgformcode))
			$qrybw.=" AND tbl_orgform.code=".$db->db_add_param($orgformcode);
		
		if($resultbw = $db->db_query($qrybw))
		{
			while($rowbw = $db->db_fetch_object($resultbw))
			{
				// Bachelor / Diplom
				if(($stgart==1 || $stgart==3) && $rowbw->zgv_code!=NULL)
				{
					if(strtoupper($rowbw->geschlecht)=='M')
					{
						if(!isset($bewerberM[$rowbw->zgv_code]))
						{
							$bewerberM[$rowbw->zgv_code]=0;
						}
						$bewerberM[$rowbw->zgv_code]++;
					}
					else
					{
						if(!isset($bewerberW[$rowbw->zgv_code]))
						{
							$bewerberW[$rowbw->zgv_code]=0;
						}
						$bewerberW[$rowbw->zgv_code]++;
					}
				}
				// Master
				if($stgart==2 && $rowbw->zgvmas_code!=NULL)
				{
					if(strtoupper($rowbw->geschlecht)=='M')
					{
						if(!isset($bewerberM[$rowbw->zgvmas_code]))
						{
							$bewerberM[$rowbw->zgvmas_code]=0;
						}
						$bewerberM[$rowbw->zgvmas_code]++;
					}
					else
					{
						if(!isset($bewerberW[$rowbw->zgvmas_code]))
						{
							$bewerberW[$rowbw->zgvmas_code]=0;
						}
						$bewerberW[$rowbw->zgvmas_code]++;
					}
				}
				$bworgform = ($rowbw->orgform_kurzbz!=''?$rowbw->orgform_kurzbz:$orgform_kurzbz);
				
				if(isset($bewerbercount[0]))
					$bewerbercount[0]++;
				else 
					$bewerbercount[0]=1;
				if(isset($bewerbercount[$bworgform]))
					$bewerbercount[$bworgform]++;
				else 
					$bewerbercount[$bworgform]=1;
				
				$bwlist.='<tr><td>'.trim($rowbw->nachname).'</td><td>'.trim($rowbw->vorname).'</td><td>'.$bworgform.'</td></tr>';
			}
		}

		foreach(array_keys($bewerberM) as $key)
			if(!isset($bewerberW[$key]))
				$bewerberW[$key]=0;

		foreach(array_keys($bewerberW) as $key)
		{
			if(!isset($bewerberM[$key]))
				$bewerberM[$key]=0;
			$datei.="
			<BewerberInnen>
			<OrgFormCode>".$orgform_code_array[$bworgform]."</OrgFormCode>";
			if($stgart==2)
				$datei.='
				<ZugangMaStgCode>'.$key.'</ZugangMaStgCode>';
			else 
				$datei.='
				<ZugangCode>'.$key.'</ZugangCode>';

			$datei.='
				<AnzBewerberM>'.$bewerberM[$key].'</AnzBewerberM>
				<AnzBewerberW>'.$bewerberW[$key].'</AnzBewerberW>
			</BewerberInnen>';
		}
	}
	return $datei;
}
<<<<<<< HEAD
?>
=======
?>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
