<?php
/* 
 * Copyright (C) 2015 fhcomplete.org
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
<<<<<<< HEAD
 * Authors: Robert Hofer <robert.hofer@technikum-wien.at>
=======
 * Authors: Robert Hofer <robert.hofer@technikum-wien.at>,
 *			Andreas Oestereicher <oesi@technikum-wien.at>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
 */

/*
 * Zeigt die bisherige Anwesenheit eines Studenten im aktuellen Semester bei LVAs
 */
<<<<<<< HEAD

=======
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
require_once('../../../config/cis.config.inc.php');
require_once('../../../config/global.config.inc.php');
require_once('../../../include/basis_db.class.php');
require_once('../../../include/functions.inc.php');
require_once('../../../include/anwesenheit.class.php');
require_once('../../../include/phrasen.class.php');
require_once('../../../include/studiensemester.class.php');
require_once('../../../include/student.class.php');
require_once('../../../include/prestudent.class.php');
require_once('../../../include/stundenplan.class.php');
<<<<<<< HEAD

$uid = get_uid();
//$uid = 'if14b001';
//$uid = 'wi13b120';
//$uid = 'ia06b172';
=======
require_once('../../../include/datum.class.php');
require_once('../../../include/benutzerberechtigung.class.php');

$datum_obj = new datum();
$uid = get_uid();
$uidchange=false;
if(isset($_GET['uid']))
{
	$rechte = new benutzerberechtigung();
	$rechte->getBerechtigungen($uid);
	if($rechte->isBerechtigt('admin'))
	{
		$uid = $_GET['uid'];
		$uidchange=true;
	}
}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

$benutzer = new benutzer();
if(!$benutzer->load($uid))
{
	die('Benutzer nicht gefunden');
}

$p = new phrasen(getSprache());
<<<<<<< HEAD

=======
$db = new basis_db();
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
$student = new student;
$stundenplan = new stundenplan('stundenplan');
$anwesenheit = new anwesenheit;

$prestudent = new prestudent;
$alle_semester = $prestudent->getSemesterZuUid($uid);

$semester = filter_input(INPUT_GET, 'semester');

if(!$semester || !array_key_exists($semester, $alle_semester))
{
	end($alle_semester);
	$semester = key($alle_semester);
}

<<<<<<< HEAD
$student->get_lv($uid, $semester);
=======
//$student->get_lv($uid, $semester);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
?>
<!DOCTYPE html>
<html>
	<head>
<<<<<<< HEAD
		<title><?php echo $p->t('lvaliste/anwesenheit') ?></title>
=======
		<title><?php echo $p->t('anwesenheitsliste/anwesenheit') ?></title>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../skin/style.css.php" type="text/css">
		<link rel="stylesheet" href="../../../skin/jquery.css" type="text/css"/>
		<script type="text/javascript" src="../../../include/js/jquery.min.1.11.1.js"></script>
	</head>
	<body class="anwesenheit">
<<<<<<< HEAD

		<?php if($student->result): ?>

			<form id="anwesenheitAuswahl" method="GET">
				<select name="semester" id="semester">
					<?php foreach($alle_semester as $kurzbz => $sem): ?>
						<option value="<?php echo $kurzbz ?>" <?php echo $kurzbz === $semester ? 'selected' : '' ?>><?php echo $sem ?></option>
					<?php endforeach; ?>
				</select>
			</form>

			<?php foreach($student->result as $lv):

				$stunden_gesamt = $stundenplan->getStunden($lv->lehreinheit_id);

				if(!$stunden_gesamt)
				{
					continue;
				}

				$fehlstunden = $anwesenheit->getAnwesenheit($uid, $lv->lehreinheit_id);
				$le_erledigt = $fehlstunden + $anwesenheit->getAnwesenheit($uid, $lv->lehreinheit_id, true);
				$anwesenheit_relativ = ($stunden_gesamt - $fehlstunden) / $stunden_gesamt * 100;
				?>
				<div class="lv">
					<div>
						<?php echo $lv->bezeichnung ?>
						(<?php echo $lv->lehrform_kurzbz ?>)
					</div>
					<div>
						<div class="progress-wrapper">
							<div class="progress <?php echo $anwesenheit->getAmpel($anwesenheit_relativ) ?>" style="width: <?php echo (int) round($anwesenheit_relativ) ?>%;"></div>
						</div>
						<?php echo round($anwesenheit_relativ, 1) ?>%
						LE abgeschlossen: [<?php echo $le_erledigt ?>/<?php echo $stunden_gesamt ?>]

						<?php if($fehlstunden): ?>

							<span class="fehlstunden-details" title="eingetragene Fehlstunden">&gt;&gt;</span>
							<div style="display: none;">
								<?php $abwesend_termine = $anwesenheit->getAbwesendTermine($uid, $lv->lehreinheit_id); ?>
								<table>
									<?php foreach($abwesend_termine as $termin): ?>
										<tr>
											<td><?php echo $termin->datum ?></td>
											<td><?php echo $termin->einheiten ?></td>
										</tr>
									<?php endforeach; ?>
								</table>
							</div>

						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else: ?>
			Es konnten keine Lehrveranstaltungen gefunden werden.
		<?php endif; ?>
=======
<?php
		echo '<h1>'.$p->t('anwesenheitsliste/anwesenheit').' - '.$db->convert_html_chars($benutzer->titelpre.' '.$benutzer->vorname.' '.$benutzer->nachname.' '.$benutzer->titelpost).'</h1>';
		
		echo '<form id="anwesenheitAuswahl" method="GET">';
		if($uidchange)
			echo '<input type="hidden" name="uid" value="'.$db->convert_html_chars($uid).'" />';
		echo '
				<select name="semester" id="semester">';
					foreach($alle_semester as $kurzbz => $sem)
					{
						echo '<option value="'.$kurzbz.'" '.($kurzbz === $semester ? 'selected' : '').'>'.$sem.'</option>';
					}
			echo '
				</select>
			</form>';

		$anwesenheit = new anwesenheit();
		$anwesenheit->loadAnwesenheitStudiensemester($semester, $uid);
		if($anwesenheit->result)
		{

			foreach($anwesenheit->result as $aw)
			{
				if(!$aw->gesamtstunden)
					continue;

				$fehlstunden = $aw->nichtanwesend;
				$le_erledigt = $aw->erfassteanwesenheit;
				$anwesenheit_relativ = $aw->prozent;
				
				echo '
				<div class="lv">
					<div>
						'.$db->convert_html_chars($aw->bezeichnung).'
					</div>
					<div>
						<div class="progress-wrapper">
							<div class="progress '.$anwesenheit->getAmpel($anwesenheit_relativ).'" style="width: '.round($anwesenheit_relativ).'%;">
							
							</div>
						</div>'.round($anwesenheit_relativ, 1).'%
						'.$p->t('anwesenheitsliste/leAbgeschlossen').' ['.$le_erledigt.'/'.$aw->gesamtstunden.']';

						if($fehlstunden)
						{
							echo '
							<span class="fehlstunden-details" title="'.$p->t('anwesenheitsliste/fehlstunden').'">&gt;&gt;</span>
							<div style="display: none;">
							<table><tr><td>'.$p->t('global/datum').'</td><td>'.$p->t('anwesenheitsliste/fehlstunden').'</td></tr>';
							$anwesenheit_termine = new anwesenheit();
							$anwesenheit_termine->getAnwesenheitLehrveranstaltung($uid, $aw->lehrveranstaltung_id, $semester, false);
							foreach($anwesenheit_termine->result as $termin)
							{
								echo '	<tr>
											<td>'.$datum_obj->formatDatum($termin->datum,'d.m.Y').'</td>
											<td>'.(float)$termin->einheiten.'</td>
										</tr>';
							}
							echo '
								</table>
							</div>';
						}

				echo '
					</div>
				</div>';
			}
		}
		else
		{
			echo $p->t('anwesenheitsliste/keineLVsGefunden');
		}

		?>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		<script type="text/javascript">
			$('span.fehlstunden-details').on('click', function() {
				$(this).next().toggle();
			});

			$('#anwesenheitAuswahl > *').on('change', function() {
				$('#anwesenheitAuswahl').trigger('submit');
			});
		</script>
	</body>
</html>
