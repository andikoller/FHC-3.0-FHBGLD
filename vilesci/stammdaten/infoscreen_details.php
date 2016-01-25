<?php
/* Copyright (C) 2011 FH Technikum-Wien
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
 * Authors: Andreas Oesterreicher 	< andreas.oesterreicher@technikum-wien.at >
 */
/**
 * Seite zur Wartung der Infoscreens
 */
require_once('../../config/vilesci.config.inc.php');		
require_once('../../include/infoscreen.class.php');
require_once('../../include/benutzerberechtigung.class.php');
require_once('../../include/datum.class.php');
require_once('../../include/content.class.php');

if (!$db = new basis_db())
	die('Es konnte keine Verbindung zum Server aufgebaut werden.');
		
$user = get_uid();
	
$rechte = new benutzerberechtigung();
$rechte->getBerechtigungen($user);
	
if(!$rechte->isBerechtigt('basis/infoscreen'))
<<<<<<< HEAD
	die('Sie haben keine Berechtigung fuer diese Seite');
=======
	die($rechte->errormsg);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	
$datum_obj = new datum();
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Infoscreen - Details</title>
	<link rel="stylesheet" href="../../skin/tablesort.css" type="text/css"/>
	<link rel="stylesheet" href="../../skin/fhcomplete.css" type="text/css">
	<link rel="stylesheet" href="../../skin/vilesci.css" type="text/css">	
<<<<<<< HEAD
	<script type="text/javascript" src="../../include/js/jquery.js"></script> 
	<script type="text/javascript">
	$(document).ready(function() 
		{ 
		    $("#myTable").tablesorter(
			{
				sortList: [[0,0],[5,0]],
				widgets: ['zebra']
			}); 
=======
	<link rel="stylesheet" href="../../skin/jquery-ui-1.9.2.custom.min.css" type="text/css">
	<link rel="stylesheet" href="../../skin/jquery.ui.timepicker.css" type="text/css">
	<script type="text/javascript" src="../../include/js/jquery.js"></script>
	<script type="text/javascript" src="../../include/js/tablesort/table.js"></script>
	<script type="text/javascript" src="../../include/js/jquery1.9.min.js"></script>
	<script type="text/javascript" src="../../include/js/jquery.ui.timepicker.js"></script>
	<script type="text/javascript">
	$(document).ready(function() 
		{ 
			$("#myTable").tablesorter(
			{
				sortList: [[0,0],[5,0]],
				widgets: ['zebra']
			});
			
			$( ".datepicker_datum" ).datepicker({
				changeMonth: true,
				changeYear: true, 
				dateFormat: "dd.mm.yy",
				showButtonPanel: true,
				currentText: "Today",
				closeText: "Close",
			 });
	
			$( ".timepicker" ).timepicker({
				showPeriodLabels: false,
				hourText: "Hour",
				minuteText: "Minute",
				rows: 4,
			});

			/*
			$("#refreshzeit").timepicker(
			{
				showPeriodLabels: false,
				showHours: false,
				minuteText: "",
				minutes: {starts: 20, ends: 300, interval: 20},
				rows: 5,
			});*/
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		} 
	);
	function checkValue()
	{
		var zeit = document.getElementById("refreshzeit").value;
		if (!isNaN(zeit))
		{
			if(zeit > 32767)
			{
				alert("Maximalwert für Refreshzeit ist 32767");
				return false;
			}
			
		}
		else
		{
			alert("Wert für Refreshzeit ist ungültig");
			return false;
		}
	};
	</script>
<<<<<<< HEAD
=======
	<style>
	.ui-timepicker-table table td a
	{
	    padding:0.2em 0.3em 0.2em 0.3em;
	    width: 2em;
	}
	.ui-widget 
	{
    	font-size: 0.9em;
	}
	.ui-widget button
	{
    	font-size: 0.9em;
	}
	.ui-timepicker-table table
	{
    	font-size: 0.9em;
	}
	.ui-widget-content .ui-priority-secondary
	{
    	opacity: 1;
	}
	.ui-widget-content .ui-priority-primary
	{
	    font-weight: normal;
	}
	</style>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
</head>
<body>

<?php
	$action = (isset($_GET['action'])?$_GET['action']:'show');
	$infoscreen_id = (isset($_GET['infoscreen_id'])?$_GET['infoscreen_id']:'');
	$infoscreen = new infoscreen();
	
	if($infoscreen_id=='')
		exit;
		
	if(!$infoscreen->load($infoscreen_id))
		die($infoscreen->errormsg);
		
	echo '<h2>Details von Infoscreen ',$infoscreen_id,' - ',$infoscreen->bezeichnung.' - ',$infoscreen->beschreibung.'</h2>';
		
	echo '
	<div style="text-align:right">
		<a href="infoscreen_details.php?action=new&infoscreen_id=',$infoscreen_id,'" target="detail_infoscreen">Neuen Eintrag hinzufügen</a>
	</div>';
	
	if($action=='save')
	{
		if(!$rechte->isBerechtigt('basis/infoscreen', null, 'sui'))
<<<<<<< HEAD
			die('Sie haben keine Berechtigung fuer diese Seite');
		$my_infoscreen_id = $_POST['infoscreen_id'];
		$infoscreen_content_id = $_POST['infoscreen_content_id'];
		$content_id = $_POST['content_id'];
		$gueltigvon = $_POST['gueltigvon'];
		$gueltigbis = $_POST['gueltigbis'];
		$refreshzeit = $_POST['refreshzeit'];
=======
			die($rechte->errormsg);
		$my_infoscreen_id = $_POST['infoscreen_id'];
		$infoscreen_content_id = $_POST['infoscreen_content_id'];
		$content_id = $_POST['content_id'];
		$gueltigvon = $_POST['gueltigvondatum'].' '.$_POST['gueltigvonzeit'];
		$gueltigbis = $_POST['gueltigbisdatum'].' '.$_POST['gueltigbiszeit'];
		$refreshzeit = $_POST['refreshzeit'];
		$exklusiv = (isset ($_POST['exklusiv'])?true:false);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			
		$infoscreen = new infoscreen();
		if($infoscreen_content_id!='')
		{
			$infoscreen->loadContent($infoscreen_content_id);
			$infoscreen->new = false;
		}
		else
		{
			$infoscreen->new = true;
			$infoscreen->insertamum = date('Y-m-d H:i:s');
			$infoscreen->insertvon = $user;
		}
		
		$infoscreen->content_id = $content_id;
		$infoscreen->gueltigvon = $datum_obj->formatDatum($gueltigvon,'Y-m-d H:i:s');
		$infoscreen->gueltigbis = $datum_obj->formatDatum($gueltigbis,'Y-m-d H:i:s');
		$infoscreen->refreshzeit = $refreshzeit;
		$infoscreen->updateamum = date('Y-m-d H:i:s');
		$infoscreen->updatevon = $user;
<<<<<<< HEAD
=======
		$infoscreen->exklusiv = $exklusiv;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		
		$infoscreen_ids=explode(',',$my_infoscreen_id);
		if (count($infoscreen_ids)>1)
		{
			$infoscreen->new = true;
			$infoscreen->insertamum = date('Y-m-d H:i:s');
			$infoscreen->insertvon = $user;
		}

		$doppelt = false;
		foreach($infoscreen_ids as $is_id)
		{
			$infoscreen->infoscreen_id = $is_id;
			
			if ($doppelt==false)
			{
				if ($is_id==$infoscreen_id && $infoscreen_content_id!='')
				{
					$doppelt=true;
					$infoscreen->new = false;
				}
			}
			else
				$doppelt=false;
			
			if(!$infoscreen->saveContent())
				echo '<span class="error">Fehler bei Infoscreen '.$is_id.': '.$db->convert_html_chars($infoscreen->errormsg).'</span><br>';
			else
				echo '<span class="ok">Daten erfolgreich gespeichert für Infoscreen '.$is_id.'</span><br>';
				
			$infoscreen->new = true;
		}
	}
	if($action=='delete')
	{
		if(!$rechte->isBerechtigt('basis/infoscreen', null, 'suid'))
			die('Sie haben keine Berechtigung fuer diese Seite');
		$infoscreen = new infoscreen();
		$infoscreen_content_id = (isset($_REQUEST['infoscreen_content_id'])?$_REQUEST['infoscreen_content_id']:'');
		if(!$infoscreen->deleteContent($infoscreen_content_id))
			echo '<span class="error">',$db->convert_html_chars($infoscreen->errormsg),'</span>';
	}
	//Formular fuer neu/update
	if($action=='new' || $action=='update')
	{
		$infoscreen_content_id = (isset($_REQUEST['infoscreen_content_id'])?$_REQUEST['infoscreen_content_id']:'');
		$infoscreen = new infoscreen();
		if($action=='new')
		{
			echo '<h3>Neu</h3>';
		}
		else
		{
			echo '<h3>Bearbeiten von ID ',$infoscreen_content_id,'</h3>';
			if(!$infoscreen->loadContent($infoscreen_content_id))
				die('Fehler: '.$infoscreen->errormsg);			
		}
		echo '
		<form action="',$_SERVER['PHP_SELF'],'?action=save&infoscreen_id=',$infoscreen_id,'" method="POST">
		<input type="hidden" name="infoscreen_content_id" value="',$db->convert_html_chars($infoscreen->infoscreen_content_id),'">
		<table>
		<tr>
			<td>InfoscreenID(s)</td>
			<td><input type="text" size="15" name="infoscreen_id" value="',($action=='new'?$infoscreen_id:$db->convert_html_chars($infoscreen->infoscreen_id)),'" /> (Kommagetrennt für mehrere, keine ID für alle Infoscreens)</td>
		</tr>
		<tr>
			<td>Content ID</td>
			<td><input type="text" size="5" name="content_id" value="',$db->convert_html_chars($infoscreen->content_id),'" /></td>
		</tr>
		<tr>
			<td>Gültig von</td>
<<<<<<< HEAD
			<td><input type="text" id="gueltigvon" size="18" name="gueltigvon" value="',$db->convert_html_chars($datum_obj->formatDatum($infoscreen->gueltigvon,'d.m.Y H:i:s')),'" /> <input type="button" value="Jetzt" onclick="document.getElementById(\'gueltigvon\').value=\''.date('d.m.Y H:i:s').'\';" /> ( Format: ',date('d.m.Y H:i:s'),' )</td>
		</tr>
		<tr>
			<td>Gültig bis</td>
			<td><input type="text" id="gueltigbis" size="18" name="gueltigbis" value="',$db->convert_html_chars($datum_obj->formatDatum($infoscreen->gueltigbis,'d.m.Y H:i:s')),'" /> <input type="button" value="Jetzt" onclick="document.getElementById(\'gueltigbis\').value=\''.date('d.m.Y H:i:s').'\';" /> ( Format: ',date('d.m.Y H:i:s'),' )</td>
=======
			<td>
						<input class="datepicker_datum" type="text" id="gueltigvondatum" size="10" name="gueltigvondatum" placeholder= "dd.mm.yyyy"value="',$db->convert_html_chars($datum_obj->formatDatum($infoscreen->gueltigvon,'d.m.Y')),'" />
						<input class="timepicker" type="text" id="gueltigvonzeit" size="6" name="gueltigvonzeit" placeholder= "hh:mm" value="',$db->convert_html_chars($datum_obj->formatDatum($infoscreen->gueltigvon,'H:i')),'" />
						<input type="button" value="Jetzt" onclick="document.getElementById(\'gueltigvondatum\').value=\''.date('d.m.Y').'\';document.getElementById(\'gueltigvonzeit\').value=\''.date('H:i').'\';" />
						<input type="button" value="Leeren" onclick="document.getElementById(\'gueltigvondatum\').value=\'\';document.getElementById(\'gueltigvonzeit\').value=\'\';" />
			</td>
		</tr>
		<tr>
			<td>Gültig bis</td>
			<td>
						<input class="datepicker_datum" type="text" id="gueltigbisdatum" size="10" name="gueltigbisdatum" placeholder= "dd.mm.yyyy"value="',$db->convert_html_chars($datum_obj->formatDatum($infoscreen->gueltigbis,'d.m.Y')),'" />
						<input class="timepicker" type="text" id="gueltigbiszeit" size="6" name="gueltigbiszeit" placeholder= "hh:mm" value="',$db->convert_html_chars($datum_obj->formatDatum($infoscreen->gueltigbis,'H:i')),'" />
						<input type="button" value="Jetzt" onclick="document.getElementById(\'gueltigbisdatum\').value=\''.date('d.m.Y').'\';document.getElementById(\'gueltigbiszeit\').value=\''.date('H:i').'\'" />
						<input type="button" value="Leeren" onclick="document.getElementById(\'gueltigbisdatum\').value=\'\';document.getElementById(\'gueltigbiszeit\').value=\'\';" />
			</td>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		</tr>
		<tr>
			<td>Refreshzeit</td>
			<td><input id="refreshzeit" type="text" size="18" name="refreshzeit" value="',$db->convert_html_chars($infoscreen->refreshzeit),'"/> Zeit, wie lange die Seite angezeigt wird (in Sekunden)</td>
		</tr>
		<tr>
<<<<<<< HEAD
=======
			<td>Exklusiv</td>
			<td><input id="exklusiv" type="checkbox" name="exklusiv" '.($infoscreen->exklusiv===true?'checked':'').'/> Exklusiveinträge haben Vorrang vor normalen Einträgen</td>
		</tr>
		<tr>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			<td></td>
			<td><input type="submit" value="Speichern" onclick="return checkValue();"/></td>
		</tr>
		</table>
		</form>';
	}
	
<<<<<<< HEAD
	if(!$infoscreen->getScreenContent($infoscreen_id, false))
=======
	if(!$infoscreen->getScreenContent($infoscreen_id, false, false))
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		die('Fehler:'.$infoscreen->errormsg);
	echo '<table class="tablesorter" id="myTable">
			<thead>
			<tr>
				<th>Status</th>
				<th>ID</th>
				<th>InfoscreenID</th>
				<th>ContentID</th>
				<th>Titel</th>
				<th>Gültig von</th>
				<th>Gültig bis</th>
				<th>Refreshzeit</th>
<<<<<<< HEAD
=======
				<th>Exklusiv</th>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				<th colspan="2">Aktion</th>
			</tr>
			</thead>
			<tbody>';
			
	$jetzt = time();
	$aktiv=false;
	$zukunft=false;
<<<<<<< HEAD

	foreach($infoscreen->result as $row)
	{
=======
	$exklusiv = false;

	//Wenn mindestens ein Content als Exklusiv markiert ist, wird dieser vorrangig behandelt
	foreach($infoscreen->result as $row)
	{
		$gueltigvon=$datum_obj->mktime_fromtimestamp($row->gueltigvon);
		$gueltigbis=$datum_obj->mktime_fromtimestamp($row->gueltigbis);
		
		if($row->exklusiv==true && (($gueltigvon<=$jetzt) || ($gueltigvon=='')) && (($gueltigbis>=$jetzt) || ($gueltigbis=='')))
			$exklusiv = true;
	}
	foreach($infoscreen->result as $row)
	{
		$passiv=false;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		$content = new content();
		$content->getContent($row->content_id, 'German');
		$gueltigvon=$datum_obj->mktime_fromtimestamp($row->gueltigvon);
		$gueltigbis=$datum_obj->mktime_fromtimestamp($row->gueltigbis);
		
<<<<<<< HEAD
		if ((($gueltigvon<=$jetzt) || ($gueltigvon=='')) && (($gueltigbis>=$jetzt) || ($gueltigbis=='')))
			$aktiv=true;
		else 
			$aktiv=false;
			
		if ($aktiv==false && ($gueltigvon>=$jetzt))
			$zukunft=true;
		else
			$zukunft=false;
		
		echo '<tr '.($aktiv==true?'':'style="color:grey"').'>';
		echo '<td width="10px" align="center">'.($aktiv==false?($zukunft==true?'<img title="2 gelb" src="../../skin/images/ampel_gelb.png" alt="ampel_gelb">':'<img title="3 rot" src="../../skin/images/ampel_rot.png" alt="ampel_rot">'):'<img title="1 gruen" src="../../skin/images/ampel_gruen.png" alt="ampel_gruen">').'</td>';
=======
		if ((($gueltigvon<=$jetzt) || ($gueltigvon=='')) && (($gueltigbis>=$jetzt) || ($gueltigbis=='')) && ($exklusiv==false && $row->exklusiv==false))
			$aktiv=true;
		elseif ($exklusiv==true && $row->exklusiv==true)
			$aktiv=true;
		else 
		{
			$aktiv=false;
		}
			
		if ($aktiv==false && ($gueltigvon>=$jetzt))
			$zukunft=true;
		elseif ((($gueltigvon<=$jetzt) || ($gueltigvon=='')) && (($gueltigbis>=$jetzt) || ($gueltigbis=='')) && ($exklusiv==true && $row->exklusiv==false))
			$passiv=true;
		else
			$zukunft=false;
		
		echo '<tr '.($aktiv==true || $passiv==true?'':'style="color:grey"').'>';
		echo '<td width="10px" align="center">'.($aktiv==false?($zukunft==true || $passiv==true?'<img title="2 gelb" src="../../skin/images/ampel_gelb.png" alt="ampel_gelb">':'<img title="3 rot" src="../../skin/images/ampel_rot.png" alt="ampel_rot">'):'<img title="1 gruen" src="../../skin/images/ampel_gruen.png" alt="ampel_gruen">').'</td>';
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		echo '<td>',$db->convert_html_chars($row->infoscreen_content_id),'</td>';
		echo '<td>',$db->convert_html_chars($row->infoscreen_id),'</td>';
		echo '<td>',$db->convert_html_chars($row->content_id),'</td>';
		echo '<td>',$db->convert_html_chars($content->titel),'</td>';
<<<<<<< HEAD
		echo '<td '.($zukunft==true?'style="color:black"':''). '>',$db->convert_html_chars($datum_obj->formatDatum($row->gueltigvon,'d.m.Y H:i:s')),'</td>';		
		echo '<td>',$db->convert_html_chars($datum_obj->formatDatum($row->gueltigbis,'d.m.Y H:i:s')),'</td>';
		echo '<td>',$db->convert_html_chars($row->refreshzeit),'</td>';
=======
		echo '<td name="'.$datum_obj->formatDatum($row->gueltigvon,'Y-m-d H:i').'" '.($zukunft==true?'style="color:black"':''). '>',$db->convert_html_chars($datum_obj->formatDatum($row->gueltigvon,'d.m.Y H:i')),'</td>';		
		echo '<td name="'.$datum_obj->formatDatum($row->gueltigbis,'Y-m-d H:i').'">',$db->convert_html_chars($datum_obj->formatDatum($row->gueltigbis,'d.m.Y H:i')),'</td>';
		echo '<td>',$db->convert_html_chars($row->refreshzeit),'</td>';
		echo '<td>'.($row->exklusiv===true?'<b>Exklusiv</b>':'').'</td>';
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		echo '<td><a href="infoscreen_details.php?action=update&infoscreen_id=',$db->convert_html_chars($infoscreen_id),'&infoscreen_content_id=',$db->convert_html_chars($row->infoscreen_content_id),'">bearbeiten</a>';
		echo '<td><a href="infoscreen_details.php?action=delete&infoscreen_id=',$db->convert_html_chars($infoscreen_id),'&infoscreen_content_id=',$db->convert_html_chars($row->infoscreen_content_id),'">entfernen</a>';
		echo '</tr>';
	}
	echo '</tbody>
	</table>';
	
?>
</body>
</html>