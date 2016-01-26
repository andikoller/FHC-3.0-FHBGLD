<html>
<head>
<title>
Auslastung
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
#s3 { position:absolute; top:180px; left:350px; }
#s4 { position:absolute; top:125px; left:0px; width:100%; height:39px; }
#schatten { position:absolute; top:0px; right:0px; width:30px; height:120%; }
#Text01 { font:bold 1.3em Helvetica; }
#ui-datepicker{font-size:10px;}
</style>

</head>
<body>

<img id="schatten" src="schatten.png">

<img id="s1" src="FH-burgenland-logo.png">

<img id="s4" src="linie.png"> 

<div id="s3"> 



<?php

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
	#Alle Laborräume 
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
	#Alle Laborräume Eisenstadt
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
	#Restliche Räume
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
			echo "Debug";
			break;
		}
		
		echo $query_2 = "SELECT * FROM public.tbl_student WHERE studiengang_kz = '$studisImRaum[0]' AND semester = '$studisImRaum[1]' AND verband = '$studisImRaum[2]' AND gruppe = '$studisImRaum[3]'";
		echo "<br>";
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

		echo $query_2_stunden = "SELECT * FROM public.tbl_student WHERE studiengang_kz = '$studisImRaum[0]' AND semester = '$studisImRaum[1]' AND verband = '$studisImRaum[2]' AND gruppe = '$studisImRaum[3]'";
		echo "<br>";
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

?>

</div>

</body>
</html>