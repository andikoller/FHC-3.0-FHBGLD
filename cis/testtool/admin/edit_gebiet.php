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
 * Authors: Christian Paminger <christian.paminger@technikum-wien.at>, 
 *          Andreas Oesterreicher <andreas.oesterreicher@technikum-wien.at>,
 *          Rudolf Hangl <rudolf.hangl@technikum-wien.at> and
 *			Gerald Simane-Sequens <gerald.simane-sequens@technikum-wien.at>
 */
/**
 * Seite zum Editieren von Testtool-Gebieten
 */

require_once('../../../config/cis.config.inc.php');
require_once('../../../include/functions.inc.php');
require_once('../../../include/gebiet.class.php');
require_once('../../../include/benutzerberechtigung.class.php');

if (!$user=get_uid())
	die('Sie sind nicht angemeldet. Es wurde keine Benutzer UID gefunden ! <a href="javascript:history.back()">Zur&uuml;ck</a>');


$rechte = new benutzerberechtigung();
$rechte->getBerechtigungen($user);

echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="../../../skin/style.css.php" rel="stylesheet" type="text/css">
</head>
<body>
';

if(isset($_GET['gebiet_id']))
	$gebiet_id=$_GET['gebiet_id'];
else 
	$gebiet_id='';
	
$stg_kz = (isset($_GET['stg_kz'])?$_GET['stg_kz']:'-1');

	
echo '<h1>&nbsp;Gebiet bearbeiten</h1>';

if(!$rechte->isBerechtigt('basis/testtool'))
	die('Sie haben keine Berechtigung fuer diese Seite');

$gebiet = new gebiet();
$gebiet->getAll();

echo '<a href="index.php?gebiet_id='.$gebiet_id.'&amp;stg_kz='.$stg_kz.'" class="Item">Zurück zur Admin Seite</a><br /><br />';

//Liste der Gebiete anzeigen
echo '<form id="gebiet_form" action="'.$_SERVER['PHP_SELF'].'" method="GET">';
echo 'Gebiet: <SELECT name="gebiet_id" onchange="document.getElementById(\'gebiet_form\').submit();">';

foreach ($gebiet->result as $row)
{
	if($gebiet_id=='')
		$gebiet_id=$row->gebiet_id;
	
	if($gebiet_id==$row->gebiet_id)
		$selected='selected';
	else 
		$selected='';
	
	echo '<OPTION value="'.$row->gebiet_id.'" '.$selected.'>'.$row->bezeichnung.' - '.$row->kurzbz.' - '.$row->zeit.'</OPTION>';	
}
echo '</SELECT>
	<!--<input type="submit" value="Bearbeiten">-->
	</form>';

echo '<br /><br />';

//Speichern der Daten
if(isset($_POST['speichern']))
{
	if(!$rechte->isBerechtigt('basis/testtool', null, 'suid'))
		die('Sie haben keine Berechtigung fuer diese Aktion');
	
	$gebiet = new gebiet();
	if($gebiet->load($gebiet_id))
	{
		$gebiet->kurzbz = $_POST['kurzbz'];
		$gebiet->bezeichnung = $_POST['bezeichnung'];
		$gebiet->beschreibung = $_POST['beschreibung'];
		$gebiet->zeit = $_POST['zeit'];
		$gebiet->multipleresponse = isset($_POST['multipleresponse']);
		$gebiet->kategorien = isset($_POST['kategorien']);
		$gebiet->zufallfrage = isset($_POST['zufallfrage']);
		$gebiet->zufallvorschlag = isset($_POST['zufallvorschlag']);
		$gebiet->levelgleichverteilung = isset($_POST['levelgleichverteilung']);
		$gebiet->maxpunkte = $_POST['maxpunkte'];
		$gebiet->maxfragen = $_POST['maxfragen'];
		$gebiet->level_start = $_POST['level_start'];
		$gebiet->level_sprung_auf = $_POST['level_sprung_auf'];
		$gebiet->level_sprung_ab = $_POST['level_sprung_ab'];
		$gebiet->updateamum = date('Y-m-d H:i:s');
		$gebiet->updatevon = $user;
		$gebiet->antwortenprozeile = $_POST['antwortenprozeile'];
		
		if($gebiet->save(false))
		{
			echo 'Daten erfolgreich gespeichert';
		}
		else 
		{
			echo '<span class="error">Fehler beim Speichern: '.$gebiet->errormsg.'</span>';
		}
	}
	else 
	{
		echo '<span class="error">Fehler beim Laden des Gebiets</span>';
	}
}

if($gebiet_id!='')
{
	$gebiet = new gebiet($gebiet_id);

	echo "<hr />";
	echo '<form accept-charset="UTF-8" action="'.$_SERVER['PHP_SELF'].'?gebiet_id='.$gebiet_id.'&amp;stg_kz='.$stg_kz.'" method="POST">';
	echo '<table>';
	
	echo '<tr>';
	//ID
	echo '<td>ID</td><td>'.$gebiet_id.'</td>';
	echo '</tr><tr>';
	//Kurzbz
	echo '<td>Kurzbz</td><td><input type="text" maxlength="10" size="10" name="kurzbz" value="'.$gebiet->kurzbz.'"></td>';
	echo '</tr><tr>';
	//Bezeichnung
	echo '<td>Bezeichnung</td><td><input type="text" maxlength="50" name="bezeichnung" value="'.$gebiet->bezeichnung.'"></td>';
	echo '</tr><tr>';
	//Beschreibung
	echo '<td>Beschreibung</td><td><textarea name="beschreibung">'.$gebiet->beschreibung.'</textarea></td>';
	echo '</tr><tr>';
	//Zeit
	echo '<td>Zeit</td><td><input type="text" name="zeit" size="8" maxlength="8" value="'.$gebiet->zeit.'"> hh:mm:ss</td>';
	echo '</tr><tr>';
	echo '<td>Multiple Response</td><td><input type="checkbox" name="multipleresponse" '.($gebiet->multipleresponse?'checked="checked"':'').'></td>';
	echo '</tr><tr>';
	echo '<td>Kategorien</td><td><input type="checkbox" name="kategorien" '.($gebiet->kategorien?'checked="checked"':'').'></td>';
	echo '</tr><tr>';
	echo '<td>Zufällige Fragereihenfolge</td><td><input type="checkbox" name="zufallfrage" '.($gebiet->zufallfrage?'checked="checked"':'').'></td>';
	echo '</tr><tr>';
	echo '<td>Zufällige Vorschlagreihenfolge</td><td><input type="checkbox" name="zufallvorschlag" '.($gebiet->zufallvorschlag?'checked="checked"':'').'></td>';
	echo '</tr><tr>';
	echo '<td>Levelgleichverteilung</td><td><input type="checkbox" name="levelgleichverteilung" '.($gebiet->levelgleichverteilung?'checked="checked"':'').'></td>';
	echo '</tr><tr>';
	// empfohlene maximalpunkte berechnen und anzeigen
	$maximalpunkte = $gebiet->berechneMaximalpunkte($gebiet_id);
	if($gebiet->maxpunkte!=$maximalpunkte)
		$hinweis = '<span class="error">empfohlene Maximalpunkteanzahl: '.$maximalpunkte.'</span>';
	else 
		$hinweis ='';
	echo '<td>Maximale Punkteanzahl</td><td><input type="text" size="5" maxlength="5" name="maxpunkte" value="'.$gebiet->maxpunkte.'">'.$hinweis.'</td>';
	echo '</tr><tr>';
	echo '<td>Maximale Fragenanzahl</td><td><input type="text" size="5" maxlength="5" name="maxfragen" value="'.$gebiet->maxfragen.'"></td>';
	echo '</tr><tr>';
	echo '<td>Antworten pro Zeile</td><td><input type="text" size="5" maxlength="5" name="antwortenprozeile" value="'.$gebiet->antwortenprozeile.'"></td>';
	echo '</tr><tr>';
	echo '<td>Start Level</td><td><input type="text" size="5" maxlength="5" name="level_start" value="'.$gebiet->level_start.'"></td>';
	echo '</tr><tr>';
	echo '<td>Richtige Fragen bis Levelaufstieg</td><td><input type="text" size="5" maxlength="5" name="level_sprung_auf" value="'.$gebiet->level_sprung_auf.'"></td>';
	echo '</tr><tr>';
	echo '<td>Falsche Fragen bis Levelabstieg</td><td><input type="text" size="5" maxlength="5" name="level_sprung_ab" value="'.$gebiet->level_sprung_ab.'"></td>';
	echo '</tr><tr>';
	echo '<td></td><td><input type="submit" name="speichern" value="Speichern"></td>';
	echo '</tr></table>';
	
	echo '</form>';
}

echo '</body></html>';
?>