<html>
<head>
<title>
FH Burgenland - Controlling Board
</title>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script type="text/javascript">
  $(function() {
    $( "#datepicker_1" ).datepicker({ altFormat: "yy-mm-dd", dateFormat: "yy-mm-dd" });
	$( "#datepicker_2" ).datepicker({ altFormat: "yy-mm-dd", dateFormat: "yy-mm-dd" });
	$( document ).tooltip({items: "td"});
	});  
  </script>

<style type="text/css">
#s1 { position:absolute; top:20px; left:367px; width:155px; height:88px; }
#s2 { position:absolute; top:20px; left:550px; }
#s3 { position:absolute; top:180px; left:350px; font-size:100%;}
#s4 { position:absolute; top:125px; left:0px; width:100%; height:39px; }
#schatten { position:absolute; top:0px; right:0px; width:30px; height:120%; }
#navigation { z-index:3; position:absolute; top:138px; left:586px; text-transform: uppercase; color: white; font-family:Helvetica; font-size:85%; letter-spacing: -1px;}
#Text01 { font:bold 1.3em Helvetica; }
#ui-datepicker{font-size:10px;}

#l1 { position:absolute; top:86px; left:580px; z-index:2;}
#l2 { position:absolute; top:86px; left:711px; z-index:2;}
#l3 { position:absolute; top:86px; left:819px; z-index:2;}
#l4 { position:absolute; top:86px; left:1002px; z-index:2;}
#l5 { position:absolute; top:86px; left:1152px; z-index:2;}
#l6 { position:absolute; top:86px; left:1285px; z-index:2;}

#b1 { position:absolute; top:125px; left:582px; z-index:1; }
#b2 { position:absolute; top:125px; left:713px; z-index:1; }
#b3 { position:absolute; top:125px; left:821px; z-index:1; }
#b4 { position:absolute; top:125px; left:1004px; z-index:1; }
#b5 { position:absolute; top:125px; left:1154px; z-index:1; }

#leaufteilung { font:bold Helvetica;}
;

</style>

</head>
<body>

<img id="schatten" src="schatten.png">

<img id="s1" src="FH-burgenland-logo.png">

<img id="s4" src="linie.png"> 

<img id="l1" src="kurzelinie.png"> 

<img id="l2" src="kurzelinie.png"> 

<img id="l3" src="kurzelinie.png"> 

<img id="l4" src="kurzelinie.png"> 

<img id="l5" src="kurzelinie.png"> 

<img id="l6" src="kurzelinie.png"> 



<a href="https://vilesci.fh-burgenland.at/vilesci/statistik/tests/controllingboard/index.php?seite=raumauslastung"><img id="b1" src="b_raumaus_t.png" onmouseover="src='b_raumaus_b.png'" onmouseout="src='b_raumaus_t.png'"></a>

<a href="https://vilesci.fh-burgenland.at/vilesci/statistik/tests/controllingboard/index.php?seite=leaufteilung"><img id="b2" src="b_leauft_t.png" onmouseover="src='b_leauft_b.png'" onmouseout="src='b_leauft_t.png'"></a>

<a href="https://vilesci.fh-burgenland.at/vilesci/statistik/tests/controllingboard/index.php?seite=uebersichtstudiengaenge"><img id="b3" src="b_uebstud_t.png" onmouseover="src='b_uebstud_b.png'" onmouseout="src='b_uebstud_t.png'"></a>

<a href="https://vilesci.fh-burgenland.at/vilesci/statistik/tests/controllingboard/index.php?seite=swsjestudiengang"><img id="b4" src="b_sws_t.png" onmouseover="src='b_sws_b.png'" onmouseout="src='b_sws_t.png'"></a>

<a href="https://vilesci.fh-burgenland.at/vilesci/statistik/tests/controllingboard/index.php?seite=kostenuebersicht"><img id="b5" src="b_kosten_t.png" onmouseover="src='b_kosten_b.png'" onmouseout="src='b_kosten_t.png'"></a>

<div id="s3"> 

<?php

if ($_GET["seite"] == "raumauslastung")
{

	$ausgangsdatum = "2014-09-29";
	$datum = $ausgangsdatum;

	$z1test = "2014-09-29";
	$z2test = "2014-10-10";

	$z1 = $z1test;
	$z2 = $z2test;

	# TODOs zum Formular:
	# - Optisch ansprechend umgestalten
	# - Tooltips
	# - Datepicker anpassen

	echo "<table border='0'>";
	echo "<form name='auslastung' method='POST'>";
	echo "<tr><td><b>Zeitraum:</b></td><td> Von <input name='zeitraum1' type='text' id='datepicker_1'> bis <input name='zeitraum2' type='text' id='datepicker_2'> </td></tr>";

	# Die nachfolgende FOR-Schleife dient nur dazu, dass die lange Wurst im Notepad++ minimiert werden kann...
	for ($i = 1; $i <= 1; $i++)
	{
	echo "<tr><td> <b>Ort:</b> </td>
			<td><select name='ort' size='1'>
				<optgroup label='Standort'>
				<option value='%'>Eisenstadt und Pinkafeld</option>
				<option value='E%'>Eisenstadt</option>
				<option value='P%'>Pinkafeld</option>
				</optgroup>
				<optgroup label='PC R&auml;ume'>
				<option value='allepc'>Alle PC R&auml;ume</option>
				<option value='allepces'>Alle PC R&auml;ume Eisenstadt</option>
				<option value='%EDV%'>Alle PC R&auml;ume Pinkafeld</option>
				<option value='E.HG.004'>E.HG.004</option>
				<option value='E.HG.012'>E.HG.012</option>
				<option value='E.HG.201'>E.HG.201</option>
				<option value='P.HG.EDV1'>P.HG.EDV1</option>
				<option value='P.HG.EDV2'>P.HG.EDV2</option>
				<option value='P.HG.EDV3'>P.HG.EDV3</option>
				</optgroup>
				<optgroup label='H&ouml;rs&auml;le'>
				<option value='%HS%'>Alle H&ouml;rs&auml;le</option>
				<option value='E.HG.HS%'>Alle H&ouml;rs&auml;le Eisenstadt</option>
				<option value='P.HG.HS%'>Alle H&ouml;rs&auml;le Pinkafeld</option>
				<option value='E.HG.HS1'>E.HG.HS1</option>
				<option value='E.HG.HS2'>E.HG.HS2</option>
				<option value='E.HG.HS3'>E.HG.HS3</option>
				<option value='E.HG.HS4'>E.HG.HS4</option>
				<option value='E.HG.HS5'>E.HG.HS5</option>
				<option value='P.HG.HS1'>P.HG.HS1</option>
				<option value='P.HG.HS2'>P.HG.HS2</option>
				<option value='P.HG.HS3'>P.HG.HS3</option>
				</optgroup>
				<optgroup label='Seminarr&auml;ume'>
				<option value='allese'>Alle Seminarr&auml;ume</option>
				<option value='allesees'>Alle Seminarr&auml;ume Eisenstadt</option>
				<option value='P%SEM%'>Alle Seminarr&auml;ume Pinkafeld</option>
				<option value='E.HG.013'>E.HG.013</option>
				<option value='E.HG.015a'>E.HG.015a</option>
				<option value='E.HG.015b'>E.HG.015b</option>
				<option value='E.HG.015c'>E.HG.015c</option>
				<option value='E.HG.021'>E.HG.021</option>
				<option value='E.HG.022'>E.HG.022</option>
				<option value='E.HG.202'>E.HG.202</option>
				<option value='E.HG.203'>E.HG.203</option>
				<option value='E.HG.204'>E.HG.204</option>
				<option value='E.HG.206'>E.HG.206</option>
				<option value='E.HG.207'>E.HG.207</option>
				<option value='E.HG.208'>E.HG.208</option>
				<option value='E.HG.209'>E.HG.209</option>
				<option value='E.HG.210'>E.HG.210</option>
				<option value='E.HG.218'>E.HG.218</option>
				<option value='E.HG.219'>E.HG.219</option>
				<option value='E.HG.220'>E.HG.220</option>
				<option value='E.HG.221'>E.HG.221</option>
				<option value='E.HG.228'>E.HG.228</option>
				<option value='E.HG.229'>E.HG.229</option>
				<option value='E.HG.230'>E.HG.230</option>
				<option value='E.HG.231'>E.HG.231</option>
				<option value='E.HG.235'>E.HG.235</option>
				<option value='E.HG.236'>E.HG.236</option>
				<option value='E.HG.237'>E.HG.237</option>
				<option value='P.HG.SEM1'>P.HG.SEM1</option>
				<option value='P.HG.SEM2'>P.HG.SEM2</option>
				<option value='P.HG.SEM3'>P.HG.SEM3</option>
				<option value='P.ST.SEM10'>P.ST.SEM10</option>
				<option value='P.ST.SEM11'>P.ST.SEM11</option>
				<option value='P.ST.SEM12'>P.ST.SEM12</option>
				<option value='P.ST.SEM13'>P.ST.SEM13</option>
				<option value='P.ST.SEM14'>P.ST.SEM14</option>
				<option value='P.ST.SEM15'>P.ST.SEM15</option>
				<option value='P.ST.SEM16'>P.ST.SEM16</option>
				<option value='P.ST.SEM18'>P.ST.SEM18</option>
				<option value='P.ST.SEM19'>P.ST.SEM19</option>
				<option value='P.ST.SEM5'>P.ST.SEM5</option>
				<option value='P.ST.SEM6'>P.ST.SEM6</option>
				<option value='P.ST.SEM7'>P.ST.SEM7</option>
				<option value='P.ST.SEM8'>P.ST.SEM8</option>
				<option value='P.ST.SEM9'>P.ST.SEM9</option>
				</optgroup>
				<optgroup label='Laborr&auml;ume'>
				<option value='allela'>Alle Laborr&auml;ume</option>
				<option value='allelaes'>Alle Laborr&auml;ume Eisenstadt</option>
				<option value='%L%'>Alle Laborr&auml;ume Pinkafeld</option>
				<option value='E.HG.005'>E.HG.005</option>
				<option value='E.HG.008'>E.HG.008</option>
				<option value='E.HG.017b'>E.HG.017b</option>
				<option value='E.HG.018a'>E.HG.018a</option>
				<option value='E.HG.020'>E.HG.020</option>
				<option value='E.HG.023'>E.HG.023</option>
				<option value='E.HG.215'>E.HG.215</option>
				<option value='E.HG.216'>E.HG.216</option>
				<option value='E.HG.217a'>E.HG.217a</option>
				<option value='P.L1.0.02'>P.L1.0.02</option>
				<option value='P.L1.0.04'>P.L1.0.04</option>
				<option value='P.L1.LAB1'>P.L1.LAB1</option>
				<option value='P.L1.LABBR'>P.L1.LABBR</option>
				<option value='P.L1.LABEL'>P.L1.LABEL</option>
				<option value='P.L1.LABW'>P.L1.LABW</option>
				<option value='P.L2.LAB2'>P.L2.LAB2</option>
				<option value='P.L2.LABAKU'>P.L2.LABAKU</option>
				<option value='P.L2.LABAN'>P.L2.LABAN</option>
				<option value='P.L2.LABAR'>P.L2.LABAR</option>
				<option value='P.L2.LABLAS'>P.L2.LABLAS</option>
				<option value='P.L2.LABVT'>P.L2.LABVT</option>
				</optgroup>
			</select>
		  </td>
		  </tr>";
	}

	echo "<tr><td><input type='submit' value=' Absenden '></td></tr>";
	echo  "</form>";
	echo "</table>";
	echo "<br>";

	#Zeitraumberechnungen
	$z1 = $_POST["zeitraum1"];
	$z2 = $_POST["zeitraum2"];

	$z1 = strtotime($z1);
	$z1datum = date("Y-m-d", $z1);

	$z2 = strtotime($z2);
	$z2datum = date("Y-m-d", $z2);

	$tagdifferenz = ((($z2 - $z1)/86400)+1);

	$ort = $_POST["ort"];

	$tage = array("Sonntag","Montag","Dienstag",
	"Mittwoch","Donnerstag","Freitag","Samstag");

	echo "<table><tr><td>";
	echo "Gew&auml;hlter Zeitraum: ";
	echo "</td><td>";
	echo $z1datum;
	echo " - ";
	echo $z2datum;
	echo "</td></tr><tr><td>";
	echo "Gew&auml;hlter Ort: ";
	echo "</td>";

	$ortanzeige = "Ort";
	$ortanzeige = $ort;


	if ($ort == "%") 
	{
		$ortanzeige = "Eisenstadt und Pinkafeld";
	}
	else if ($ort == "E%")
	{
		$ortanzeige = "Eisenstadt";
	}
	else if ($ort == "P%")
	{
		$ortanzeige = "Pinkafeld";
	}
	else if ($ort == "allepc")
	{
		$ortanzeige = "Alle PC R&auml;ume";
	}
	else if ($ort == "%EDV%")
	{
		$ortanzeige = "Alle PC R&auml;ume in Pinkafeld";
	}
	else if ($ort == "allepces")
	{
		$ortanzeige = "Alle PC R&auml;ume in Eisenstadt";
	}
	else if ($ort == "allepc")
	{
		$ortanzeige = "Alle PC R&auml;ume";
	}
	else if ($ort == "%HS%")
	{
		$ortanzeige = "Alle H&ouml;rs&auml;le";
	}
	else if ($ort == "P.HG.HS%")
	{
		$ortanzeige = "Alle H&ouml;rs&auml;le Pinkafeld";
	}
	else if ($ort == "E.HG.HS%")
	{
		$ortanzeige = "Alle H&ouml;rs&auml;le Eisenstadt";
	}
	else if ($ort == "P%SEM%")
	{
		$ortanzeige = "Alle Seminar&auml;ume Pinkafeld";
	}
	else if ($ort == "allese")
	{
		$ortanzeige = "Alle Seminar&auml;ume";
	}
	else if ($ort == "allesees")
	{
		$ortanzeige = "Alle Seminar&auml;ume Eisenstadt";
	}
	else if ($ort == "%L%")
	{
		$ortanzeige = "Alle Laborr&auml;ume Pinkafeld";
	}
	else if ($ort == "allela")
	{
		$ortanzeige = "Alle Laborr&auml;ume";
	}
	else if ($ort == "allelaes")
	{
		$ortanzeige = "Alle Laborr&auml;ume Eisenstadt";
	}


	echo "<td>";
	echo $ortanzeige;
	echo "</td></tr></table>";

	echo "<br>";

	#Datenbankverbindung
	$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#")
		or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

	echo "<table><tr> <td><b>Datum</b><td><b>Wochentag</b></td></td><td><b>Gesamt</b></td> <td title='08:30 - 09:15'>Stunde 1 </td> <td title='09:30 - 10:15'>Stunde 2</td> <td title='10:15 - 11:00'>Stunde 3</td> <td title='11:15 - 12:00'>Stunde 4</td> <td title='12:00 - 12:45'>Stunde 5</td> <td title='13:00 - 13:45'>Stunde 6</td> <td title='14:00 - 14:45'>Stunde 7</td> <td title='14:45 - 15:30'>Stunde 8</td> <td title='15:45 - 16:30'>Stunde 9</td> <td title='16:30 - 17:15'>Stunde 10</td> <td title='17:45 - 18:30'>Stunde 11</td> <td title='18:30 - 19:15'>Stunde 12</td> <td title='19:30 - 20:15'>Stunde 13</td> <td title='20:45 - 21:00'>Stunde 14</td> <td title='21:00 - 21:45'>Stunde 15</td>";

	#FOR-Schleife für die Anzahl an Tagen
	for ($i = 1; $i <= $tagdifferenz; $i++)
	{
		$whilecounter = 0;
		$studierendencounter = 0;

		#Ausnahme IF-Bedingungen für Räume in Eisenstadt, da sie durch den Namen nicht zuordenbar sind -> so müssen eigene Queries durchgeführt werden...
		
		#Alle PC Räume in Eisenstadt
		if ($ort == "allepces")
		{
			$query_1_gesamt = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe FROM lehre.tbl_stundenplan WHERE ((ort_kurzbz LIKE 'E.HG.004') OR (ort_kurzbz LIKE 'E.HG.012') OR (ort_kurzbz LIKE 'E.HG.201')) AND (datum = '$z1datum')";
			$result_1_gesamt = pg_query($query_1_gesamt) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
			
			$query_1_stunden = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe, stunde FROM lehre.tbl_stundenplan WHERE ((ort_kurzbz LIKE 'E.HG.004') OR (ort_kurzbz LIKE 'E.HG.012') OR (ort_kurzbz LIKE 'E.HG.201')) AND (datum = '$z1datum')";
			$result_1_stunden = pg_query($query_1_stunden) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
		}
		#Alle PC Räume
		else if ($ort == "allepc")
		{
			$query_1_gesamt = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe FROM lehre.tbl_stundenplan WHERE ((ort_kurzbz LIKE 'E.HG.004') OR (ort_kurzbz LIKE 'E.HG.012') OR (ort_kurzbz LIKE 'E.HG.201') OR (ort_kurzbz LIKE '%EDV%')) AND (datum = '$z1datum')";
			$result_1_gesamt = pg_query($query_1_gesamt) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
			
			$query_1_stunden = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe, stunde FROM lehre.tbl_stundenplan WHERE ((ort_kurzbz LIKE 'E.HG.004') OR (ort_kurzbz LIKE 'E.HG.012') OR (ort_kurzbz LIKE 'E.HG.201') OR (ort_kurzbz LIKE '%EDV%')) AND (datum = '$z1datum')";
			$result_1_stunden = pg_query($query_1_stunden) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
		}
		#Alle Seminarräume
		else if ($ort == "allese")
		{
			$query_1_gesamt = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe FROM lehre.tbl_stundenplan WHERE 
			((ort_kurzbz LIKE 'E.HG.013') OR 
			(ort_kurzbz LIKE 'E.HG.015a') OR
			(ort_kurzbz LIKE 'E.HG.015b') OR
			(ort_kurzbz LIKE 'E.HG.015c') OR 
			(ort_kurzbz LIKE 'E.HG.021') OR 
			(ort_kurzbz LIKE 'E.HG.022') OR 
			(ort_kurzbz LIKE 'E.HG.202') OR 
			(ort_kurzbz LIKE 'E.HG.203') OR 
			(ort_kurzbz LIKE 'E.HG.204') OR 
			(ort_kurzbz LIKE 'E.HG.206') OR 
			(ort_kurzbz LIKE 'E.HG.207') OR 
			(ort_kurzbz LIKE 'E.HG.208') OR 
			(ort_kurzbz LIKE 'E.HG.209') OR 
			(ort_kurzbz LIKE 'E.HG.210') OR 
			(ort_kurzbz LIKE 'E.HG.218') OR 
			(ort_kurzbz LIKE 'E.HG.219') OR 
			(ort_kurzbz LIKE 'E.HG.220') OR 
			(ort_kurzbz LIKE 'E.HG.221') OR 
			(ort_kurzbz LIKE 'E.HG.228') OR 
			(ort_kurzbz LIKE 'E.HG.229') OR 
			(ort_kurzbz LIKE 'E.HG.230') OR 
			(ort_kurzbz LIKE 'E.HG.231') OR 
			(ort_kurzbz LIKE 'E.HG.235') OR 
			(ort_kurzbz LIKE 'E.HG.236') OR 
			(ort_kurzbz LIKE 'E.HG.237') OR 
			(ort_kurzbz LIKE 'P%SEM%')) AND (datum = '$z1datum')";
			$result_1_gesamt = pg_query($query_1_gesamt) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
			
			$query_1_stunden = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe, stunde FROM lehre.tbl_stundenplan WHERE 
			((ort_kurzbz LIKE 'E.HG.013') OR 
			(ort_kurzbz LIKE 'E.HG.015a') OR
			(ort_kurzbz LIKE 'E.HG.015b') OR
			(ort_kurzbz LIKE 'E.HG.015c') OR 
			(ort_kurzbz LIKE 'E.HG.021') OR 
			(ort_kurzbz LIKE 'E.HG.022') OR 
			(ort_kurzbz LIKE 'E.HG.202') OR 
			(ort_kurzbz LIKE 'E.HG.203') OR 
			(ort_kurzbz LIKE 'E.HG.204') OR 
			(ort_kurzbz LIKE 'E.HG.206') OR 
			(ort_kurzbz LIKE 'E.HG.207') OR 
			(ort_kurzbz LIKE 'E.HG.208') OR 
			(ort_kurzbz LIKE 'E.HG.209') OR 
			(ort_kurzbz LIKE 'E.HG.210') OR 
			(ort_kurzbz LIKE 'E.HG.218') OR 
			(ort_kurzbz LIKE 'E.HG.219') OR 
			(ort_kurzbz LIKE 'E.HG.220') OR 
			(ort_kurzbz LIKE 'E.HG.221') OR 
			(ort_kurzbz LIKE 'E.HG.228') OR 
			(ort_kurzbz LIKE 'E.HG.229') OR 
			(ort_kurzbz LIKE 'E.HG.230') OR 
			(ort_kurzbz LIKE 'E.HG.231') OR 
			(ort_kurzbz LIKE 'E.HG.235') OR 
			(ort_kurzbz LIKE 'E.HG.236') OR 
			(ort_kurzbz LIKE 'E.HG.237') OR 
			(ort_kurzbz LIKE 'P%SEM%')) AND (datum = '$z1datum')";
			$result_1_stunden = pg_query($query_1_stunden) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
		}
		#Alle Seminarräume Eisenstadt
		else if ($ort == "allesees")
		{
			$query_1_gesamt = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe FROM lehre.tbl_stundenplan WHERE 
			((ort_kurzbz LIKE 'E.HG.013') OR 
			(ort_kurzbz LIKE 'E.HG.015a') OR
			(ort_kurzbz LIKE 'E.HG.015b') OR
			(ort_kurzbz LIKE 'E.HG.015c') OR 
			(ort_kurzbz LIKE 'E.HG.021') OR 
			(ort_kurzbz LIKE 'E.HG.022') OR 
			(ort_kurzbz LIKE 'E.HG.202') OR 
			(ort_kurzbz LIKE 'E.HG.203') OR 
			(ort_kurzbz LIKE 'E.HG.204') OR 
			(ort_kurzbz LIKE 'E.HG.206') OR 
			(ort_kurzbz LIKE 'E.HG.207') OR 
			(ort_kurzbz LIKE 'E.HG.208') OR 
			(ort_kurzbz LIKE 'E.HG.209') OR 
			(ort_kurzbz LIKE 'E.HG.210') OR 
			(ort_kurzbz LIKE 'E.HG.218') OR 
			(ort_kurzbz LIKE 'E.HG.219') OR 
			(ort_kurzbz LIKE 'E.HG.220') OR 
			(ort_kurzbz LIKE 'E.HG.221') OR 
			(ort_kurzbz LIKE 'E.HG.228') OR 
			(ort_kurzbz LIKE 'E.HG.229') OR 
			(ort_kurzbz LIKE 'E.HG.230') OR 
			(ort_kurzbz LIKE 'E.HG.231') OR 
			(ort_kurzbz LIKE 'E.HG.235') OR 
			(ort_kurzbz LIKE 'E.HG.236') OR 
			(ort_kurzbz LIKE 'E.HG.237')) AND (datum = '$z1datum')";
			$result_1_gesamt = pg_query($query_1_gesamt) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
			
			$query_1_stunden = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe, stunde FROM lehre.tbl_stundenplan WHERE 
			((ort_kurzbz LIKE 'E.HG.013') OR 
			(ort_kurzbz LIKE 'E.HG.015a') OR
			(ort_kurzbz LIKE 'E.HG.015b') OR
			(ort_kurzbz LIKE 'E.HG.015c') OR 
			(ort_kurzbz LIKE 'E.HG.021') OR 
			(ort_kurzbz LIKE 'E.HG.022') OR 
			(ort_kurzbz LIKE 'E.HG.202') OR 
			(ort_kurzbz LIKE 'E.HG.203') OR 
			(ort_kurzbz LIKE 'E.HG.204') OR 
			(ort_kurzbz LIKE 'E.HG.206') OR 
			(ort_kurzbz LIKE 'E.HG.207') OR 
			(ort_kurzbz LIKE 'E.HG.208') OR 
			(ort_kurzbz LIKE 'E.HG.209') OR 
			(ort_kurzbz LIKE 'E.HG.210') OR 
			(ort_kurzbz LIKE 'E.HG.218') OR 
			(ort_kurzbz LIKE 'E.HG.219') OR 
			(ort_kurzbz LIKE 'E.HG.220') OR 
			(ort_kurzbz LIKE 'E.HG.221') OR 
			(ort_kurzbz LIKE 'E.HG.228') OR 
			(ort_kurzbz LIKE 'E.HG.229') OR 
			(ort_kurzbz LIKE 'E.HG.230') OR 
			(ort_kurzbz LIKE 'E.HG.231') OR 
			(ort_kurzbz LIKE 'E.HG.235') OR 
			(ort_kurzbz LIKE 'E.HG.236') OR 
			(ort_kurzbz LIKE 'E.HG.237')) AND (datum = '$z1datum')";
			$result_1_stunden = pg_query($query_1_stunden) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
		}
		#TODO Alle Laborräume 
		else if ($ort == "allela")
		{
			$query_1_gesamt = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe FROM lehre.tbl_stundenplan WHERE 
			((ort_kurzbz LIKE 'E.HG.005') OR 
			(ort_kurzbz LIKE 'E.HG.008') OR
			(ort_kurzbz LIKE 'E.HG.017b') OR 
			(ort_kurzbz LIKE 'E.HG.018a') OR 
			(ort_kurzbz LIKE 'E.HG.020') OR 
			(ort_kurzbz LIKE 'E.HG.023') OR 
			(ort_kurzbz LIKE 'E.HG.215') OR 
			(ort_kurzbz LIKE 'E.HG.216') OR 
			(ort_kurzbz LIKE 'E.HG.217a') OR 
			(ort_kurzbz LIKE '%L%')) AND (datum = '$z1datum')";
			$result_1_gesamt = pg_query($query_1_gesamt) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
			
			$query_1_stunden = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe, stunde FROM lehre.tbl_stundenplan WHERE 
			((ort_kurzbz LIKE 'E.HG.005') OR 
			(ort_kurzbz LIKE 'E.HG.008') OR
			(ort_kurzbz LIKE 'E.HG.017b') OR 
			(ort_kurzbz LIKE 'E.HG.018a') OR 
			(ort_kurzbz LIKE 'E.HG.020') OR 
			(ort_kurzbz LIKE 'E.HG.023') OR 
			(ort_kurzbz LIKE 'E.HG.215') OR 
			(ort_kurzbz LIKE 'E.HG.216') OR 
			(ort_kurzbz LIKE 'E.HG.217a') OR 
			(ort_kurzbz LIKE '%L%')) AND (datum = '$z1datum')";
			$result_1_stunden = pg_query($query_1_stunden) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
		}
		#TODO Alle Laborräume Eisenstadt
		else if ($ort == "allelaes")
		{
			$query_1_gesamt = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe FROM lehre.tbl_stundenplan WHERE 
			((ort_kurzbz LIKE 'E.HG.005') OR 
			(ort_kurzbz LIKE 'E.HG.008') OR
			(ort_kurzbz LIKE 'E.HG.017b') OR 
			(ort_kurzbz LIKE 'E.HG.018a') OR 
			(ort_kurzbz LIKE 'E.HG.020') OR 
			(ort_kurzbz LIKE 'E.HG.023') OR 
			(ort_kurzbz LIKE 'E.HG.215') OR 
			(ort_kurzbz LIKE 'E.HG.216') OR 
			(ort_kurzbz LIKE 'E.HG.217a')) AND (datum = '$z1datum')";
			$result_1_gesamt = pg_query($query_1_gesamt) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
			
			$query_1_stunden = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe, stunde FROM lehre.tbl_stundenplan WHERE 
			((ort_kurzbz LIKE 'E.HG.005') OR 
			(ort_kurzbz LIKE 'E.HG.008') OR
			(ort_kurzbz LIKE 'E.HG.017b') OR 
			(ort_kurzbz LIKE 'E.HG.018a') OR 
			(ort_kurzbz LIKE 'E.HG.020') OR 
			(ort_kurzbz LIKE 'E.HG.023') OR 
			(ort_kurzbz LIKE 'E.HG.215') OR 
			(ort_kurzbz LIKE 'E.HG.216') OR 
			(ort_kurzbz LIKE 'E.HG.217a')) AND (datum = '$z1datum')";
			$result_1_stunden = pg_query($query_1_stunden) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
		}
		#Alle restlichen Räume
		else
		{
			$query_1_gesamt = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe FROM lehre.tbl_stundenplan WHERE ort_kurzbz LIKE '$ort' AND datum = '$z1datum'";
			$result_1_gesamt = pg_query($query_1_gesamt) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
			
			$query_1_stunden = "SELECT DISTINCT studiengang_kz, semester, verband, gruppe, stunde FROM lehre.tbl_stundenplan WHERE ort_kurzbz LIKE '$ort' AND datum = '$z1datum'";
			$result_1_stunden = pg_query($query_1_stunden) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
		}
		
		
		#WHILE-Schleife für die Gesamtansicht
		while ($line = pg_fetch_array($result_1_gesamt, null, PGSQL_ASSOC)) 
		{
			$studisImRaum = pg_fetch_array($result_1_gesamt, $whilecounter, PGSQL_NUM);

			if (empty($studisImRaum[0]))
			{
				break;
			}
			
			$query_2 = "SELECT * FROM public.tbl_student WHERE studiengang_kz = '$studisImRaum[0]' AND semester = '$studisImRaum[1]' AND verband = '$studisImRaum[2]' AND gruppe = '$studisImRaum[3]'";
			$result_2 = pg_query($query_2) or die('Abfrage fehlgeschlagen: ' . pg_last_error());

			$count = 0;

			while ($line = pg_fetch_array($result_2, null, PGSQL_ASSOC)) 
			{
				$count++;
			}
			
			$studierendencounter = $studierendencounter + $count;
			
			$whilecounter++;
		}
		
		$wochentag = strtotime($z1datum);
		$tag = date("w", $wochentag);
		
		echo "<tr><td>";
		echo $z1datum;
		echo "</td><td>";
		echo $tage[$tag];
		echo "</td><td>";
		echo $studierendencounter;
		echo "</td>";
		
		$whilecounter_stunden = 0;
		
		$studierendencounter_stunde1 = 0;
		$studierendencounter_stunde2 = 0;
		$studierendencounter_stunde3 = 0;
		$studierendencounter_stunde4 = 0;
		$studierendencounter_stunde5 = 0;
		$studierendencounter_stunde6 = 0;
		$studierendencounter_stunde7 = 0;
		$studierendencounter_stunde8 = 0;
		$studierendencounter_stunde9 = 0;
		$studierendencounter_stunde10 = 0;
		$studierendencounter_stunde11 = 0;
		$studierendencounter_stunde12 = 0;
		$studierendencounter_stunde13 = 0;
		$studierendencounter_stunde14 = 0;
		$studierendencounter_stunde15 = 0;
		
		
		#WHILE-Schleife für die Stundenansicht
		while ($line = pg_fetch_array($result_1_stunden, null, PGSQL_ASSOC)) 
		{
			$studisImRaum = pg_fetch_array($result_1_stunden, $whilecounter, PGSQL_NUM);
			
			if (empty($studisImRaum[0]))
			{
				break;
			}
			#Nur in der ersten Stunde anwesende Studenten

			$query_2_stunden = "SELECT * FROM public.tbl_student WHERE studiengang_kz = '$studisImRaum[0]' AND semester = '$studisImRaum[1]' AND verband = '$studisImRaum[2]' AND gruppe = '$studisImRaum[3]'";
			$result_2_stunden = pg_query($query_2_stunden) or die('Abfrage fehlgeschlagen: ' . pg_last_error());


				$count1 = 0;
				$count2 = 0;
				$count3 = 0;
				$count4 = 0;
				$count5 = 0;
				$count6 = 0;
				$count7 = 0;
				$count8 = 0;
				$count9 = 0;
				$count10 = 0;
				$count11 = 0;
				$count12 = 0;
				$count13 = 0;
				$count14 = 0;
				$count15 = 0;
				
				while ($line = pg_fetch_array($result_2_stunden, null, PGSQL_ASSOC)) 
				{
					if ($studisImRaum[4] == 1)
					{
						$count1++;
					}
					else if ($studisImRaum[4] == 2)
					{
						$count2++;
					}
					else if ($studisImRaum[4] == 3)
					{
						$count3++;
					}
					else if ($studisImRaum[4] == 4)
					{
						$count4++;
					}
					else if ($studisImRaum[4] == 5)
					{
						$count5++;
					}
					else if ($studisImRaum[4] == 6)
					{
						$count6++;
					}
					else if ($studisImRaum[4] == 7)
					{
						$count7++;
					}
					else if ($studisImRaum[4] == 8)
					{
						$count8++;
					}
					else if ($studisImRaum[4] == 9)
					{
						$count9++;
					}
					else if ($studisImRaum[4] == 10)
					{
						$count10++;
					}
					else if ($studisImRaum[4] == 11)
					{
						$count11++;
					}
					else if ($studisImRaum[4] == 12)
					{
						$count12++;
					}
					else if ($studisImRaum[4] == 13)
					{
						$count13++;
					}
					else if ($studisImRaum[4] == 14)
					{
						$count14++;
					}
					else if ($studisImRaum[4] == 15)
					{
						$count15++;
					}
				}
				
				$studierendencounter_stunde1 = $studierendencounter_stunde1 + $count1;
				$studierendencounter_stunde2 = $studierendencounter_stunde2 + $count2;
				$studierendencounter_stunde3 = $studierendencounter_stunde3 + $count3;
				$studierendencounter_stunde4 = $studierendencounter_stunde4 + $count4;
				$studierendencounter_stunde5 = $studierendencounter_stunde5 + $count5;
				$studierendencounter_stunde6 = $studierendencounter_stunde6 + $count6;
				$studierendencounter_stunde7 = $studierendencounter_stunde7 + $count7;
				$studierendencounter_stunde8 = $studierendencounter_stunde8 + $count8;
				$studierendencounter_stunde9 = $studierendencounter_stunde9 + $count9;
				$studierendencounter_stunde10 = $studierendencounter_stunde10 + $count10;
				$studierendencounter_stunde11 = $studierendencounter_stunde11 + $count11;
				$studierendencounter_stunde12 = $studierendencounter_stunde12 + $count12;
				$studierendencounter_stunde13 = $studierendencounter_stunde13 + $count13;
				$studierendencounter_stunde14 = $studierendencounter_stunde14 + $count14;
				$studierendencounter_stunde15 = $studierendencounter_stunde15 + $count15;
				
				$whilecounter++;

		}
		
		echo "<td>";
		echo $studierendencounter_stunde1;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde2;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde3;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde4;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde5;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde6;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde7;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde8;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde9;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde10;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde11;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde12;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde13;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde14;
		echo "</td>";
		echo "<td>";
		echo $studierendencounter_stunde15;
		echo "</td>";
		
		$whilecounter_stunden = 0;
		
		echo "</tr>";

		$z1datum = strtotime("+1 day", strtotime($z1datum)); 
		$z1datum = date("Y-m-d", $z1datum);
		
	}
	echo "</table>";

	#Datenbankverbindung schließen
	pg_close($dbconn);

}
else if ($_GET["seite"] == "leaufteilung")
{

	echo "<p align = 'center'><font face = 'Helvetica'><b>Aufteilung der Lehreinheiten f&uuml;r das WS 2014/2015 auf extern und intern je Studiengang und Organisationsform (VZ/BB)</b></font></p></br>";
	
	#Datenbankverbindung
	$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#")
	or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
	
	
	$query_stundenplan = 
	"SELECT sG.kurzbzlang, mA.fixangestellt, lV.orgform_kurzbz, datum, stunde
	FROM lehre.tbl_stundenplan AS sT
	INNER JOIN public.tbl_mitarbeiter AS mA
	ON sT.mitarbeiter_uid = mA.mitarbeiter_uid
	INNER JOIN public.tbl_studiengang AS sG
	ON sT.studiengang_kz = sG.studiengang_kz
	INNER JOIN lehre.tbl_lehreinheit AS lE
	ON lE.lehreinheit_id = sT.lehreinheit_id
	INNER JOIN lehre.tbl_lehrveranstaltung AS lV
	ON lV.lehrveranstaltung_id = lE.lehrveranstaltung_id
	WHERE datum BETWEEN '2014-09-01' AND '2015-02-19'";

	#AND lV.orgform_kurzbz LIKE 'BB'
	
	
	
	#DEBUG
	#Plausiprüfung BSOZ
	$query_mitdifferenzierung = 
	"SELECT DISTINCT sP.studiengang_kz, sP.stunde, sP.datum, sP.semester, sP.verband, sP.gruppe, mA.fixangestellt
	FROM lehre.tbl_stundenplan AS sP
	INNER JOIN public.tbl_mitarbeiter AS mA
	ON sP.mitarbeiter_uid = mA.mitarbeiter_uid
	WHERE datum BETWEEN '2014-09-01' AND '2015-02-19'
	AND fixangestellt = 'f'
	AND studiengang_kz = '269'
	ORDER BY datum, stunde, studiengang_kz ASC";
	


	$result_mitdifferenzierung = pg_query($query_mitdifferenzierung) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
	

	$der_kaunter_gesamt = 1.0;
	$der_kaunter_fix = 1.0;
	$der_kaunter_ext = 1.0;
	
	$voriges_datum = "";
	$vorige_stunde = "";
	$voriges_semester = "";
	$voriger_verband = "";
	$vorige_gruppe = "";
	
	$zeilencounter = 1;
	while ($line = pg_fetch_array($result_mitdifferenzierung, NULL, PGSQL_ASSOC)) 
	{	
		echo "Zeile: ";
		echo $zeilencounter;
		echo " -- ";
		echo $line['datum'];
		echo " -- ";
		echo $line['stunde'];
		echo " -- ";
		echo $line['studiengang_kz'];
		echo " -- ";
		echo $line['semester'];
		echo " -- ";
		echo $line['verband'];
		echo " -- ";
		echo $line['gruppe'];
		echo " -- ";
		echo $line['fixangestellt'];
		echo "<br>";
		
		$der_kaunter_gesamt = ($der_kaunter_gesamt + 1);
		$zeilencounter++;
		/*
		if ($voriges_datum == $line['datum'] && $vorige_stunde == $line['stunde'] && $voriges_semester == $line['semester'] && $voriger_verband == $line['verband'] && $vorige_gruppe == $line['gruppe'])
		{
			if ($line['fixangestellt'] == 'f')
			{
				$der_kaunter_ext = ($der_kaunter_ext + 0.5);
				$der_kaunter_fix = ($der_kaunter_fix - 0.5);
			}
			else if ($line['fixangestellt'] == 't')
			{
				$der_kaunter_ext = ($der_kaunter_ext - 0.5);
				$der_kaunter_fix = ($der_kaunter_fix + 0.5);
			}
		}
		else
		{
			$der_kaunter_gesamt = ($der_kaunter_gesamt + 1);
			
			if ($line['fixangestellt'] == 'f')
			{
				$der_kaunter_ext = ($der_kaunter_ext + 1);
			}
			else if ($line['fixangestellt'] == 't')
			{
				$der_kaunter_fix = ($der_kaunter_fix + 1);
			}
		}
		
		$voriges_datum = $line['datum'];
		$vorige_stunde = $line['stunde'];
		$voriges_semester = $line['semester'];
		$voriger_verband = $line['verband'];
		$vorige_gruppe = $line['gruppe'];
		*/
	}
	
	echo "<br>";
	echo "Gesamt: ";
	echo $der_kaunter_gesamt;
	echo " Fix: ";
	echo $der_kaunter_fix;
	echo " Extern: ";
	echo $der_kaunter_ext;
	echo "<br>";

	$result_stundenplan = pg_query($query_stundenplan) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
	
	$counter_labor_fix = 0;
	$counter_labor_ext = 0;
	$counter_incoming_fix = 0;
	$counter_incoming_ext = 0;
	$counter_phd_fix = 0;
	$counter_phd_ext = 0;
	$counter_mest_fix = 0;
	$counter_mest_ext = 0;
	$counter_mnes_fix = 0;
	$counter_mnes_ext = 0;
	$counter_beum_fix = 0;
	$counter_beum_ext = 0;
	$counter_meum_fix = 0;
	$counter_meum_ext = 0;
	$counter_bgmf_fix = 0;
	$counter_bgmf_ext = 0;
	$counter_bguk_fix = 0;
	$counter_bguk_ext = 0;
	$counter_mivm_fix = 0;
	$counter_mivm_ext = 0;
	$counter_mmig_fix = 0;
	$counter_mmig_ext = 0;
	$counter_efhb_fix = 0;
	$counter_efhb_ext = 0;
	$counter_vbk_fix = 0;
	$counter_vbk_ext = 0;
	$counter_mgtm_fix = 0;
	$counter_mgtm_ext = 0;
	$counter_bimk_fix = 0;
	$counter_bimk_ext = 0;
	$counter_biti_fix = 0;
	$counter_biti_ext = 0;
	$counter_biwb_fix = 0;
	$counter_biwb_ext = 0;
	$counter_mawm_fix = 0;
	$counter_mawm_ext = 0;
	$counter_miwb_fix = 0;
	$counter_miwb_ext = 0;
	$counter_mhrm_fix = 0;
	$counter_mhrm_ext = 0;
	$counter_mimk_fix = 0;
	$counter_mimk_ext = 0;
	$counter_mbpm_fix = 0;
	$counter_mbpm_ext = 0;
	$counter_mivm_fix = 0;
	$counter_mivm_ext = 0;
	$counter_bsoz_fix = 0;
	$counter_bsoz_ext = 0;
	$counter_bphy_fix = 0;
	$counter_bphy_ext = 0;
	
	while ($line = pg_fetch_array($result_stundenplan, NULL, PGSQL_ASSOC)) 
	{
		if ($line['kurzbzlang'] == "LABOR")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_labor_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_labor_ext++;
			}
		}
		if ($line['kurzbzlang'] == "INCOMING")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_incoming_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_incoming_ext++;
			}
		}
		if ($line['kurzbzlang'] == "PHD")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_phd_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_phd_ext++;
			}
		}
		if ($line['kurzbzlang'] == "MEST")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_mest_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_mest_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "BSOZ")
		{
		$counter_plausicheck++;
			if ($line['fixangestellt'] == "t")
			{
				$counter_bsoz_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_bsoz_ext++;
			}
		}
		if ($line['kurzbzlang'] == "MNES")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_mnes_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_mnes_ext++;
			}
		}
		if ($line['kurzbzlang'] == "BEUM")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_beum_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_beum_ext++;
			}
		}
		if ($line['kurzbzlang'] == "MEUM")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_meum_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_meum_ext++;
			}
		}
		if ($line['kurzbzlang'] == "BGMF")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_bgmf_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_bgmf_ext++;
			}
		}
		if ($line['kurzbzlang'] == "BGUK")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_bguk_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_bguk_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "BPHY")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_bphy_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_bphy_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "MIVM")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_mivm_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_mivm_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "MMIG")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_mmig_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_mmig_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "EFHB")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_efhb_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_efhb_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "VBK")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_vbk_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_vbk_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "MGTM")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_mgtm_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_mgtm_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "BIMK")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_bimk_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_bimk_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "BITI")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_biti_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_biti_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "BIWB")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_biwb_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_biwb_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "MAWM")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_mawm_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_mawm_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "MIWB")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_miwb_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_miwb_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "MHRM")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_mhrm_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_mhrm_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "MIMK")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_mimk_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_mimk_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "MBPM")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_mbpm_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_mbpm_ext++;
			}
		}
		else if ($line['kurzbzlang'] == "MIWM")
		{
			if ($line['fixangestellt'] == "t")
			{
				$counter_miwm_fix++;
			}
			else if ($line['fixangestellt'] == "f")
			{
				$counter_miwm_ext++;
			}
		}
	}
	
	
	#Wirtschaft
	$mest_summe = $counter_mest_fix + $counter_mest_ext;
	$mest_pz_ext = round(($counter_mest_ext/$mest_summe)*100, 2);
	$mest_pz_fix = round(($counter_mest_fix/$mest_summe)*100, 2);	
	
	$miwm_summe = $counter_miwm_fix + $counter_miwm_ext;
	$miwm_pz_ext = round(($counter_miwm_ext/$miwm_summe)*100, 2);
	$miwm_pz_fix = round(($counter_miwm_fix/$miwm_summe)*100, 2);
	
	$mhrm_summe = $counter_mhrm_fix + $counter_mhrm_ext;
	$mhrm_pz_ext = round(($counter_mhrm_ext/$mhrm_summe)*100, 2);
	$mhrm_pz_fix = round(($counter_mhrm_fix/$mhrm_summe)*100, 2);
	
	$miwb_summe = $counter_miwb_fix + $counter_miwb_ext;
	$miwb_pz_ext = round(($counter_miwb_ext/$miwb_summe)*100, 2);
	$miwb_pz_fix = round(($counter_miwb_fix/$miwb_summe)*100, 2);
	
	$biwb_summe = $counter_biwb_fix + $counter_biwb_ext;
	$biwb_pz_ext = round(($counter_biwb_ext/$biwb_summe)*100, 2);
	$biwb_pz_fix = round(($counter_biwb_fix/$biwb_summe)*100, 2);
	
	#Summe Department Wirtschaft
	$sum_dep_wirtschaft = $mest_summe+$miwm_summe+$mhrm_summe+$miwb_summe+$biwb_summe;
	$ext_dep_wirtschaft = $counter_mest_ext+$counter_miwm_ext+$counter_mhrm_ext+$counter_miwb_ext+$counter_biwb_ext;
	$fix_dep_wirtschaft = $counter_mest_fix+$counter_miwm_fix+$counter_mhrm_fix+$counter_miwb_fix+$counter_biwb_fix;
	$wirtschaft_pz_ext = round(($ext_dep_wirtschaft/$sum_dep_wirtschaft)*100, 2);
	$wirtschaft_pz_fix = round(($fix_dep_wirtschaft/$sum_dep_wirtschaft)*100, 2);

	#INFORMATION
	$mawm_summe = $counter_mawm_fix + $counter_mawm_ext;
	$mawm_pz_ext = round(($counter_mawm_ext/$mawm_summe)*100, 2);
	$mawm_pz_fix = round(($counter_mawm_fix/$mawm_summe)*100, 2);
	
	$mimk_summe = $counter_mimk_fix + $counter_mimk_ext;
	$mimk_pz_ext = round(($counter_mimk_ext/$mimk_summe)*100, 2);
	$mimk_pz_fix = round(($counter_mimk_fix/$mimk_summe)*100, 2);
	
	$mbpm_summe = $counter_mbpm_fix + $counter_mbpm_ext;
	$mbpm_pz_ext = round(($counter_mbpm_ext/$mbpm_summe)*100, 2);
	$mbpm_pz_fix = round(($counter_mbpm_fix/$mbpm_summe)*100, 2);
	
	$bimk_summe = $counter_bimk_fix + $counter_bimk_ext;
	$bimk_pz_ext = round(($counter_bimk_ext/$bimk_summe)*100, 2);
	$bimk_pz_fix = round(($counter_bimk_fix/$bimk_summe)*100, 2);
	
	$biti_summe = $counter_biti_fix + $counter_biti_ext;
	$biti_pz_ext = round(($counter_biti_ext/$biti_summe)*100, 2);
	$biti_pz_fix = round(($counter_biti_fix/$biti_summe)*100, 2);
	
	#Summe Department Information
	$sum_dep_information = $mawm_summe+$mimk_summe+$mbpm_summe+$bimk_summe+$biti_summe;
	$ext_dep_information = $counter_mawm_ext+$counter_mimk_ext+$counter_mbpm_ext+$counter_bimk_ext+$counter_biti_ext;
	$fix_dep_information = $counter_mawm_fix+$counter_mimk_fix+$counter_mbpm_fix+$counter_bimk_fix+$counter_biti_fix;
	$information_pz_ext = round(($ext_dep_information/$sum_dep_information)*100, 2);
	$information_pz_fix = round(($fix_dep_information/$sum_dep_information)*100, 2);
	
	#SOZIALES
	$bsoz_summe = $counter_bsoz_fix + $counter_bsoz_ext;
	$bsoz_pz_ext = round(($counter_bsoz_ext/$bsoz_summe)*100, 2);
	$bsoz_pz_fix = round(($counter_bsoz_fix/$bsoz_summe)*100, 2);
	
	#UMWELT
	$mnes_summe = $counter_mnes_fix + $counter_mnes_ext;
	$mnes_pz_ext = round(($counter_mnes_ext/$mnes_summe)*100, 2);
	$mnes_pz_fix = round(($counter_mnes_fix/$mnes_summe)*100, 2);	
	
	$meum_summe = $counter_meum_fix + $counter_meum_ext;
	$meum_pz_ext = round(($counter_meum_ext/$meum_summe)*100, 2);
	$meum_pz_fix = round(($counter_meum_fix/$meum_summe)*100, 2);
	
	$mgtm_summe = $counter_mgtm_fix + $counter_mgtm_ext;
	$mgtm_pz_ext = round(($counter_mgtm_ext/$mgtm_summe)*100, 2);
	$mgtm_pz_fix = round(($counter_mgtm_fix/$mgtm_summe)*100, 2);
	
	$beum_summe = $counter_beum_fix + $counter_beum_ext;
	$beum_pz_ext = round(($counter_beum_ext/$beum_summe)*100, 2);
	$beum_pz_fix = round(($counter_beum_fix/$beum_summe)*100, 2);
	
	#Summe Department Umwelt
	$sum_dep_umwelt = $mnes_summe+$meum_summe+$mgtm_summe+$beum_summe;
	$ext_dep_umwelt = $counter_mnes_ext+$counter_meum_ext+$counter_mgtm_ext+$counter_beum_ext;
	$fix_dep_umwelt = $counter_mnes_fix+$counter_meum_fix+$counter_mgtm_fix+$counter_beum_fix;
	$umwelt_pz_ext = round(($ext_dep_umwelt/$sum_dep_umwelt)*100, 2);
	$umwelt_pz_fix = round(($fix_dep_umwelt/$sum_dep_umwelt)*100, 2);
	
	#GESUNDHEIT
	$mmig_summe = $counter_mmig_fix + $counter_mmig_ext;
	$mmig_pz_ext = round(($counter_mmig_ext/$mmig_summe)*100, 2);
	$mmig_pz_fix = round(($counter_mmig_fix/$mmig_summe)*100, 2);
	
	$mivm_summe = $counter_mivm_fix + $counter_mivm_ext;
	$mivm_pz_ext = round(($counter_mivm_ext/$mivm_summe)*100, 2);
	$mivm_pz_fix = round(($counter_mivm_fix/$mivm_summe)*100, 2);
	
	$bgmf_summe = $counter_bgmf_fix + $counter_bgmf_ext;
	$bgmf_pz_ext = round(($counter_bgmf_ext/$bgmf_summe)*100, 2);
	$bgmf_pz_fix = round(($counter_bgmf_fix/$bgmf_summe)*100, 2);	

	$bguk_summe = $counter_bguk_fix + $counter_bguk_ext;
	$bguk_pz_ext = round(($counter_bguk_ext/$bguk_summe)*100, 2);
	$bguk_pz_fix = round(($counter_bguk_fix/$bguk_summe)*100, 2);
	
	$bphy_summe = $counter_bphy_fix + $counter_bphy_ext;
	$bphy_pz_ext = round(($counter_bphy_ext/$bphy_summe)*100, 2);
	$bphy_pz_fix = round(($counter_bphy_fix/$bphy_summe)*100, 2);
	
	#Summe Department Gesundheit
	$sum_dep_gesundheit = $mmig_summe+$mivm_summe+$bgmf_summe+$bguk_summe+$bphy_summe;
	$ext_dep_gesundheit = $counter_mmig_ext+$counter_mivm_ext+$counter_bgmf_ext+$counter_bguk_ext+$counter_bphy_ext;
	$fix_dep_gesundheit = $counter_mmig_fix+$counter_mivm_fix+$counter_bgmf_fix+$counter_bguk_fix+$counter_bphy_fix;
	$gesundheit_pz_ext = round(($ext_dep_gesundheit/$sum_dep_gesundheit)*100, 2);
	$gesundheit_pz_fix = round(($fix_dep_gesundheit/$sum_dep_gesundheit)*100, 2);
	

	echo "<div id='leaufteilung'>";
	echo "<table width = 900><tr><td><font face='Helvetica'><b>Studiengang/Department</b></font></td><td><font face='Helvetica'><b>LE intern</b></font></td><td><font face='Helvetica'><b>LE extern</b></font></td><td><font face='Helvetica'><b>LE Summe</b></font></td></tr>";
	
	#DEPARTMENT WIRTSCHAFT
	
	echo "<tr><td><font face='Helvetica'>MEST</font></td>";
	echo "<td><font face='Helvetica'>$counter_mest_fix - $mest_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_mest_ext - $mest_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$mest_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>MIWM</font></td>";
	echo "<td><font face='Helvetica'>$counter_miwm_fix - $miwm_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_miwm_ext - $miwm_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$miwm_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>MHRM</td>";
	echo "<td><font face='Helvetica'>$counter_mhrm_fix - $mhrm_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_mhrm_ext - $mhrm_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$mhrm_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>MIWB</font></td>";
	echo "<td><font face='Helvetica'>$counter_miwb_fix - $miwb_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_miwb_ext - $miwb_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$miwb_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>BIWB</font></td>";
	echo "<td><font face='Helvetica'>$counter_biwb_fix - $biwb_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_biwb_ext - $biwb_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$biwb_summe - 100%</font></td></tr>";
	
	echo "<tr><td style='background-color:#00537f;'><font face='Helvetica'><b>Dep. Wirtschaft</b></font></td>";
	echo "<td><font face='Helvetica'><b>$fix_dep_wirtschaft - $wirtschaft_pz_fix%</b></font></td>";
	echo "<td><font face='Helvetica'><b>$ext_dep_wirtschaft - $wirtschaft_pz_ext%</b></font></td>";
	echo "<td><font face='Helvetica'><b>$sum_dep_wirtschaft - 100%</b></font></td><td></td></tr>";
	
	#DEPARTMENT INFORMATION UND KOMMUNIKATION
	
	echo "<tr><td><font face='Helvetica'>MAWM</td>";
	echo "<td><font face='Helvetica'>$counter_mawm_fix - $mawm_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_mawm_ext - $mawm_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$mawm_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>MIMK</td>";
	echo "<td><font face='Helvetica'>$counter_mimk_fix - $mimk_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_mimk_ext - $mimk_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$mimk_summe - 100%</font></td><td></td></tr>";

	echo "<tr><td ><font face='Helvetica'>MBPM</td>";
	echo "<td><font face='Helvetica'>$counter_mbpm_fix - $mbpm_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_mbpm_ext - $mbpm_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$mbpm_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>BIMK</td>";
	echo "<td><font face='Helvetica'>$counter_bimk_fix - $bimk_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_bimk_ext - $bimk_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$bimk_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>BITI</td>";
	echo "<td><font face='Helvetica'>$counter_biti_fix - $biti_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_biti_ext - $biti_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$biti_summe - 100%</font></td></tr>";
	
	echo "<tr><td style='background-color:#00a6d0;'><font face='Helvetica'><b>Dep. I. u. K.</b></font></td>";
	echo "<td><font face='Helvetica'><b>$fix_dep_information - $information_pz_fix%</b></font></td>";
	echo "<td><font face='Helvetica'><b>$ext_dep_information - $information_pz_ext%</b></font></td>";
	echo "<td><font face='Helvetica'><b>$sum_dep_information - 100%</b></font></td><td></td></tr>";
	
	#DEPARTMENT SOZIALES
	
	echo "<tr><td><font face='Helvetica'>BSOZ</font></td>";
	echo "<td><font face='Helvetica'>$counter_bsoz_fix - $bsoz_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_bsoz_ext - $bsoz_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$bsoz_summe - 100%</font></td></tr>";
	
	echo "<tr><td style='background-color:#f7a901;'><font face='Helvetica'><b>Dep. Soziales</b></font></td>";
	echo "<td><font face='Helvetica'><b>$counter_bsoz_fix - $bsoz_pz_fix%</b></font></td>";
	echo "<td><font face='Helvetica'><b>$counter_bsoz_ext - $bsoz_pz_ext%</b></font></td>";
	echo "<td><font face='Helvetica'><b>$bsoz_summe - 100%</b></font></td><td></td></tr>";
	
	#DEPARTMENT ENERGIE

	echo "<tr><td><font face='Helvetica'>MNES</font></td>";
	echo "<td><font face='Helvetica'>$counter_mnes_fix - $mnes_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_mnes_ext - $mnes_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$mnes_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>MEUM</font></td>";
	echo "<td><font face='Helvetica'>$counter_meum_fix - $meum_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_meum_ext - $meum_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$meum_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>MGTM</font></td>";
	echo "<td><font face='Helvetica'>$counter_mgtm_fix - $mgtm_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_mgtm_ext - $mgtm_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$mgtm_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>BEUM</td>";
	echo "<td><font face='Helvetica'>$counter_beum_fix - $beum_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_beum_ext - $beum_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$beum_summe - 100%</font></td></tr>";

	echo "<tr><td style='background-color:#98b412;'><font face='Helvetica'><b>Dep. E. u. U.</b></font></td>";
	echo "<td><font face='Helvetica'><b>$fix_dep_umwelt - $umwelt_pz_fix%</b></font></td>";
	echo "<td><font face='Helvetica'><b>$ext_dep_umwelt - $umwelt_pz_ext%</b></font></td>";
	echo "<td><font face='Helvetica'><b>$sum_dep_umwelt - 100%</b></font></td><td></td></tr>";
	
	#DEPARTMENT GESUNDHEIT
	
	echo "<tr><td><font face='Helvetica'>MMIG</font></td>";
	echo "<td><font face='Helvetica'>$counter_mmig_fix - $mmig_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_mmig_ext - $mmig_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$mmig_summe - 100%</font></td><td></td></tr>";
	
	echo "<tr><td><font face='Helvetica'>MIVM</font></td>";
	echo "<td><font face='Helvetica'>$counter_mivm_fix - $mivm_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_mivm_ext - $mivm_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$mivm_summe - 100%</font></td><td></td></tr>";

	echo "<tr><td><font face='Helvetica'>BGMF</font></td>";
	echo "<td><font face='Helvetica'>$counter_bgmf_fix - $bgmf_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_bgmf_ext - $bgmf_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$bgmf_summe - 100%</font></td><td></td></tr>";

	echo "<tr><td><font face='Helvetica'>BGUK</font></td>";
	echo "<td><font face='Helvetica'>$counter_bguk_fix - $bguk_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_bguk_ext - $bguk_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$bguk_summe - 100%</font></td><td></td></tr>";

	echo "<tr><td><font face='Helvetica'>BPHY</font></td>";
	echo "<td><font face='Helvetica'>$counter_bphy_fix - $bphy_pz_fix%</font></td>";
	echo "<td><font face='Helvetica'>$counter_bphy_ext - $bphy_pz_ext%</font></td>";
	echo "<td><font face='Helvetica'>$bphy_summe - 100%</font></td></tr>";
	
	echo "<tr><td style='background-color:#007852;'><font face='Helvetica'><b>Dep. Gesundheit</b></font></td>";
	echo "<td><font face='Helvetica'><b>$fix_dep_gesundheit - $gesundheit_pz_fix%</b></font></td>";
	echo "<td><font face='Helvetica'><b>$ext_dep_gesundheit - $gesundheit_pz_ext%</b></font></td>";
	echo "<td><font face='Helvetica'><b>$sum_dep_gesundheit - 100%</b></font></td><td></td></tr>";
	
	echo "</table>";
	echo "</div>";
	
	#$query_1_gesamt = "SELECT stundenblockung FROM lehre.tbl_lehreinheit WHERE ((ort_kurzbz LIKE 'E.HG.004') OR (ort_kurzbz LIKE 'E.HG.012') OR (ort_kurzbz LIKE 'E.HG.201')) AND (datum = '$z1datum')";
	#$result_1_gesamt = pg_query($query_1_gesamt) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
	
	
	#Datenbankverbindung schließen
	pg_close($dbconn);
	
}
else if ($_GET["seite"] == "uebersichtstudiengaenge")
{
	echo "TODO: &Uuml;bersicht Studieng&auml;nge";
}
else if ($_GET["seite"] == "swsjestudiengang")
{
	echo "TODO: SWS je Studiengang";
}
else if ($_GET["seite"] == "kostenuebersicht")
{
	echo "TODO: Kosten&uuml;bersicht";
}


#Funktionen
function build_department_sum ($arg_1, $arg_2, $arg_3, $arg_4, $arg_5)
{
    echo "Beispielfunktion.\n";
    return $retval;
}


?>

</div>


</body>
</html>