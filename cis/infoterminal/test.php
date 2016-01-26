<?php

require_once('../../config/cis.config.inc.php');
require_once('../../include/wochenplan.class.php');
require_once('../../include/benutzerberechtigung.class.php');
require_once('../../include/betriebsmittel.class.php');
require_once('../../include/betriebsmittelperson.class.php');		
require_once('../../include/betriebsmitteltyp.class.php');	
require_once('../../include/mail.class.php');
require_once('../../include/news.class.php');
require_once('../../include/content.class.php');
require_once('../../include/studiensemester.class.php'); 
require_once('../../include/konto.class.php'); 
require_once('../../include/functions.inc.php'); 
require_once('../../include/authentication.class.php'); 
require_once('../../include/'.EXT_FKT_PATH.'/serviceterminal.inc.php');


if (!$db = new basis_db())
	$db=false;
	

$ort_kurzbz = "E.HG.204";
$datum = "2015-05-28";
$stunde_von = 2;
echo "--->";
echo $stunde_bis = 2;
echo "<---";
echo "<br>";

// Default
$farbe="orange";

if ($info=stundenplan_raum($db,$ort_kurzbz,$datum,$stunde_von,$stunde_bis))
{
	$farbe="rot";
}

$stunde_bis++;
if (!$info=stundenplan_raum($db,$ort_kurzbz,$datum,$stunde_von,$stunde_bis))
{
	$farbe="gruen";
}	


echo $farbe;


function stundenplan_raum($db,$ort_kurzbz="",$datum="",$stunde_von,$stunde_bis=0,$uid="",$kalenderwoche="",$studiengang_kz="",$semester="",$verband="",$gruppe="")
{

	echo "<br>";
	echo "1 --->";
	echo $stunde_bis;
	echo "<---";
	echo "<br>";

	// Plausib
	if (!$db)
		return array();

	if (empty($stunde_bis))
		$stunde_bis=$stunde_von;

	//--- Raumbelegung jetzt
	$qry="";
	$qry.=' SELECT studiengang_kz,0 as "stundenplan_id",tbl_reservierung.reservierung_id,tbl_reservierung.ort_kurzbz,tbl_reservierung.titel,tbl_reservierung.semester,tbl_reservierung.studiengang_kz,tbl_reservierung.verband, tbl_reservierung.gruppe  , to_char(tbl_reservierung.datum, \'YYYYMMDD\') as "datum_jjjjmmtt", to_char(tbl_reservierung.datum, \'IW\') as "datum_woche" , tbl_stunde.beginn, tbl_stunde.ende , to_char(tbl_stunde.beginn, \'HH24:MI\') as "beginn_anzeige" , to_char(tbl_stunde.ende, \'HH24:MI\') as "ende_anzeige" , EXTRACT(EPOCH FROM tbl_reservierung.datum) as "datum_timestamp" ,tbl_stunde.stunde ';
	$qry.=' FROM campus.tbl_reservierung , lehre.tbl_stunde ';
	$qry.=" WHERE tbl_stunde.stunde=tbl_reservierung.stunde  ";
	$qry.=" and tbl_reservierung.stunde between ".$db->db_add_param(trim($stunde_von), FHC_STRING) ." and ".$db->db_add_param(trim($stunde_bis), FHC_STRING) ;
	//$qry.=" and tbl_reservierung.stunde between ".$db->db_add_param(trim($stunde_von), FHC_STRING) ." and ".$db->db_add_param(trim($stunde_bis, FHC_STRING)) ;
	//$qry.=" and tbl_stundenplan.stunde between ".$db->db_add_param(trim($stunde_von), FHC_STRING)." and ".$db->db_add_param(trim($stunde_bis), FHC_STRING);	
	//$qry.=" and tbl_reservierung.stunde between 2 and 2";	
	
	$datum_obj = new datum();
	if (!empty($datum))
	{
		$qry.=" and  tbl_reservierung.datum =".$db->db_add_param(trim($datum), FHC_STRING);	
	}
	if (!empty($kalenderwoche))
	{
		$qry.=" and  to_char(tbl_reservierung.datum, 'IW') =".$db->db_add_param(trim($kalenderwoche), FHC_STRING);	
	}	
	if (!empty($ort_kurzbz))
	{
		$qry.=" and  ort_kurzbz=".$db->db_add_param(trim($ort_kurzbz), FHC_STRING);
	}
	if (!empty($uid) || $uid=='0')
	{
		$qry.=" and uid=".$db->db_add_param(trim($uid), FHC_STRING);
	}
	if (!empty($studiengang_kz) || $studiengang_kz=='0')
	{
		$qry.=" and studiengang_kz=".$db->db_add_param($studiengang_kz, FHC_STRING);	
	}
	if (!empty($semester) || $semester=='0')
	{
		$qry.=" and semester=".$db->db_add_param($semester, FHC_STRING);	
	}
	if (!empty($verband) || $verband=='0')
	{
		$qry.=" and verband=".$db->db_add_param(trim($verband), FHC_STRING);	
	}
	if (!empty($gruppe) || $gruppe=='0')
	{
		$qry.=" and gruppe=".$db->db_add_param($gruppe, FHC_STRING);	
	}
	

	$qry.=" UNION ";
	$qry.=' SELECT studiengang_kz,tbl_stundenplan.stundenplan_id,0 as "reservierung_id", tbl_stundenplan.ort_kurzbz,tbl_stundenplan.titel,tbl_stundenplan.semester,tbl_stundenplan.studiengang_kz,tbl_stundenplan.verband ,tbl_stundenplan.gruppe  , to_char(tbl_stundenplan.datum, \'YYYYMMDD\') as "datum_jjjjmmtt", to_char(tbl_stundenplan.datum, \'IW\') as "datum_woche" , tbl_stunde.beginn, tbl_stunde.ende , to_char(tbl_stunde.beginn, \'HH24:MI\') as "beginn_anzeige" , to_char(tbl_stunde.ende, \'HH24:MI\') as "ende_anzeige" , EXTRACT(EPOCH FROM tbl_stundenplan.datum) as "datum_timestamp"  ,tbl_stunde.stunde  ';
	$qry.=' FROM lehre.tbl_stundenplan , lehre.tbl_stunde  ';
	$qry.=" WHERE tbl_stunde.stunde=tbl_stundenplan.stunde ";
	$qry.=" and tbl_stundenplan.stunde between ".$db->db_add_param(trim($stunde_von), FHC_STRING)." and ".$db->db_add_param(trim($stunde_bis), FHC_STRING);	
	
	
	if (!empty($datum))
	{
		$qry.=" and  tbl_stundenplan.datum =".$db->db_add_param(trim($datum), FHC_STRING);
	}	
	if (!empty($kalenderwoche))
	{
		$qry.=" and  to_char(tbl_stundenplan.datum, 'IW') =".$db->db_add_param(trim($kalenderwoche), FHC_STRING);
	}	
	if (!empty($ort_kurzbz))
	{
		$qry.=" and  ort_kurzbz =E".$db->db_add_param(trim($ort_kurzbz), FHC_STRING);	
	}
	if (!empty($uid) || $uid=='0')
	{
		$qry.=" and mitarbeiter_uid=".$db->db_add_param(trim($uid), FHC_STRING);	
	}
	if (!empty($studiengang_kz) || $studiengang_kz=='0')
	{
		$qry.=" and studiengang_kz=".$db->db_add_param($studiengang_kz, FHC_STRING);	
	}
	if (!empty($semester) || $semester=='0')
	{
		$qry.=" and semester=".$db->db_add_param($semester, FHC_STRING);
	}
	if (!empty($verband) || $verband=='0')
	{
		$qry.=" and verband=E".$db->db_add_param(trim($verband), FHC_STRING);	
	}
	if (!empty($gruppe) || $gruppe=='0')
	{
		$qry.=" and gruppe=".$db->db_add_param($gruppe, FHC_STRING);	
	}
	$qry.=" ; ";
	
	$row_raum_belegt=array();
	
	echo $qry;
	echo "<br>";
	echo "<br>";
	
	if(!$result=$db->db_query($qry))
		die('Probleme beim lesen der Stundenplan '.$db->db_last_error());
	
	if (!$num_rows_stunde=$db->db_num_rows($result))
		return $row_raum_belegt;
	
	while($row = $db->db_fetch_object($result))
	{
		$row_raum_belegt[]=$row;
	}
	
	
	return $row_raum_belegt;
}

$komische_konstante = 3;

$funkt = 1;
$funktnicht = 3;


echo "<br> Ausgabe: ";
echo trim($funktnicht, $komische_konstante);
echo "<br>";







?>