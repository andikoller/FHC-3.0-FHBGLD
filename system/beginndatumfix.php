<?php
require_once('../config/vilesci.config.inc.php');
require_once('../include/functions.inc.php');
require_once('../include/basis_db.class.php');
require_once('../include/studiensemester.class.php');

$db = new basis_db();

$qry = "SELECT 
			beginndatum, perskz, tbl_student.student_uid, tbl_student.prestudent_id
		FROM 
			sync.tbl_di_studierende 
			JOIN public.tbl_student ON(perskz=matrikelnr)
		WHERE 
			tbl_di_studierende.beginndatum!=''";

if($result = $db->db_query($qry))
{
	$anzahl=$db->db_num_rows($result);
	echo "Gesamtanzahl:".$anzahl;
	while($row = $db->db_fetch_object($result))
	{
		$stsem = new studiensemester();
		if($studiensemester = $stsem->getSemesterFromDatum($row->beginndatum))
		{
			$qry = "SELECT ausbildungssemester, datum FROM public.tbl_prestudentstatus 
					WHERE prestudent_id=".$db->db_add_param($row->prestudent_id)." 
					AND studiensemester_kurzbz=".$db->db_add_param($studiensemester)."
					AND status_kurzbz='Student'";

			if($result_status = $db->db_query($qry))
			{
				if($row_status = $db->db_fetch_object($result_status))
				{
					// Eintrag bereits vorhanden->Update
					$ausbsem=$row_status->ausbildungssemester;

					if($row_status->datum!=$row->beginndatum)
					{
						// Kein Eintrag vorhanden -> Insert
						$qry = "UPDATE public.tbl_prestudentstatus SET datum=".$db->db_add_param($row->beginndatum)."
							WHERE prestudent_id=".$db->db_add_param($row->prestudent_id).
							" AND studiensemester_kurzbz=".$db->db_add_param($studiensemester).
							" AND ausbildungssemester=".$db->db_add_param($ausbsem).
							" AND status_kurzbz='Student';";

						if($db->db_query($qry))
							echo 'u';
						else
							echo 'Fehler:'.$qry;
					}
					else
						echo 'k';
				
				}
				else
				{
					// Kein Eintrag vorhanden -> Insert
					$qry = "INSERT INTO public.tbl_prestudentstatus (prestudent_id, status_kurzbz, 
					studiensemester_kurzbz, ausbildungssemester, datum) VALUES(".
						$db->db_add_param($row->prestudent_id).",".
						"'Student',".$db->db_add_param($studiensemester).",'1',".$db->db_add_param($row->beginndatum).");";

					if($db->db_query($qry))
						echo "i";
					else
						echo "Fehler:".$qry;					
				}
			}
			else
			{
				echo "Fehler bei Select:".$qry;
			}
		}
		else
		{
			echo "Fehler beim Ermitteln des Stsem zu Datum $row->beginndatum";
		}
	}
}
?>
