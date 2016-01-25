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
 * Authors: Christian Paminger <christian.paminger@technikum-wien.at>,
 *          Andreas Oesterreicher <andreas.oesterreicher@technikum-wien.at> and
 *          Rudolf Hangl <rudolf.hangl@technikum-wien.at>.
 */
require_once('../../../config/cis.config.inc.php');
require_once('../../../include/functions.inc.php');
require_once('../../../include/datum.class.php');
require_once('../../../include/benutzerberechtigung.class.php');
require_once('../../../include/phrasen.class.php'); 
<<<<<<< HEAD
=======
require_once('../../../include/reservierung.class.php'); 
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

if (!$db = new basis_db())
	die($p->t('global/fehlerBeimOeffnenDerDatenbankverbindung'));
	
$sprache = getSprache(); 
$p=new phrasen($sprache); 
	
$uid = get_uid();
<<<<<<< HEAD
=======
$uid = 'pam';
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

if (isset($_GET['id']))
	$id=$_GET['id'];
else if (isset($_POST['id']))
	$id=$_POST['id'];

$datum_obj = new datum();
$rechte = new benutzerberechtigung();
$rechte->getBerechtigungen($uid);

if(!$rechte->isBerechtigt('lehre/reservierung:begrenzt', null, 'suid'))
	die($p->t('global/keineBerechtigungFuerDieseSeite'));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $p->t('lvplan/reservierungsliste');?></title>
	<link rel="stylesheet" href="../../../skin/style.css.php" type="text/css">
</head>
<body id="inhalt">
<<<<<<< HEAD
	<H2>
		<table class="tabcontent">
			<tr>
				<td>&nbsp;<a class="Item" href="index.php"><?php echo $p->t('lvplan/lehrveranstaltungsplan');?></a> &gt;&gt; <?php echo $p->t('lvplan/reservierungen');?></td>
				<td align="right"><A href="help/index.html" class="hilfe" target="_blank">HELP&nbsp;</A></td>
			</tr>
		</table>
	</H2>
	<?php
=======
	<h2><a class="Item" href="index.php"><?php echo $p->t('lvplan/lehrveranstaltungsplan');?></a> &gt;&gt; <?php echo $p->t('lvplan/reservierungen');?></h2>
	<?php

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	//Loeschen von Reservierungen
	if (isset($id))
	{
		if(!is_numeric($id))
			die('ungueltige ID');
<<<<<<< HEAD
		$sql_query="DELETE FROM campus.tbl_reservierung WHERE reservierung_id='".addslashes($id)."'";
		if($db->db_query($sql_query))
			echo '<b>'.$p->t('lvplan/reservierungWurdeGeloescht').'</b><br>';
=======

		$reservierung = new reservierung();
		if($reservierung->load($id))
		{
			if($reservierung->uid==$uid || $reservierung->insertvon==$uid || $rechte->isBerechtigt('lehre/reservierung', null, 'suid'))
			{
				if($reservierung->delete($id))
					echo '<b>'.$p->t('lvplan/reservierungWurdeGeloescht').'</b><br>';
				else
					echo $reservierung->errormsg;
			}
			else
			{
				echo '<b>'.$p->t('global/keineBerechtigung').'</b><br>';
			}
		}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		else 
			echo '<b>'.$p->t('global/fehleraufgetreten').'!</b><br>';
	}

	//Aktuelle Reservierungen abfragen.
	$datum = time();
	$datum = date("Y-m-d",$datum);
	
	//EIGENE
	$sql_query="SELECT * FROM campus.vw_reservierung 
<<<<<<< HEAD
				WHERE datum>='$datum' AND uid='$uid'
=======
				WHERE datum>=".$db->db_add_param($datum)." 
 				AND (uid=".$db->db_add_param($uid)." OR insertvon=".$db->db_add_param($uid).")
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				ORDER BY  datum, titel, ort_kurzbz, stunde";

	if (!$erg_res=$db->db_query($sql_query))
		die($db->db_last_error());

	$num_rows_res=$db->db_num_rows($erg_res);
	
	if ($num_rows_res>0)
	{
		echo $p->t('lvplan/eigeneReservierungen').':<br>';
		echo '<table border="0">';
		echo '
			<tr class="liste">
				<th>'.$p->t('global/datum').'</th>
				<th>'.$p->t('global/titel').'</th>
				<th>'.$p->t('global/stunde').'</th>
				<th>'.$p->t('lvplan/raum').'</th>
				<th>'.$p->t('global/uid').'</th>
				<th>'.$p->t('global/beschreibung').'</th>
				<th>'.$p->t('global/aktion').'</th>
			</tr>';
		for ($i=0; $i<$num_rows_res; $i++)
		{
			$zeile=$i % 2;
			$id=$db->db_result($erg_res,$i,"reservierung_id");
			$datum1=$db->db_result($erg_res,$i,"datum");
			$titel=$db->db_result($erg_res,$i,"titel");
			$stunde=$db->db_result($erg_res,$i,"stunde");
			$ort_kurzbz=$db->db_result($erg_res,$i,"ort_kurzbz");
			$pers_uid=$db->db_result($erg_res,$i,"uid");
			$beschreibung=$db->db_result($erg_res,$i,"beschreibung");
			$insertamum=$db->db_result($erg_res,$i,"insertamum");
			$insertvon=$db->db_result($erg_res,$i,"insertvon");
			$datum1 = $datum_obj->formatDatum($datum1, 'd.m.Y');
			if($insertamum!='')
				$insertamum = $datum_obj->formatDatum($insertamum, 'd.m.Y H:i:s');
<<<<<<< HEAD
			echo '<tr class="liste'.$zeile.'" title="'.$p->t('global/angelegtAm').' '.$insertamum.$p->t('global/von').' '.$insertvon.'">';
			echo '<td>'.$datum1.'</td>';
			echo '<td>'.$titel.'</td>';
			echo '<td>'.$stunde.'</td>';
			echo '<td>'.$ort_kurzbz.'</td>';
			echo '<td>'.$pers_uid.'</td>';
			echo '<td>'.$beschreibung.'<a  name="liste'.$i.'">&nbsp;</a></td>';
			$z=$i-1;
			if (($pers_uid==$uid)|| $rechte->isBerechtigt('lehre/reservierung', null, 'suid'))
=======
			echo '<tr class="liste'.$zeile.'" title="'.$p->t('global/angelegtAm').' '.$insertamum.' '.$p->t('global/von').' '.$insertvon.'">';
			echo '<td>'.$db->convert_html_chars($datum1).'</td>';
			echo '<td>'.$db->convert_html_chars($titel).'</td>';
			echo '<td>'.$db->convert_html_chars($stunde).'</td>';
			echo '<td>'.$db->convert_html_chars($ort_kurzbz).'</td>';
			echo '<td>'.$db->convert_html_chars($pers_uid).'</td>';
			echo '<td>'.$db->convert_html_chars($beschreibung).'<a  name="liste'.$i.'">&nbsp;</a></td>';
			$z=$i-1;
			if (($pers_uid==$uid)|| ($insertvon==$uid) || $rechte->isBerechtigt('lehre/reservierung', null, 'suid'))
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				echo '<td><A class="Item" href="stpl_reserve_list.php?id='.$id.(isset($_GET['alle'])?'&alle=true':'').'#liste'.$z.'">Delete</A></td>';
			echo '</tr>';
		}
		echo '</table>';
		flush();
	}

	echo '<br><br>';
	flush();
	
	if(isset($_GET['alle']))
	{

		//ALLE
		$sql_query="SELECT * FROM campus.vw_reservierung 
<<<<<<< HEAD
					WHERE datum>='$datum'
=======
					WHERE datum>=".$db->db_add_param($datum)."
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					ORDER BY  datum, titel, ort_kurzbz, stunde";
		if (!$erg_res=$db->db_query($sql_query))
			die($db->db_last_error());
		
		$num_rows_res=$db->db_num_rows($erg_res);
		if ($num_rows_res>0)
		{
			echo $p->t('lvplan/alleReservierungen').':<br>';
			echo '<table border="0">';
			echo '
				<tr class="liste">
					<th>'.$p->t('global/datum').'</th>
					<th>'.$p->t('global/titel').'</th>
					<th>'.$p->t('global/stunde').'</th>
					<th>'.$p->t('lvplan/raum').'</th>
					<th>'.$p->t('global/person').'</th>
					<th>'.$p->t('global/beschreibung').'</th>
					<th>'.$p->t('global/aktion').'</th>
				</tr>';
	
			for ($i=0; $i<$num_rows_res; $i++)
			{
				$zeile=$i % 2;
				$id=$db->db_result($erg_res,$i,"reservierung_id");
				$datum=$db->db_result($erg_res,$i,"datum");
				$titel=$db->db_result($erg_res,$i,"titel");
				$stunde=$db->db_result($erg_res,$i,"stunde");
				$ort_kurzbz=$db->db_result($erg_res,$i,"ort_kurzbz");
				$pers_uid=$db->db_result($erg_res,$i,"uid");
				$beschreibung=$db->db_result($erg_res,$i,"beschreibung");
				$insertamum=$db->db_result($erg_res,$i,"insertamum");
				$insertvon=$db->db_result($erg_res,$i,"insertvon");
				
				$datum = $datum_obj->formatDatum($datum, 'd.m.Y');
				if($insertamum!='')
					$insertamum = $datum_obj->formatDatum($insertamum, 'd.m.Y H:i:s');
<<<<<<< HEAD
				echo '<tr class="liste'.$zeile.'" title="'.$p->t('global/angelegtAm').' '.$insertamum.$p->t('global/von').' '.$insertvon.'">';
				echo '<td>'.$datum.'</td>';
				echo '<td>'.$titel.'</td>';
				echo '<td>'.$stunde.'</td>';
				echo '<td>'.$ort_kurzbz.'</td>';
				echo '<td>'.$pers_uid.'</td>';
				echo '<td>'.$beschreibung.'<a  name="liste'.$i.'">&nbsp;</a></td>';
				$z=$i-1;
				if (($pers_uid==$uid) || $rechte->isBerechtigt('lehre/reservierung', null, 'suid'))
=======
				echo '<tr class="liste'.$zeile.'" title="'.$p->t('global/angelegtAm').' '.$insertamum.' '.$p->t('global/von').' '.$insertvon.'">';
				echo '<td>'.$db->convert_html_chars($datum).'</td>';
				echo '<td>'.$db->convert_html_chars($titel).'</td>';
				echo '<td>'.$db->convert_html_chars($stunde).'</td>';
				echo '<td>'.$db->convert_html_chars($ort_kurzbz).'</td>';
				echo '<td>'.$db->convert_html_chars($pers_uid).'</td>';
				echo '<td>'.$db->convert_html_chars($beschreibung).'<a  name="liste'.$i.'">&nbsp;</a></td>';
				$z=$i-1;
				if (($pers_uid==$uid) || ($insertvon==$uid) || $rechte->isBerechtigt('lehre/reservierung', null, 'suid'))
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					echo '<td><A class="Item" href="stpl_reserve_list.php?id='.$id.(isset($_GET['alle'])?'&alle=true':'').'#liste'.$z.'">Delete</A></td>';
				echo '</tr>';
			}
			echo '</table>';
			flush();
		}
	}
	else 
		echo '<a href="stpl_reserve_list.php?alle=true">'.$p->t('lvplan/alleReservierungenAnzeigen').'</a>';
	
?>
</body>
</html>
