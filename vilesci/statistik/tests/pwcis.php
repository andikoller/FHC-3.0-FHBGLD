<html>
<head>
<title>
Passwort auslesen
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
#s1 { position:absolute; top:25px; left:350px; width:155px; height:88px; }
#s2 { position:absolute; top:58px; left:550px; }
#s3 { position:absolute; top:180px; left:350px; }
#s4 { position:absolute; top:120px; left:0px; width:100%; height:40px; }
#Text01 { font:bold 1.3em Helvetica; }
#ui-datepicker{font-size:10px;}
</style>

</head>
<body>

<img id="s1" src="FH-burgenland-logo.png">

<div id="s2"> <p id="Text01"> Passwort auslesen </p> </div>

<img id="s4" src="linie.png">

<div id="s3">

<?php

echo $timestamp = time();
echo "<br>";
echo $uhrzeit = date("H:i", $timestamp);
echo "<br>";

$passwort = "testpw";

$row = 1;
$booltimematch == FALSE;

if (($handle = fopen("pws.csv", "r")) !== FALSE) 
{
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
	{
        $num = count($data);
        #echo "<p> $num Felder in Zeile $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) 
		{
			if ($booltimematch == TRUE)
			{
				echo $data[$c] . "<br />\n";
				$booltimematch = FALSE;
				break;
			}
			
			if ($data[$c] == "12:10")
			{
				$booltimematch = TRUE;
			}
        }
    }
    fclose($handle);
}

echo "<br>";
echo "Das Passwort f&uuml;r ";
echo $uhrzeit;
echo " lautet ";
echo $passwort;

?>

</div>

</body>
</html>