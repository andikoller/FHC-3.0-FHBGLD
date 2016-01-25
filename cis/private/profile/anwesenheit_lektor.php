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
 * Authors: Robert Hofer <robert.hofer@technikum-wien.at>
 */
<<<<<<< HEAD

/*
 * Zeigt die bisherige Anwesenheit eines Studenten im aktuellen Semester bei LVAs
 */

=======
/*
 * Zeigt die bisherige Anwesenheit eines Studenten im aktuellen Semester bei LVAs
 */
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
require_once('../../../config/cis.config.inc.php');
require_once('../../../config/global.config.inc.php');
require_once('../../../include/basis_db.class.php');
require_once('../../../include/functions.inc.php');
require_once('../../../include/phrasen.class.php');
require_once('../../../include/benutzer.class.php');
require_once('../../../include/lehreinheit.class.php');
require_once('../../../include/lehreinheitmitarbeiter.class.php');
require_once('../../../include/stundenplan.class.php');
require_once('../../../include/anwesenheit.class.php');
<<<<<<< HEAD

$uid = get_uid();
//$uid = 'himmel';

$benutzer = new benutzer();
if(!$benutzer->load($uid) || !check_lektor($uid))
{
	die('nicht berechtigt');
}

$p = new phrasen(getSprache());

$lehreinheitObj = new lehreinheit;
$lema = new lehreinheitmitarbeiter;
=======
require_once('../../../include/datum.class.php');
require_once('../../../include/benutzerberechtigung.class.php');

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
$benutzer = new benutzer();
if(!$benutzer->load($uid) || !check_lektor($uid))
{
	die('Sie haben keine Berechtigung fuer diese Seite');
}

$db = new basis_db();
$datum_obj= new datum();
$p = new phrasen(getSprache());

$lehreinheitObj = new lehreinheit();
$lema = new lehreinheitmitarbeiter();
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
$stundenplan = new stundenplan('stundenplan');
$anwesenheit = new anwesenheit;
$alle_semester = $lema->getSemesterZuLektor($uid);

$semester = filter_input(INPUT_GET, 'semester');
$lehreinheit_id = filter_input(INPUT_GET, 'lehreinheit', FILTER_SANITIZE_NUMBER_INT);

if(!$semester || !array_key_exists($semester, $alle_semester))
{
	end($alle_semester);
	$semester = key($alle_semester);
}

$lehreinheiten = $lema->getLehreinheiten($uid, $semester);

if(!array_key_exists($lehreinheit_id, $lehreinheiten))
{
	$lehreinheit_id = null;
}

if($lehreinheit_id)
{
	$studenten = $lehreinheitObj->getStudenten($lehreinheit_id);
}
?>
<!DOCTYPE html>
<html>
    <head>
<<<<<<< HEAD
        <title><?php echo $p->t('lvaliste/anwesenheit/studenten') ?></title>
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
		<?php if(!count($alle_semester)): ?>

			Keine Lehreinheiten gefunden.

		<?php else: ?>

			<form id="anwesenheitAuswahl" method="GET">
				<select name="semester" id="semester">
					<?php foreach($alle_semester as $kurzbz => $sem): ?>
						<option value="<?php echo $kurzbz ?>" <?php echo $kurzbz === $semester ? 'selected' : '' ?>>
							<?php echo $sem ?>
						</option>
					<?php endforeach; ?>
				</select>
				<select name="lehreinheit" id="lehreinheit">
					<option value=""></option>
					<?php foreach($lehreinheiten as $le): ?>
						<option value="<?php echo $le->lehreinheit_id ?>" <?php echo $le->lehreinheit_id === $lehreinheit_id ? 'selected' : '' ?>>
							<?php echo $le->lv_bezeichnung ?>
							(<?php echo ($le->lv_lehrform_kurzbz ? $le->lv_lehrform_kurzbz . ', '  : '') . $le->unr ?>)
						</option>
					<?php endforeach ?>
				</select>
			</form>
			<?php
=======
		<?php

		echo '<h1>'.$p->t('anwesenheitsliste/anwesenheit').' - '.$db->convert_html_chars($benutzer->titelpre.' '.$benutzer->vorname.' '.$benutzer->nachname.' '.$benutzer->titelpost).'</h1>';

		if(!count($alle_semester))
		{
			echo $p->t('anwesenheitsliste/keineEintraegeGefunden');
		}
		else
		{

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
				<select name="lehreinheit" id="lehreinheit">
					<option value=""></option>';

			foreach($lehreinheiten as $le)
			{
				echo '<option value="'.$le->lehreinheit_id.'" '.($le->lehreinheit_id === $lehreinheit_id ? 'selected' : '').'>
							'.$le->stg_kurzbzlang.' '.$le->lv_semester.' '.$le->lv_bezeichnung.' ('.($le->lv_lehrform_kurzbz ? $le->lv_lehrform_kurzbz . ', '  : '') . $le->lehreinheit_id.')
						</option>';
			}
			echo '
				</select>
			</form>';

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			if($lehreinheit_id)
			{
				$stunden_gesamt = $stundenplan->getStunden($lehreinheit_id);
			}

<<<<<<< HEAD
			if(!$lehreinheit_id): ?>
				Bitte LV auswählen.
			<?php elseif(!$stunden_gesamt): ?>
				Keine Stunden eingetragen.
			<?php else:

				foreach($studenten as $student):

					$fehlstunden = $anwesenheit->getAnwesenheit($student->uid, $lehreinheit_id);
					$le_erledigt = $fehlstunden + $anwesenheit->getAnwesenheit($student->uid, $lehreinheit_id, true);
					$anwesenheit_relativ = ($stunden_gesamt - $fehlstunden) / $stunden_gesamt * 100;
					?>

					<div class="lv">
						<div>
							<?php echo $student->nachname ?>
							<?php echo $student->vorname ?>
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

				<?php
				endforeach;
			endif; ?>

			<script type="text/javascript">
				$('#anwesenheitAuswahl > *').on('change', function() {

					if(this.id === 'semester') {
						$('#lehreinheit').val('');
					}

					$('#anwesenheitAuswahl').trigger('submit');
				});
			</script>
		<?php endif; ?>

	</body>
</html>
=======
			if(!$lehreinheit_id)
			{
				echo $p->t('anwesenheitsliste/waehleLV');
			}
			elseif(!$stunden_gesamt)
			{
				echo $p->t('anwesenheitsliste/keineStundenvorhanden');
			}
			else
			{
				foreach($studenten as $student)
				{
					$fehlstunden = $anwesenheit->getAnwesenheit($student->uid, $lehreinheit_id);
					$le_erledigt = $fehlstunden + $anwesenheit->getAnwesenheit($student->uid, $lehreinheit_id, true);
					$anwesenheit_relativ = ($stunden_gesamt - $fehlstunden) / $stunden_gesamt * 100;
				
					echo '
					<div class="lv">
						<div>
							'.$db->convert_html_chars($student->nachname).'
							'.$db->convert_html_chars($student->vorname).'
						</div>
						<div>
							<div class="progress-wrapper">
								<div class="progress '.$anwesenheit->getAmpel($anwesenheit_relativ).'" style="width: '.(int) round($anwesenheit_relativ).'%;"></div>
							</div>
							'.round($anwesenheit_relativ, 1).'%
							'.$p->t('anwesenheitsliste/leAbgeschlossen').': ['.$le_erledigt.'/'.$stunden_gesamt.']';

					if($fehlstunden)
					{
						echo '<span class="fehlstunden-details" title="'.$p->t('anwesenheitsliste/fehlstunden').'">&gt;&gt;</span>
								<div style="display: none;">
									<table>
									<tr><td>'.$p->t('global/datum').'</td><td>'.$p->t('anwesenheitsliste/fehlstunden').'</td></tr>';
						$abwesend_termine = $anwesenheit->getAbwesendTermine($student->uid, $lehreinheit_id);

						foreach($abwesend_termine as $termin)
						{
							echo '	<tr>
										<td>'.$datum_obj->formatDatum($termin->datum,'d.m.Y').'</td>
										<td>'.(float)$termin->einheiten.'</td>
									</tr>';
						}
						echo '	</table>
							</div>';
					}

					echo '
						</div>
					</div>';
				}
			}

			echo '
			<script type="text/javascript">

			$("span.fehlstunden-details").on("click", function() {
				$(this).next().toggle();
			});

				$("#anwesenheitAuswahl > *").on("change", function() {

					if(this.id === "semester") {
						$("#lehreinheit").val("");
					}

					$("#anwesenheitAuswahl").trigger("submit");
				});
			</script>
			';
		}
echo '
	</body>
</html>';
?>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
