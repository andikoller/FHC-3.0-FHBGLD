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
//$dbconn = pg_connect("host=p246607.mittwaldserver.info dbname=usr_p246607_1 user=p246607 password=ewemiZez+473") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
//$dbconn = pg_connect("host=46.30.60.120 dbname=usr_p246607_1 user=p246607 password=ewemiZez+473") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

//echo mt_rand(1000000000,9999999999);


$timestamp = "1421708400";

$datum = date('Y-m-d', $timestamp);

echo $datum;


?>

</body>
</html>