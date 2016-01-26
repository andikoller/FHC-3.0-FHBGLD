<?php
// ********************************************
// * Uebersicht der Tabellen des SIPASS Systems
// ********************************************
	ini_set('display_errors','1');
	error_reporting(E_ALL);

	define('SIPASSDB_SERVER','192.168.101.230:1433');
	define('SIPASSDB_USER','sa');
	define('SIPASSDB_PASSWD','P1ss0ff');
	define('SIPASSDB','asco4');

	if (!$conn_ext=mssql_connect (SIPASSDB_SERVER, SIPASSDB_USER, SIPASSDB_PASSWD))
		die('Fehler beim Verbindungsaufbau!');
	mssql_select_db(SIPASSDB, $conn_ext);

	$tabellen=array('INFORMATION_SCHEMA.TABLES');

	if (isset($_REQUEST['sql']))
		$sql=$_REQUEST['sql'];
	else
		$sql='SELECT TOP 30 * FROM ';
?>
<html>
<head>
	<title>DB-CHECK DB-SiPass</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="../../../skin/vilesci.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="POST">
	<input type="text" name="sql" size="150" value="<?php echo $sql; ?>">
	<input type="submit">
</form>
<?php
	if (isset($_GET['table']) || isset($_POST['sql']))
	{
		if (!isset($_POST['sql']))
		{
			$sql='SELECT count(*) AS anz FROM '.$_GET['table'].';';

			if ($ergebnis = mssql_query($sql,$conn_ext))
			{
				$row=mssql_fetch_object($ergebnis);
				echo '<H1>Tabelle: <strong>'.$_GET['table'].'</strong> ('.$row->anz.' Eintraege)</H1>';
			}
			$sql='SELECT TOP 50 * FROM '.$_GET['table'];
			if (isset($_GET['orderby']))
				$sql.=' ORDER BY '.$_GET['orderby'];
			$sql.=';';
		}
		else
			$sql=$_POST['sql'];
		if ($ergebnis = mssql_query($sql,$conn_ext))
		{
			$j=0;
			echo '<table><tr>';
			for ($i = 0; $i < mssql_num_fields($ergebnis); $i++)
			{
				$infos = mssql_fetch_field($ergebnis, $i);
				echo '<td>'.$infos->name.' ('.$infos->type.')';
				if (isset($_GET['table']))
				{
					echo '&nbsp;&nbsp;<a href="?table='.$_GET['table'].'&orderby='.$infos->name.'">&uarr;</a>';
					echo '&nbsp;<a href="?table='.$_GET['table'].'&orderby='.$infos->name.' DESC">&darr;</a>';
				}
				echo '</td>';
			}
			echo '</tr>';
			while ($row=mssql_fetch_row($ergebnis))
			{
				echo '<tr class="liste'.($j%2).'">';
				for ($i = 0; $i < mssql_num_fields($ergebnis); $i++)
					echo '<td>'.$row[$i].'</td>';
				echo '</tr>';
				$j++;
			}
			echo '</table>';
		}
		else
			echo '<BR>'.$sql.'<BR>';
	}
	else
	{
		foreach ($tabellen AS $tab)
		{
			$sql='SELECT TOP 1 * FROM '.$tab.';';
			if ($ergebnis = mssql_query($sql,$conn_ext))
			{
				echo '<table><tr class="liste"><td colspan="2">Tabelle: <strong><a href="?table='.$tab.'">'.$tab.'</a></strong></td></tr>';
				for ($i = 0; $i < mssql_num_fields($ergebnis); $i++)
				{
					$infos = mssql_fetch_field($ergebnis, $i);
					echo '<tr class="liste'.($i%2).'"><td>'.$infos->name.'</td><td>'.$infos->type.'</td></tr>';
				}
				echo '</table><BR>';
			}
		}
		$sql='SELECT * FROM INFORMATION_SCHEMA.TABLES;';
		if ($ergebnis = mssql_query($sql,$conn_ext))
		{
			$j=0;
			echo '<table><tr class="liste"><td colspan="2"><strong>Alle Tabellen</strong></td></tr>';
			while ($row=mssql_fetch_row($ergebnis))
			{
				echo '<tr class="liste'.($j%2).'">';
				for ($i = 0; $i < mssql_num_fields($ergebnis); $i++)
					echo '<td>'.$row[$i].'</td>';
				echo '<td><a href="?table='.$row[1].'.'.$row[2].'&sql=SELECT TOP 30 * FROM '.$row[1].'.'.$row[2].'">Browse</a></td>';
				echo '</tr>';
				$j++;
			}
			echo '</table>';
		}
	}
?>
</body>
</html>