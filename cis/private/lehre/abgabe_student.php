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
 * Authors: Christian Paminger 		< christian.paminger@technikum-wien.at >
 *          Andreas Oesterreicher 	< andreas.oesterreicher@technikum-wien.at >
 *          Rudolf Hangl 			< rudolf.hangl@technikum-wien.at >
 *          Gerald Simane-Sequens 	< gerald.simane-sequens@technikum-wien.at >
 */

require_once('../../../config/cis.config.inc.php');
require_once('../../../include/functions.inc.php');
require_once('../../../include/datum.class.php');
require_once('../../../include/person.class.php');
require_once('../../../include/benutzer.class.php');
require_once('../../../include/student.class.php');
require_once('../../../include/studiengang.class.php');
require_once('../../../include/benutzerberechtigung.class.php');
require_once('../../../include/phrasen.class.php');

$sprache = getSprache();
$p = new phrasen($sprache);

if (!$db = new basis_db())
	die($p->t('global/fehlerBeimOeffnenDerDatenbankverbindung'));
	
$getuid=get_uid();
$uid=$getuid;

if(isset($_GET['uid']))
{
	//Studentenansicht
	$uid = $_GET['uid'];
	//Rechte Pruefen
	$allowed=false;
	
	$student = new student();
	if(!$student->load($uid))
		die($p->t('global/fehlerBeimErmittelnDerUID'));
	
	$stg_obj = new studiengang();
	if(!$stg_obj->load($student->studiengang_kz))
		die($p->t('global/fehlerBeimLesenAusDatenbank'));
	
	//Berechtigung ueber das Berechtigungssystem
	$rechte = new benutzerberechtigung();
	$rechte->getBerechtigungen($getuid);
	if($rechte->isBerechtigt('lehre/abgabetool',$stg_obj->oe_kurzbz,'s'))
		$allowed=true;
	
	//oder Lektor mit Betreuung dieses Studenten
	$qry = "SELECT 1
			FROM 
				lehre.tbl_projektarbeit 
				JOIN lehre.tbl_projektbetreuer USING(projektarbeit_id) 
				JOIN campus.vw_benutzer on(vw_benutzer.person_id=tbl_projektbetreuer.person_id)
			WHERE
				tbl_projektarbeit.student_uid=".$db->db_add_param($uid)." AND
				vw_benutzer.uid=".$db->db_add_param($getuid).";";
	
	if($result = $db->db_query($qry))
	{
		if($db->db_num_rows($result)>0)
		{
			$allowed=true;
		}
	}
	
	if(!$allowed)
	{
		die($p->t('abgabetool/keineBerechtigungStudentenansicht'));
	}	
}
$htmlstr = '';
$htmlstr1 = '';
$vorname='';
$nachname='';

$sql_query = "SELECT (SELECT nachname FROM public.tbl_person  WHERE person_id=tbl_projektbetreuer.person_id) AS bnachname, 
			(SELECT vorname FROM public.tbl_person WHERE person_id=tbl_projektbetreuer.person_id) AS bvorname, 
			(SELECT titelpre FROM public.tbl_person WHERE person_id=tbl_projektbetreuer.person_id) AS btitelpre, 
			(SELECT titelpost FROM public.tbl_person WHERE person_id=tbl_projektbetreuer.person_id) AS btitelpost, 
			tbl_projektbetreuer.person_id AS betreuer_person_id, 
			tbl_projekttyp.bezeichnung AS prjbez, * 
		FROM lehre.tbl_projektarbeit 
		LEFT JOIN lehre.tbl_projektbetreuer USING(projektarbeit_id) 
		LEFT JOIN public.tbl_benutzer ON(uid=student_uid) 
		LEFT JOIN public.tbl_person ON(tbl_benutzer.person_id=tbl_person.person_id) 
		LEFT JOIN lehre.tbl_lehreinheit USING(lehreinheit_id) 
		LEFT JOIN lehre.tbl_lehrveranstaltung USING(lehrveranstaltung_id) 
		LEFT JOIN public.tbl_studiengang USING(studiengang_kz)
		LEFT JOIN lehre.tbl_projekttyp USING (projekttyp_kurzbz)
		WHERE (projekttyp_kurzbz='Bachelor' OR projekttyp_kurzbz='Diplom') 
		AND (tbl_projektbetreuer.betreuerart_kurzbz='Betreuer' OR tbl_projektbetreuer.betreuerart_kurzbz='Begutachter' OR tbl_projektbetreuer.betreuerart_kurzbz='Erstbetreuer' OR tbl_projektbetreuer.betreuerart_kurzbz='Erstbegutachter') 
		AND tbl_projektarbeit.student_uid=".$db->db_add_param($uid)." 
		AND public.tbl_benutzer.aktiv 
		AND lehre.tbl_projektarbeit.note IS NULL 
		ORDER BY studiensemester_kurzbz desc, tbl_lehrveranstaltung.kurzbz";

//AND tbl_projektarbeit.student_uid='$getuid' 'ie07m102';
if(!$erg=$db->db_query($sql_query))
{
	$errormsg=$p->t('global/fehlerBeimLesenAusDatenbank');
}
else
{
	$htmlstr .= "<form name='formular'><input type='hidden' name='check' value=''></form><table id='t1' class='tablesorter'>\n";
	$htmlstr .= "<thead><tr>\n";
	$htmlstr .= "
				<th>".$p->t('abgabetool/details')."</th>
				<th>".$p->t('lvplan/sem')."</th>
				<th>".$p->t('lvplan/stg')."</th>
				<th>".$p->t('global/mail')."</th>
				<th>".$p->t('abgabetool/betreuer')."</th>
				<th>".$p->t('abgabetool/typ')."</th>
				<th>".$p->t('abgabetool/titel')."</th>
				<th>".$p->t('abgabetool/betreuerart')."</th>";
	$htmlstr .= "</tr></thead><tbody>\n";
	$i = 0;
	while($row=$db->db_fetch_object($erg))
	{
		$htmlstr1='';
		$vorname=$row->vorname;
		$nachname=$row->nachname;
		$uid=$row->uid;
		($row->btitelpre!=''?$htmlstr1 = $row->btitelpre.' ':$htmlstr1 .= '');
		$htmlstr1 .= $row->bvorname.' '.$row->bnachname;
		($row->btitelpost!=''?$htmlstr1 .= ' '.$row->btitelpost:$htmlstr1 .= '');
		$htmlstr .= "   <tr>\n"; //class='liste".($i%2)."'
		$htmlstr .= "       <td><a href='abgabe_student_details.php?uid=".$row->uid."&projektarbeit_id=".$row->projektarbeit_id."&bid=".$row->betreuer_person_id."' target='as_detail' title='Details anzeigen'>".$p->t('abgabetool/upload')."</a></td>\n";
		$htmlstr .= "       <td>".$row->studiensemester_kurzbz."</td>\n";
		$htmlstr .= "       <td>".strtoupper($row->typ.$row->kurzbz)."</td>\n";
		$htmlstr .= "	   <td align= center>";

		$qry_betr="SELECT mitarbeiter_uid FROM public.tbl_person 
			JOIN public.tbl_benutzer USING(person_id) 
			JOIN public.tbl_mitarbeiter ON(uid=mitarbeiter_uid)
			WHERE person_id=".$db->db_add_param($row->betreuer_person_id, FHC_INTEGER).";";
		if($result_betr=$db->db_query($qry_betr))
		{
			if($row_betr=$db->db_fetch_object($result_betr))
			{
				$htmlstr.="<a href='mailto:$row_betr->mitarbeiter_uid@".DOMAIN."?subject=Betreuung%20".$row->prjbez."%20von%20".$row->vorname."%20".$row->nachname."'><img src='../../../skin/images/email.png' alt='email' title='".$p->t('abgabetool/emailAnBetreuer')."'></a>";
			}
			else 
			{
				$htmlstr.="UID unknown!";
			}
		}
		$htmlstr .= "		</td>";
		$htmlstr .= "       <td>".$htmlstr1."	    </td>\n";
		$htmlstr .= "       <td>".$db->convert_html_chars($row->prjbez)."</td>\n";
		$htmlstr .= "       <td>".$db->convert_html_chars($row->titel)."</td>\n";
		$htmlstr .= "       <td>".$db->convert_html_chars($row->betreuerart_kurzbz)."</td>\n";
		$htmlstr .= "   </tr>\n";
		$i++;
	}
	$htmlstr .= "</tbody></table>\n";
}
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Abgabesystem_Studentensicht</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="../../../skin/style.css.php" type="text/css">
	<script type="text/javascript" src="../../../include/js/jquery.js"></script>
	<link rel="stylesheet" href="../../../skin/tablesort.css" type="text/css"/>
	<script language="JavaScript" type="text/javascript">
		$(document).ready(function() 
		{ 
			$("#t1").tablesorter(
			{
				sortList: [[4,0]],
				widgets: ["zebra"]
			}); 
			
		});
	</script>
</head>

<body>';

	echo '<h1><div style="float:left">'.$p->t('abgabetool/ueberschrift');
	if(trim($uid)!='')
		echo " ($uid $vorname $nachname)</div> <div style='text-align:right'><a href='../../../cms/dms.php?id=".$p->t('dms_link/abgabetoolStudentHandbuch')."' target='_blank'><img src='../../../skin/images/information.png' alt='Anleitung' title='Anleitung BaDa-Abgabe' border=0>&nbsp;".$p->t('global/handbuch')."</a></div>";
	echo '</h1>';
    echo $htmlstr;
    echo '</body>
</html>';
?>
