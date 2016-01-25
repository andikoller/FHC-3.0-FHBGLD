<?php
/* Copyright (C) 2012 FH Technikum-Wien
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
 * 			Manfred Kindl			< manfred.kindl@technikum-wien.at >
 */
require_once('../../../config/cis.config.inc.php');
require_once('../../../include/service.class.php');
require_once('../../../include/benutzerberechtigung.class.php');
require_once('../../../include/datum.class.php');
require_once('../../../include/phrasen.class.php');

$user = get_uid();
$sprache = getSprache(); 
$p=new phrasen($sprache);

//$rechte = new benutzerberechtigung();
//$rechte->getBerechtigungen($user);
	
//if(!$rechte->isBerechtigt('basis/service'))
//	die('Sie haben keine Berechtigung fuer diese Seite');

$datum_obj = new datum();

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>'.$p->t("services/service").'</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<link rel="stylesheet" href="../../../skin/tablesort.css" type="text/css"/>
	<link rel="stylesheet" href="../../../skin/style.css.php" type="text/css">
	<script type="text/javascript" src="../../../include/js/jquery.js"></script> 
	<script type="text/javascript">
	
		$(document).ready(function() 
			{ 
			    $("#myTable").tablesorter(
				{
					sortList: [[0,0],[1,0]],
					widgets: [\'zebra\']
				}); 
			} 
		);
		
		function ContentPopUp (Adresse) 
		{
		  Content = window.open(Adresse, "Content", "width=800,height=500,scrollbars=yes");
		  Content.focus();
		}
		</script>
</head>
<body>
<h1>'.$p->t("services/uebersichtUeberServicesOrganisationseinheiten").'</h1>';

$oe_kurzbz = (isset($_GET['oe_kurzbz'])?$_GET['oe_kurzbz']:'');

$service = new service();
echo '<form action="'.$_SERVER['PHP_SELF'].'" method="GET">';
echo $p->t("global/organisationseinheit").': ';
echo '<SELECT name="oe_kurzbz">
<OPTION value="">-- '.$p->t("global/alle").' --</OPTION>';

$oe = new organisationseinheit();
<<<<<<< HEAD
$oe->getAll();
=======
//$oe->getAll();
$oe->loadArray($oe->getChilds('Infrastruktur'),'bezeichnung');
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
foreach($oe->result as $row)
{
	if($row->oe_kurzbz==$oe_kurzbz)
		$selected='selected';
	else
		$selected='';
		
	echo '<OPTION value="'.$row->oe_kurzbz.'" '.$selected.'>'.$row->organisationseinheittyp_kurzbz.' '.$row->bezeichnung.'</OPTION>';
}
echo '</SELECT>
<input type="submit" value="'.$p->t("services/filtern").'" />
</form>';

if($oe_kurzbz!='')
{
	// Wenn der OE keine Services zugeteilt sind, dann die Services der untergeordneten OE laden
<<<<<<< HEAD
	if($service->getServicesOrganisationseinheit($oe_kurzbz))
		if (empty($service->result))
			if(!$service->getSubServicesOrganisationseinheit($oe_kurzbz))
=======
	if($service->getServicesOrganisationseinheit($oe_kurzbz, true))
		if (empty($service->result))
			if(!$service->getSubServicesOrganisationseinheit($oe_kurzbz,'oe_kurzbz,bezeichnung',true))
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				die($service->errormsg);
}
else
{
	if(!$service->getAll())
		die($service->errormsg);
}
echo '<table class="tablesorter" id="myTable">
	<thead>
		<tr>
			<th>'.$p->t("global/organisationseinheit").'</th>
			<th>'.$p->t("global/bezeichnung").'</th>
			<th>'.$p->t("services/leistung").'</th>
			<th>'.$p->t("services/details").'</th>
		</tr>
	</thead>
	<tbody>';

foreach($service->result as $row)
{
<<<<<<< HEAD
	echo '<tr>';
	echo '<td>',$row->oe_kurzbz,'</td>';
	echo '<td>'.($row->content_id!=''?'<a href="../../../cms/content.php?content_id='.$row->content_id.'">'.$row->bezeichnung.'</a>':$row->bezeichnung).'</td>';
	echo '<td>',$row->beschreibung,'</td>';
	echo '<td>'.($row->content_id!=''?'<a href="../../../cms/content.php?content_id='.$row->content_id.'">Details</a>':'').'</td>';
	echo '</tr>';
=======
	if ($row->content_id!='')
	{
		echo '<tr>';
		echo '<td>',$row->oe_kurzbz,'</td>';
		echo '<td>'.($row->content_id!=''?'<a href="../../../cms/content.php?content_id='.$row->content_id.'">'.$row->bezeichnung.'</a>':$row->bezeichnung).'</td>';
		echo '<td>',$row->beschreibung,'</td>';
		echo '<td>'.($row->content_id!=''?'<a href="../../../cms/content.php?content_id='.$row->content_id.'">Details</a>':'').'</td>';
		echo '</tr>';
	}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
}
echo '</tbody>
</table>
</body>
</html>';
?>