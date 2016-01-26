<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>
FH Burgenland - Anmeldetest
</title>
</head>
<body>

<?php



#Datenbankverbindung


//$link = mysql_connect("db3819.mydbserver.com", "p246607", "ewemiZez+473", "usr_p246607_1");
$link = mysql_connect("db3819.mydbserver.com:3306", "p246607d1", "okopaVoh_538", "usr_p246607_1");


if (!$link) 
{
    die("Verbindung schlug fehl: " . mysql_error());
}
echo "Erfolgreich verbunden";
mysql_close($link);


?>

</body>
</html>