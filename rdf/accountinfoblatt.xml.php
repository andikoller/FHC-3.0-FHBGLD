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
 *          Rudolf Hangl <rudolf.hangl@technikum-wien.at> and
 *			Gerald Raab <gerald.raab@technikum-wien.at>.
 */
/**
 * Erstellt das XML fuer das AccountInfoBlatt 
 */
// content type setzen
header("Content-type: application/xhtml+xml");
require_once('../config/vilesci.config.inc.php');
require_once('../include/functions.inc.php');
require_once('../include/basis_db.class.php');

if(isset($_GET['uid']))
	$uid = $_GET['uid'];
else 
	die('UID muss uebergeben werden');

$uid_arr = explode(";",$uid);
	
echo "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
echo '<accountinfoblaetter>';

$db = new basis_db();

foreach ($uid_arr as $uid)
{
	if($uid=='')
		continue;
		
	if(check_lektor($uid))
	{
		//Mitarbeiter
		$qry = "SELECT vorname, nachname, uid, gebdatum, aktivierungscode,alias FROM campus.vw_mitarbeiter WHERE uid='".addslashes($uid)."'";
		if($db->db_query($qry))
		{
			if($row = $db->db_fetch_object())
			{
				$vorname = convertProblemChars($row->vorname);
				$vorname1 = $row->vorname;
				$nachname = convertProblemChars($row->nachname);
				$nachname1 = $row->nachname;
				$uid = $row->uid;
				$gebdatum = $row->gebdatum;
			}
			else 
				die("User $uid nicht gefunden");
		}
		else 
			die("User $uid nicht gefunden");
		
		$fileserver = 'fhe.'.DOMAIN;
		
		/*
		$password=strtoupper(substr($vorname,strlen($vorname)-1,1));
		$password=$password.substr($row->gebdatum,8,1);
		$password=$password.strtolower(substr($nachname,1,1));
		$password=$password.strtolower(substr($vorname,1,1));
		$password=$password.substr($row->gebdatum,9,1);
		$password=$password.strtoupper(substr($nachname,strlen($nachname)-1,1)); 
		*/
			
		//Andreas Koller: Passwort auslesen
		$qry ="SELECT passwd
			   FROM public.tbl_benutzer WHERE uid='".addslashes($uid)."'";
		if($db->db_query($qry))
		{
			if($row = $db->db_fetch_object())
			{
				$password = ($row->passwd);
			}
			else 
				die("User $uid nicht gefunden");
		}
		else
		{
			die("User $uid nicht gefunden");
		}
		
		//$password = "test";
		
		$studiengang='';
	}
	else 
	{	
		//Student
		$qry ="SELECT vorname, nachname, matrikelnr, uid, tbl_studiengang.bezeichnung, aktivierungscode, alias
		       FROM campus.vw_student JOIN public.tbl_studiengang USING(studiengang_kz) WHERE uid='".addslashes($uid)."'";
		if($db->db_query($qry))
		{
			if($row = $db->db_fetch_object())
			{
				$vorname = convertProblemChars($row->vorname);
				$vorname1 = $row->vorname;
				$nachname = convertProblemChars($row->nachname);
				$nachname1 = $row->nachname;
				$matrikelnr = $row->matrikelnr;
				$studiengang = convertProblemChars($row->bezeichnung);
				$uid = $row->uid;
			}
			else 
				die("User $uid nicht gefunden");
		}
		else
			die("User $uid nicht gefunden");		
		
		$fileserver = 'stud'.substr($matrikelnr,0,2).'.'.DOMAIN;
		
		/*
		$password=strtoupper(substr($vorname,strlen($vorname)-1,1));
		$password=$password.substr($matrikelnr,8,1);
		$password=$password.strtolower(substr($nachname,1,1));
		$password=$password.strtolower(substr($vorname,1,1));
		$password=$password.substr($matrikelnr,9,1);
		$password=$password.strtoupper(substr($nachname,strlen($nachname)-1,1));
		*/
	}

	/*
	$password=str_replace("l","L",$password);
	$password=str_replace("O","o",$password);
	$password=str_replace("I","i",$password); 
	*/
	
	//Andreas Koller: Passwort auslesen
	$qry ="SELECT passwd
		   FROM public.tbl_benutzer WHERE uid='".addslashes($uid)."'";
	if($db->db_query($qry))
	{
		if($row = $db->db_fetch_object())
		{
			$password = ($row->passwd);
		}
		else 
			die("User $uid nicht gefunden");
	}
	else
	{
		die("User $uid nicht gefunden");
	}
	

	echo "\n		<infoblatt>";
	echo "\n			<name><![CDATA[".$vorname1.' '.$nachname1."]]></name>";
	echo "\n			<account><![CDATA[".$uid."]]></account>";
	echo "\n			<passwort><![CDATA[".$password."]]></passwort>";
	echo "\n			<aktivierungscode><![CDATA[".$row->aktivierungscode."]]></aktivierungscode>";
	echo "\n			<alias><![CDATA[".$row->alias.'@'.DOMAIN."]]></alias>";
	if($studiengang!='')
		echo "\n			<bezeichnung><![CDATA[".$studiengang."]]></bezeichnung>";
	echo "\n			<email><![CDATA[".$uid.'@'.DOMAIN."]]></email>";
	echo "\n			<fileserver><![CDATA[".$fileserver."]]></fileserver>";
	echo "\n		</infoblatt>";
}
echo '</accountinfoblaetter>';
?>
