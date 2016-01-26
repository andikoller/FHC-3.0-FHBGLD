
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf8mb4">
<title>
FH Burgenland - Anmeldetest
</title>
</head>
<body>

<?php header("Content-type: text/html; charset=utf-8"); 

echo "FUNKT";

$date = date('Y-m-d h:i:s');
createLog("-------------------------------------------------------------------------- " ."\r\n");
createLog("ERRORLOG EINTRAEGE VOM: " . $date. "\r\n");

	#TODO:
	/*
		# - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE
		# 1. Anlegen der Testtabellen:
			# a) public.tbl_test_adresse
			# b) public.tbl_test_kontakt
			# c) public.tbl_test_preinteressent
			# d) public.tbl_test_preinteressentstudiengang
			
		# - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE
		# 2. Befüllen der Tabellen aus der Tabelle public.tbl_test_anmeldung
		
		# - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE
		# 3. Code für das Kopieren von allen Dateien eines Ordners in einen anderen Ordner
			# TODO: Hochladen des Lebenslaufs und des Zeugnisses nach /var/fhcomplete/documents/dms - Verwendung des Codes "akteupload.php"
			# inkl. Beschreiben aller zugehörigen Tabellen (ebenfalls zuerst mit Testtabellen durchspielen)
			# - public.tbl_akte
			# - public.tbl_dokumentprestudent
			# - campus.tbl_dms
			# - campus.tbl_dms_version
			
		# - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE - DONE
		# 4. Nachdem alle Queries erfolgreich ausgeführt wurden, soll das Feld transfer_datum in public.tbl_anmeldetest 
			# mit einem aktuellen timestamp beschrieben werden (Bestätigung über Abholung des Datensatzes)
		
		# 4. Ausführung per Cronjob
		
		# 5. Funktion des Buttons "PreInteressenten übernehmen" umschreiben, so dass auch die ZGV-Daten übernommen werden
		#    Pfad: vilesci/personen/preinteressent_uebernahme.php
		
		# 6. Code auf das Produktivsystem umschreiben -> statt Testtabellen, Produktivtabellen verwenden
				
		# INFO
			# - Keine einfachen Hochkommas zulassen bzw. verwenden in der DB!
	*/
		
	//BEGIN CONTEMAS DB ABFRAGE
	
	#Datenbankverbindung - EXTERN
	
	$link = mysql_connect("db3819.mydbserver.com", "p246607d1", "okopaVoh_538", "usr_p246607_1");
	
	//Setzt den Zeichensatz in mySQL auf UTF8
	mysql_set_charset('utf8');
	
	if (!$link) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Verbindungsaufbau zur Contemas-DB schlug fehl: " . mysql_error());
	}
	
	$db_selected = mysql_select_db('usr_p246607_1', $link);
	if (!$db_selected) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Kann usr_p246607_1 nicht benutzen : " . mysql_error());
	}
		
	$query_answers_contemas = 
		"SELECT pid, mail, field, value, transferdatum FROM tx_powermail_domain_model_answers WHERE transferdatum is NULL";
	
	$result_answers_contemas = mysql_query($query_answers_contemas);
		
	//Eintrag in Logfile bei Fehler
	if (!$result_answers_contemas) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage aus Contemas-DB fehlgeschlagen : " . mysql_error());
	}
		
		
		
	//Schreibe alle Mail-Nummern in das Mail-Array
	$mail_array = array();
	$mail_unique = array();
	$mail_sortierter_index = array();
	
	while ($line = mysql_fetch_array($result_answers_contemas, MYSQL_ASSOC))
	{
		$mail_array[] = $line['mail'];
	}
	
	$mail_unique = array_unique($mail_array);
	
	$anzahl_anmeldungen = count($mail_unique);
	
	$mail_sortierter_index[] = current($mail_unique);
	for ($i = 1; $i <= $anzahl_anmeldungen; $i++)
	{
		$mail_sortierter_index[] = next($mail_unique);
	}

	
	$result_answers_contemas = mysql_query($query_answers_contemas);
	
	//Eintrag in Logfile bei Fehler
	if (!$result_answers_contemas) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage aus Contemas-DB fehlgeschlagen : " . mysql_error());
	}
		
	$aktuelle_anmeldung = current($mail_sortierter_index);
	
	$letze_anmeldung = count($mail_sortierter_index)-1;
	


	$anmeldungen = array();
	
	//Alle Felder ins anmeldungen-Array schreiben
	while ($line = mysql_fetch_array($result_answers_contemas, MYSQL_ASSOC))
	{		
		//WENN Vorbereitungslehrgang:
		if ($line['pid'] == "644")
		{
			if ($line['mail'] != $aktuelle_anmeldung)
			{
				$aktuelle_anmeldung = next($mail_sortierter_index);
			}
			
			if ($line['mail'] == $aktuelle_anmeldung)
			{	
				echo "Vorbereitungslehrgang - ";
				echo $line['pid'];
				echo "  -  ";
				echo $line['mail'];
				echo "  -  ";
				echo $line['field'];
				echo "  -  ";
				echo $line['value'];
				echo "<br>";
				$anmeldung_id = $aktuelle_anmeldung;
				
				$anmeldungen[$anmeldung_id][anmeldung_id] = $anmeldung_id;
				
				//ZGV Vorbereitungslehrgang
				if ($line['field'] == "218")
				{
					$zeichenkette = $line['value'];
					
					//Lehrabschluss
					$suchmuster_1 = "/Berufsausbildung/i";

					//Mittlerer Schulabschluss matcht auf Sonstiges "99"
					$suchmuster_2 = "/Abgeschlossene Berufsbildende Mittlere Schule/i";
					
					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
						$anmeldungen[$anmeldung_id][zgv_b] = "7"; 
					}
					else if (preg_match($suchmuster_2, $zeichenkette))
					{
						$anmeldungen[$anmeldung_id][zgv_b] = "99"; 
					}
				}
				
				//ZGV Ort Vorbereitungslehrgang
				/*
				if ($line['field'] == "78")
				{
					$anmeldungen[$anmeldung_id][zgv_b_ort] = $line['value'];
				}
				*/
				
				
				//Reife Englisch wird per default im Vorbereitungslehrgang auf FALSE gesetzt.
				$anmeldungen[$anmeldung_id][reife_englisch] = "f";
				
				
				if ($line['field'] == "219")
				{
					$anmeldungen[$anmeldung_id][studiengang_1] = "10000";
					$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
				}
				
				if ($line['field'] == "217")
				{
					$anmeldungen[$anmeldung_id][anrede] = $line['value'];
				}
				
				if ($line['field'] == "212")
				{
					$anmeldungen[$anmeldung_id][titel_pre] = $line['value'];
				}
				
				if ($line['field'] == "204")
				{
					$anmeldungen[$anmeldung_id][titel_post] = $line['value'];
				}
				
				if ($line['field'] == "202")
				{
					$anmeldungen[$anmeldung_id][zuname] = $line['value'];
				}
				
				if ($line['field'] == "201")
				{
					$anmeldungen[$anmeldung_id][vorname] = $line['value'];
				}
				
				if ($line['field'] == "199")
				{
					$anmeldungen[$anmeldung_id][vornamen] = $line['value'];
				}
				
				//Geburtsdatum
				if ($line['field'] == "198")
				{
					$timestamp = $line['value'];

					$geburtsdatum = date('Y-m-d', $timestamp);
				
					$anmeldungen[$anmeldung_id][geburtsdatum] = $geburtsdatum;
				}	
				
				if ($line['field'] == "197")
				{
					$anmeldungen[$anmeldung_id][geburtsort] = $line['value'];
				}	
										
				//Geburtsnation
				if ($line['field'] == "196")
				{
					$geburtsnation = $line['value'];
					
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#");
					
					//Eintrag in Logfile bei Fehler
					if (!$dbconn) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Verbindungsaufbau fehlgeschlagen : " . pg_last_error());
					}
					
					$query_select_nationen =
						"SELECT nation_code
						FROM bis.tbl_nation
						WHERE engltext = '$geburtsnation'";

					$result_select_nationen = pg_query($query_select_nationen);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_nationen) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Nation konnte nicht ausgelesen werden : " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_nationen, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][geburtsnation] = $line['nation_code']; 
					}
				}	
					
				if ($line['field'] == "194")
				{
					$anmeldungen[$anmeldung_id][svnr_anmeldung] = $line['value'];
				}
				
				//Staatsbürgerschaft
				if ($line['field'] == "193")
				{
					$staatsbuergerschaft = $line['value'];
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
					
					$query_select_nationen =
						"SELECT nation_code
						FROM bis.tbl_nation
						WHERE engltext = '$staatsbuergerschaft'";

					$result_select_nationen = pg_query($query_select_nationen);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_nationen) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Nation konnte nicht ausgelesen werden : " . pg_last_error());
					}
					
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_nationen, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][staatsbuergerschaft] = $line['nation_code']; 
					}
				}	
					
				//Muttersprache
				if ($line['field'] == "192")
				{
					$muttersprache = $line['value'];
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
					
					$query_select_muttersprache =
						"SELECT sprache
						FROM public.tbl_sprache
						WHERE bezeichnung[0] = '$muttersprache'
						OR bezeichnung[1] = '$muttersprache'
						OR bezeichnung[2] = '$muttersprache'
						OR bezeichnung[3] = '$muttersprache'";

					$result_select_muttersprache = pg_query($query_select_muttersprache);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_muttersprache) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Muttersprache konnte nicht ausgelesen werden : " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_muttersprache, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][muttersprache] = $line['sprache']; 
					}
				}	
				
				if ($line['field'] == "191")
				{
					$anmeldungen[$anmeldung_id][straße] = $line['value'];
				}	
				
				if ($line['field'] == "190")
				{
					$anmeldungen[$anmeldung_id][plz] = $line['value'];
				}	
				
				if ($line['field'] == "189")
				{
					$anmeldungen[$anmeldung_id][ort] = $line['value'];
				}	
				
				if ($line['field'] == "188")
				{
					$anmeldungen[$anmeldung_id][gemeinde] = $line['value'];
				}	
				
				//Hauptwohnsitz ungleich Zustelladresse
				if ($line['field'] == "187")
				{
					$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = $line['value'];

					if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == '["ja"]')
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "t";
					}
					else if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == '["nein"]')
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "f";
					}
					else if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == NULL)
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "f";
					}
				}	
				
				if ($line['field'] == "186")
				{
					$anmeldungen[$anmeldung_id][straße_2] = $line['value'];
				}	
				
				if ($line['field'] == "185")
				{
					$anmeldungen[$anmeldung_id][plz_2] = $line['value'];
									
					if ($anmeldungen[$anmeldung_id][plz_2] == NULL)
					{
						$anmeldungen[$anmeldung_id][plz_2] = "0";
					}
				}	
				
				if ($line['field'] == "184")
				{
					$anmeldungen[$anmeldung_id][ort_2] = $line['value'];
				}	
				
				if ($line['field'] == "183")
				{
					$anmeldungen[$anmeldung_id][gemeinde_2] = $line['value'];
				}	
				
				if ($line['field'] == "182")
				{
					$anmeldungen[$anmeldung_id][email] = $line['value'];
				}
											
				if ($line['field'] == "180")
				{
					$anmeldungen[$anmeldung_id][telefon] = $line['value'];
				}	
				
				if ($line['field'] == "225")
				{
					$anmeldungen[$anmeldung_id][semester] = $line['value'];
				}	


				//Interesse für folgenden Bachelorstudiengang (Es wird nicht zwischen VZ und BB unterschieden)
				//Geschrieben wird ins Anmerkungsfeld
				if ($line['field'] == "227" && $line['value'] != "")
				{
					$zeichenkette = $line['value'];
					//BIWB
					$suchmuster_1 = "/Wirtschaftsbeziehungen/i";
					
					//BIMK
					$suchmuster_2 = "/Kommunikation/i";
					
					//BITI
					$suchmuster_3 = "/Infrastruktur/i";
					
					//BSOZ
					$suchmuster_4 = "/Soziale/i";
					
					//BEUM
					$suchmuster_5 = "/Umweltmanagement/i";
					
					//BGMF
					$suchmuster_6 = "/Gesundheitsmanagement/i";
					
					//BGUK
					$suchmuster_7 = "/Krankenpflege/i";
					
					//BPHY
					$suchmuster_8 = "/Physiotherapie/i";

					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
						$anmeldungen[$anmeldung_id][anmerkung] = "Interesse für BIWB ";
					} 
					else if (preg_match($suchmuster_2, $zeichenkette)) 
					{
						$anmeldungen[$anmeldung_id][anmerkung] = "Interesse für BIMK ";
					} 
					else if (preg_match($suchmuster_3, $zeichenkette)) 
					{
						$anmeldungen[$anmeldung_id][anmerkung] = "Interesse für BITI ";
					}
					else if (preg_match($suchmuster_4, $zeichenkette)) 
					{
						$anmeldungen[$anmeldung_id][anmerkung] = "Interesse für BSOZ ";
					} 
					else if (preg_match($suchmuster_5, $zeichenkette)) 
					{
						$anmeldungen[$anmeldung_id][anmerkung] = "Interesse für BEUM ";
					} 
					else if (preg_match($suchmuster_6, $zeichenkette)) 
					{
						$anmeldungen[$anmeldung_id][anmerkung] = "Interesse für BGMF ";
					} 
					else if (preg_match($suchmuster_7, $zeichenkette)) 
					{
						$anmeldungen[$anmeldung_id][anmerkung] = "Interesse für BGUK ";
					} 
					else if (preg_match($suchmuster_8, $zeichenkette)) 
					{
						$anmeldungen[$anmeldung_id][anmerkung] = "Interesse für BPHY ";
					} 
				}	
				
				//Lebenslauf auf FHC-Server kopieren und Name in Array schreiben
				if ($line['field'] == "216") 
				{
					//Vollständiger Pfad: p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/
					
					$wert = $line['value'];
					$klammern_und_hochkomma = array('[', ']', '"');
					$dateiname_ohne_klammern_und_hochkomma = str_replace($klammern_und_hochkomma, "", $wert);
					$lebenslauf_pfad = "p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/" . $dateiname_ohne_klammern_und_hochkomma;
					
					$host = 'p246607.mittwaldserver.info';
					$port = 22;
					$username = 'p246607';
					$password = 'ewemiZez+473';
					$remoteDir = '/html/typo3/uploads/tx_powermail/';
					$localDir = '/var/www/vilesci/statistik/tests/controllingboard/test_quellordner/';
					$file = $dateiname_ohne_klammern_und_hochkomma;
					
					//Eintrag in Logfile bei Fehler
					if (!function_exists("ssh2_connect")) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Function ssh2_connect not found, you cannot use ssh2 here!");
					}
								
					if (!$connection = ssh2_connect($host, $port))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to connect over ssh2!");
					}
									
					if (!ssh2_auth_password($connection, $username, $password))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to authenticate (ssh2)!");
					}
													
					if (!$stream = ssh2_sftp($connection))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create a stream. (ssh2)!");
					}
									
					if (!$dir = opendir("ssh2.sftp://{$stream}{$remoteDir}"))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Could not open the directory (ssh2)!");
					}
					
					//echo "Copying file: $file\n";
					if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}{$file}", 'r'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to open remote file (ssh2): $file\n");
						continue;
					}
	
					if (!$local = @fopen($localDir . $file, 'w'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create local file (ssh2): $file\n");
						continue;
					}

					$read = 0;
					$filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}{$file}");
					while ($read < $filesize && ($buffer = fread($remote, $filesize - $read)))
					{
						$read += strlen($buffer);
						if (fwrite($local, $buffer) === FALSE)
						{
							$date = date('Y-m-d h:i:s');
							createLog($date . " - Unable to write to local file (ssh2): $file\n");
							break;
						}
					}
					fclose($local);
					fclose($remote);
					
					
					//TODO: Auf CIS-Server Pfad ändern
					$anmeldungen[$anmeldung_id][lebenslauf] = $file; 
				
				}
					
				//Zeugnis auf CIS-Server kopieren und Name in Array schreiben
				if ($line['field'] == "210")
				{
					//Vollständiger Pfad: p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/
					
					$wert = $line['value'];
					$klammern_und_hochkomma = array('[', ']', '"');
					$dateiname_ohne_klammern_und_hochkomma = str_replace($klammern_und_hochkomma, "", $wert);
					$lebenslauf_pfad = "p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/" . $dateiname_ohne_klammern_und_hochkomma;
					
					$host = 'p246607.mittwaldserver.info';
					$port = 22;
					$username = 'p246607';
					$password = 'ewemiZez+473';
					$remoteDir = '/html/typo3/uploads/tx_powermail/';
					$localDir = '/var/www/vilesci/statistik/tests/controllingboard/test_quellordner/';
					$file = $dateiname_ohne_klammern_und_hochkomma;
					
						//Eintrag in Logfile bei Fehler
					if (!function_exists("ssh2_connect")) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Function ssh2_connect not found, you cannot use ssh2 here!");
					}
								
					if (!$connection = ssh2_connect($host, $port))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to connect over ssh2!");
					}
									
					if (!ssh2_auth_password($connection, $username, $password))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to authenticate (ssh2)!");
					}
													
					if (!$stream = ssh2_sftp($connection))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create a stream. (ssh2)!");
					}
									
					if (!$dir = opendir("ssh2.sftp://{$stream}{$remoteDir}"))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Could not open the directory (ssh2)!");
					}
					
					//echo "Copying file: $file\n";
					if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}{$file}", 'r'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to open remote file (ssh2): $file\n");
						continue;
					}
	
					if (!$local = @fopen($localDir . $file, 'w'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create local file (ssh2): $file\n");
						continue;
					}

					$read = 0;
					$filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}{$file}");
					while ($read < $filesize && ($buffer = fread($remote, $filesize - $read)))
					{
						$read += strlen($buffer);
						if (fwrite($local, $buffer) === FALSE)
						{
							$date = date('Y-m-d h:i:s');
							createLog($date . " - Unable to write to local file (ssh2): $file\n");
							break;
						}
					}
					fclose($local);
					fclose($remote);
					
					
					//TODO: Auf CIS-Server Pfad ändern
					$anmeldungen[$anmeldung_id][zeugnis] = $file; 
				}
			
				//Die Anmerkung wird an das Interesse für den Studiengang angehängt
				if ($line['field'] == "211")
				{
					$anmeldungen[$anmeldung_id][anmerkung] = $anmeldungen[$anmeldung_id][anmerkung] . " Anmerkung: " . $line['value'];
				}	
			
			}
			else
			{
				//do nothing
			}
		}
	
		//WENN Bachelor: 
		else if ($line['pid'] == "637")
		{
		
			if ($line['mail'] != $aktuelle_anmeldung)
			{
				$aktuelle_anmeldung = next($mail_sortierter_index);
			}
			
			if ($line['mail'] == $aktuelle_anmeldung)
			{	
				echo "Bachelor - ";
				echo $line['pid'];
				echo "  -  ";
				echo $line['mail'];
				echo "  -  ";
				echo $line['field'];
				echo "  -  ";
				echo $line['value'];
				echo "<br>";
				$anmeldung_id = $aktuelle_anmeldung;
				
				$anmeldungen[$anmeldung_id][anmeldung_id] = $anmeldung_id;
				
				if ($line['field'] == "47")
				{
					$anmeldungen[$anmeldung_id][anrede] = $line['value'];
				}
				
				if ($line['field'] == "48")
				{
					$anmeldungen[$anmeldung_id][titel_pre] = $line['value'];
				}
				
				if ($line['field'] == "49")
				{
					$anmeldungen[$anmeldung_id][titel_post] = $line['value'];
				}
				
				if ($line['field'] == "50")
				{
					$anmeldungen[$anmeldung_id][zuname] = $line['value'];
				}
				
				if ($line['field'] == "51")
				{
					$anmeldungen[$anmeldung_id][vorname] = $line['value'];
				}
				
				if ($line['field'] == "52")
				{
					$anmeldungen[$anmeldung_id][vornamen] = $line['value'];
				}
				
				//Geburtsdatum
				if ($line['field'] == "53")
				{
					$timestamp = $line['value'];

					$geburtsdatum = date('Y-m-d', $timestamp);
				
					$anmeldungen[$anmeldung_id][geburtsdatum] = $geburtsdatum;
				}	
				
				if ($line['field'] == "54")
				{
					$anmeldungen[$anmeldung_id][geburtsort] = $line['value'];
				}	
										
				//Geburtsnation
				if ($line['field'] == "55")
				{
					$geburtsnation = $line['value'];
					
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
					
					$query_select_nationen =
						"SELECT nation_code
						FROM bis.tbl_nation
						WHERE engltext = '$geburtsnation'";

					$result_select_nationen = pg_query($query_select_nationen);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_nationen) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Abfrage fehlgeschlagen (SELECT Nationen) : " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_nationen, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][geburtsnation] = $line['nation_code']; 
					}
				}	
					
				if ($line['field'] == "57")
				{
					$anmeldungen[$anmeldung_id][svnr_anmeldung] = $line['value'];
				}
				
				//Staatsbürgerschaft
				if ($line['field'] == "62")
				{
					$staatsbuergerschaft = $line['value'];
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
					
					$query_select_nationen =
						"SELECT nation_code
						FROM bis.tbl_nation
						WHERE engltext = '$staatsbuergerschaft'";

					$result_select_nationen = pg_query($query_select_nationen) or die('Abfrage fehlgeschlagen: (select nationen) ' . pg_last_error());
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_nationen) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Abfrage fehlgeschlagen (SELECT Nationen) : " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_nationen, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][staatsbuergerschaft] = $line['nation_code']; 
					}
				}	
					
				//Muttersprache
				if ($line['field'] == "63")
				{
					$muttersprache = $line['value'];
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
					
					$query_select_muttersprache =
						"SELECT sprache
						FROM public.tbl_sprache
						WHERE bezeichnung[0] = '$muttersprache'
						OR bezeichnung[1] = '$muttersprache'
						OR bezeichnung[2] = '$muttersprache'
						OR bezeichnung[3] = '$muttersprache'";

					$result_select_muttersprache = pg_query($query_select_muttersprache);
					
					//Eintrag in Logfile bei Fehler
					if (!result_select_muttersprache) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Abfrage fehlgeschlagen: (select sprache) : " . pg_last_error());
					}
						
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_muttersprache, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][muttersprache] = $line['sprache']; 
					}
				}	
				
				if ($line['field'] == "64")
				{
					$anmeldungen[$anmeldung_id][straße] = $line['value'];
				}	
				
				if ($line['field'] == "65")
				{
					$anmeldungen[$anmeldung_id][plz] = $line['value'];
				}	
				
				if ($line['field'] == "66")
				{
					$anmeldungen[$anmeldung_id][ort] = $line['value'];
				}	
				
				if ($line['field'] == "67")
				{
					$anmeldungen[$anmeldung_id][gemeinde] = $line['value'];
				}	
				
				//Hauptwohnsitz ungleich Zustelladresse
				if ($line['field'] == "69")
				{
					$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = $line['value'];

					if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == '["ja"]')
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "t";
					}
					else if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == '["nein"]')
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "f";
					}
					else if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == NULL)
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "f";
					}
				}	
				
				if ($line['field'] == "70")
				{
					$anmeldungen[$anmeldung_id][straße_2] = $line['value'];
				}	
				
				if ($line['field'] == "71")
				{
					$anmeldungen[$anmeldung_id][plz_2] = $line['value'];
									
					if ($anmeldungen[$anmeldung_id][plz_2] == NULL)
					{
						$anmeldungen[$anmeldung_id][plz_2] = "0";
					}
				}	
				
				if ($line['field'] == "72")
				{
					$anmeldungen[$anmeldung_id][ort_2] = $line['value'];
				}	
				
				if ($line['field'] == "73")
				{
					$anmeldungen[$anmeldung_id][gemeinde_2] = $line['value'];
				}	
				
				if ($line['field'] == "68")
				{
					$anmeldungen[$anmeldung_id][email] = $line['value'];
				}
				
				//ZGV-Felder Bachelor
				if ($line['field'] == "76")
				{
					$zgv_b = $line['value'];
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
					
					$query_select_zgv_b =
						"SELECT zgv_code
						FROM bis.tbl_zgv
						WHERE zgv_bez = '$zgv_b'";

					$result_select_zgv_b = pg_query($query_select_zgv_b);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_zgv_b) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Abfrage fehlgeschlagen: (select zgv_b) : " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_zgv_b, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][zgv_b] = $line['zgv_code']; 
					}
				}
				
				if ($line['field'] == "78")
				{
					$anmeldungen[$anmeldung_id][zgv_b_ort] = $line['value'];
				}
								
				if ($line['field'] == "80")
				{
					if ($line['value'] == '["ja"]')
					{
						$anmeldungen[$anmeldung_id][reife_englisch] = "t";
					}
					else if ($line['value'] == '["nein"]')
					{
						$anmeldungen[$anmeldung_id][reife_englisch] = "f";
					}
					else 
					{
						$anmeldungen[$anmeldung_id][reife_englisch] = "f";
					}
				}	
				
				if ($line['field'] == "82")
				{
					$anmeldungen[$anmeldung_id][anmerkung] = $line['value'];
				}	
				
				
				if ($line['field'] == "79")
				{
					$anmeldungen[$anmeldung_id][reifepruef_datum] = $line['value'];
				}	
				
				if ($line['field'] == "75")
				{
					$anmeldungen[$anmeldung_id][telefon] = $line['value'];
				}	
				
				if ($line['field'] == "59")
				{
					$anmeldungen[$anmeldung_id][semester] = $line['value'];
				}	

				//Bachelor Department Wirtschaft
				if ($line['field'] == "39" && $line['value'] != "")
				{	
					$zeichenkette = $line['value'];
					//263 - VZ
					$suchmuster_1 = "/263-v/i";
					//263 - BB
					$suchmuster_2 = "/263-b/i";
					
					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "263";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "263";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "263";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "263";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "t";
						}
						else 
						{
							//do nothing
						}
					} 
					
					if (preg_match($suchmuster_2, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "263";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "263";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "263";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "263";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
				}	
				
				//Bachelor Department Informationstechnologie und Informationsmanagement 
				if ($line['field'] == "42" && $line['value'] != "")
				{
					$zeichenkette = $line['value'];
					//639 - VZ
					$suchmuster_1 = "/639-v/i";
					//639 - BB
					$suchmuster_2 = "/639-b/i";
					//640 - VZ
					$suchmuster_3 = "/640-v/i";
					//640 - BB
					$suchmuster_4 = "/640-b/i";
					
					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "639";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "639";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "639";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "639";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "t";
						}
						else 
						{
							//do nothing
						}
					} 
					
					if (preg_match($suchmuster_2, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "639";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "639";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "639";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "639";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
					
					if (preg_match($suchmuster_3, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "640";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "640";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "640";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "640";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "t";
						}
						else 
						{
							//do nothing
						}
					}
					
					if (preg_match($suchmuster_4, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "640";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "640";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "640";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "640";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
				}	
			
				//Bachelor Department Soziales 
				if ($line['field'] == "226" && $line['value'] != "")
				{
					$zeichenkette = $line['value'];
					//639 - VZ
					$suchmuster_1 = "/743-v/i";

					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "743";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "743";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "743";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "743";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "t";
						}
						else 
						{
							//do nothing
						}
					} 
				}	
				
				//Bachelor Department Energie-Umweltmanagement 
				if ($line['field'] == "43" && $line['value'] != "")
				{
					$zeichenkette = $line['value'];
					//265 - VZ
					$suchmuster_1 = "/265-v/i";
					//265 - BB
					$suchmuster_2 = "/265-b/i";
					
					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "265";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "265";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "265";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "265";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "t";
						}
						else 
						{
							//do nothing
						}
					} 
					
					if (preg_match($suchmuster_2, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "265";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "265";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "265";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "265";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
				}	
				
				//Bachelor Department Gesundheit 
				if ($line['field'] == "44" && $line['value'] != "")
				{
					$zeichenkette = $line['value'];
					//268 - VZ
					$suchmuster_1 = "/268-v/i";
					//761 - VZ
					$suchmuster_2 = "/761-v/i";
					//760 - VZ
					$suchmuster_3 = "/760-v/i";

					
					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "268";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "268";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "268";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "268";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "t";
						}
						else 
						{
							//do nothing
						}
					} 
					
					if (preg_match($suchmuster_2, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "761";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "761";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "761";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "761";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "t";
						}
						else 
						{
							//do nothing
						}
					}
					
					if (preg_match($suchmuster_3, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "760";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "760";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "760";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "760";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "t";
						}
						else 
						{
							//do nothing
						}
					}
				}	
				

				if ($line['field'] == "")
				{
					$anmeldungen[$anmeldung_id][zgv_d] = $line['value'];
				}	
				
				if ($line['field'] == "")
				{
					$anmeldungen[$anmeldung_id][zgv_d_ort] = $line['value'];
				}		
				
				//Lebenslauf auf FHC-Server kopieren und Name in Array schreiben
				if ($line['field'] == "45") 
				{
					//Vollständiger Pfad: p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/
					
					$wert = $line['value'];
					$klammern_und_hochkomma = array('[', ']', '"');
					$dateiname_ohne_klammern_und_hochkomma = str_replace($klammern_und_hochkomma, "", $wert);
					$lebenslauf_pfad = "p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/" . $dateiname_ohne_klammern_und_hochkomma;
					
					$host = 'p246607.mittwaldserver.info';
					$port = 22;
					$username = 'p246607';
					$password = 'ewemiZez+473';
					$remoteDir = '/html/typo3/uploads/tx_powermail/';
					$localDir = '/var/www/vilesci/statistik/tests/controllingboard/test_quellordner/';
					$file = $dateiname_ohne_klammern_und_hochkomma;
					
					//Eintrag in Logfile bei Fehler
					if (!function_exists("ssh2_connect")) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Function ssh2_connect not found, you cannot use ssh2 here!");
					}
								
					if (!$connection = ssh2_connect($host, $port))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to connect over ssh2!");
					}
									
					if (!ssh2_auth_password($connection, $username, $password))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to authenticate (ssh2)!");
					}
													
					if (!$stream = ssh2_sftp($connection))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create a stream. (ssh2)!");
					}
									
					if (!$dir = opendir("ssh2.sftp://{$stream}{$remoteDir}"))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Could not open the directory (ssh2)!");
					}
					
					//echo "Copying file: $file\n";
					if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}{$file}", 'r'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to open remote file (ssh2): $file\n");
						continue;
					}
	
					if (!$local = @fopen($localDir . $file, 'w'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create local file (ssh2): $file\n");
						continue;
					}

					$read = 0;
					$filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}{$file}");
					while ($read < $filesize && ($buffer = fread($remote, $filesize - $read)))
					{
						$read += strlen($buffer);
						if (fwrite($local, $buffer) === FALSE)
						{
							$date = date('Y-m-d h:i:s');
							createLog($date . " - Unable to write to local file (ssh2): $file\n");
							break;
						}
					}
					fclose($local);
					fclose($remote);
					
					
					//TODO: Auf CIS-Server Pfad ändern
					$anmeldungen[$anmeldung_id][lebenslauf] = $file; 
				
				}
					
				//Zeugnis auf CIS-Server kopieren und Name in Array schreiben
				if ($line['field'] == "46")
				{
					//Vollständiger Pfad: p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/
					
					$wert = $line['value'];
					$klammern_und_hochkomma = array('[', ']', '"');
					$dateiname_ohne_klammern_und_hochkomma = str_replace($klammern_und_hochkomma, "", $wert);
					$lebenslauf_pfad = "p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/" . $dateiname_ohne_klammern_und_hochkomma;
					
					$host = 'p246607.mittwaldserver.info';
					$port = 22;
					$username = 'p246607';
					$password = 'ewemiZez+473';
					$remoteDir = '/html/typo3/uploads/tx_powermail/';
					$localDir = '/var/www/vilesci/statistik/tests/controllingboard/test_quellordner/';
					$file = $dateiname_ohne_klammern_und_hochkomma;
					
					//Eintrag in Logfile bei Fehler
					if (!function_exists("ssh2_connect")) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Function ssh2_connect not found, you cannot use ssh2 here!");
					}
								
					if (!$connection = ssh2_connect($host, $port))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to connect over ssh2!");
					}
									
					if (!ssh2_auth_password($connection, $username, $password))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to authenticate (ssh2)!");
					}
													
					if (!$stream = ssh2_sftp($connection))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create a stream. (ssh2)!");
					}
									
					if (!$dir = opendir("ssh2.sftp://{$stream}{$remoteDir}"))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Could not open the directory (ssh2)!");
					}
					
					//echo "Copying file: $file\n";
					if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}{$file}", 'r'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to open remote file (ssh2): $file\n");
						continue;
					}
	
					if (!$local = @fopen($localDir . $file, 'w'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create local file (ssh2): $file\n");
						continue;
					}

					$read = 0;
					$filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}{$file}");
					while ($read < $filesize && ($buffer = fread($remote, $filesize - $read)))
					{
						$read += strlen($buffer);
						if (fwrite($local, $buffer) === FALSE)
						{
							$date = date('Y-m-d h:i:s');
							createLog($date . " - Unable to write to local file (ssh2): $file\n");
							break;
						}
					}
					fclose($local);
					fclose($remote);
					
					
					//TODO: Auf CIS-Server Pfad ändern
					$anmeldungen[$anmeldung_id][zeugnis] = $file; 
				}
			}
			else
			{
				//do nothing
			}
		}
		
		//WENN Master:
		else if ($line['pid'] == "642")
		{
				echo "Master - ";
				echo $line['pid'];
				echo "  -  ";
				echo $line['mail'];
				echo "  -  ";
				echo $line['field'];
				echo "  -  ";
				echo $line['value'];
				echo "<br>";
		
			if ($line['mail'] != $aktuelle_anmeldung)
			{
				$aktuelle_anmeldung = next($mail_sortierter_index);
			}
			
			if ($line['mail'] == $aktuelle_anmeldung)
			{					
				$anmeldung_id = $aktuelle_anmeldung;
				
				$anmeldungen[$anmeldung_id][anmeldung_id] = $anmeldung_id;
				
				if ($line['field'] == "125")
				{
					$anmeldungen[$anmeldung_id][anrede] = $line['value'];
				}
				
				if ($line['field'] == "120")
				{
					$anmeldungen[$anmeldung_id][titel_pre] = $line['value'];
				}
				
				if ($line['field'] == "112")
				{
					$anmeldungen[$anmeldung_id][titel_post] = $line['value'];
				}
				
				if ($line['field'] == "110")
				{
					$anmeldungen[$anmeldung_id][zuname] = $line['value'];
				}
				
				if ($line['field'] == "109")
				{
					$anmeldungen[$anmeldung_id][vorname] = $line['value'];
				}
				
				if ($line['field'] == "107")
				{
					$anmeldungen[$anmeldung_id][vornamen] = $line['value'];
				}
				
				//Geburtsdatum
				if ($line['field'] == "106")
				{
					$timestamp = $line['value'];

					$geburtsdatum = date('Y-m-d', $timestamp);
				
					$anmeldungen[$anmeldung_id][geburtsdatum] = $geburtsdatum;
				}
					
				
				if ($line['field'] == "105")
				{
					$anmeldungen[$anmeldung_id][geburtsort] = $line['value'];
				}	
										
				//Geburtsnation
				if ($line['field'] == "104")
				{
					$geburtsnation = $line['value'];
					
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#");
					
					//Eintrag in Logfile bei Fehler
					if (!$dbconn) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Verbindungsaufbau fehlgeschlagen: " . pg_last_error());
					}
					
					$query_select_nationen =
						"SELECT nation_code
						FROM bis.tbl_nation
						WHERE engltext = '$geburtsnation'";

					$result_select_nationen = pg_query($query_select_nationen);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_nationen) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Abfrage fehlgeschlagen: (select nationen) : " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_nationen, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][geburtsnation] = $line['nation_code']; 
					}
				}	
					
				if ($line['field'] == "102")
				{
					$anmeldungen[$anmeldung_id][svnr_anmeldung] = $line['value'];
				}
				
				//Staatsbürgerschaft
				if ($line['field'] == "101")
				{
					$staatsbuergerschaft = $line['value'];
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#");
					
					//Eintrag in Logfile bei Fehler
					if (!$dbconn) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Verbindungsaufbau fehlgeschlagen: " . pg_last_error());
					}
					
					$query_select_nationen =
						"SELECT nation_code
						FROM bis.tbl_nation
						WHERE engltext = '$staatsbuergerschaft'";

					$result_select_nationen = pg_query($query_select_nationen);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_nationen) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Abfrage fehlgeschlagen: (select nationen) : " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_nationen, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][staatsbuergerschaft] = $line['nation_code']; 
					}
				}	
					
				//Muttersprache
				if ($line['field'] == "100")
				{
					$muttersprache = $line['value'];
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#");
					
					//Eintrag in Logfile bei Fehler
					if (!$dbconn) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Verbindungsaufbau fehlgeschlagen: " . pg_last_error());
					}
					
					$query_select_muttersprache =
						"SELECT sprache
						FROM public.tbl_sprache
						WHERE bezeichnung[0] = '$muttersprache'
						OR bezeichnung[1] = '$muttersprache'
						OR bezeichnung[2] = '$muttersprache'
						OR bezeichnung[3] = '$muttersprache'";

					$result_select_muttersprache = pg_query($query_select_muttersprache);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_muttersprache) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Abfrage fehlgeschlagen: (select sprache) : " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_muttersprache, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][muttersprache] = $line['sprache']; 
					}
				}	
				
				if ($line['field'] == "99")
				{
					$anmeldungen[$anmeldung_id][straße] = $line['value'];
				}	
				
				if ($line['field'] == "98")
				{
					$anmeldungen[$anmeldung_id][plz] = $line['value'];
				}	
				
				if ($line['field'] == "97")
				{
					$anmeldungen[$anmeldung_id][ort] = $line['value'];
				}	
				
				if ($line['field'] == "96")
				{
					$anmeldungen[$anmeldung_id][gemeinde] = $line['value'];
				}	
				
				//Hauptwohnsitz ungleich Zustelladresse
				if ($line['field'] == "95")
				{
					$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = $line['value'];

					if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == '["ja"]')
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "t";
					}
					else if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == '["nein"]')
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "f";
					}
					else if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == NULL)
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "f";
					}
				}	
				
				if ($line['field'] == "94")
				{
					$anmeldungen[$anmeldung_id][straße_2] = $line['value'];
				}	
				
				if ($line['field'] == "93")
				{
					$anmeldungen[$anmeldung_id][plz_2] = $line['value'];
									
					if ($anmeldungen[$anmeldung_id][plz_2] == NULL)
					{
						$anmeldungen[$anmeldung_id][plz_2] = "0";
					}
				}	
				
				if ($line['field'] == "92")
				{
					$anmeldungen[$anmeldung_id][ort_2] = $line['value'];
				}	
				
				if ($line['field'] == "91")
				{
					$anmeldungen[$anmeldung_id][gemeinde_2] = $line['value'];
				}	
				
				if ($line['field'] == "90")
				{
					$anmeldungen[$anmeldung_id][email] = $line['value'];
				}
								
				//ZGV-Felder Master
				if ($line['field'] == "116")
				{
					//$anmeldungen[$anmeldung_id][zgv_m_ort] = $line['value'];
					$zgv_m = $line['value'];
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#");
					
					//Eintrag in Logfile bei Fehler
					if (!$dbconn) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Verbindungsaufbau fehlgeschlagen: " . pg_last_error());
					}
					
					$query_select_zgv_m =
						"SELECT zgvmas_code
						FROM bis.tbl_zgvmaster
						WHERE zgvmas_bez = '$zgv_m'";

					$result_select_zgv_m = pg_query($query_select_zgv_m);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_zgv_m) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Abfrage fehlgeschlagen: (select zgv_m) " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_zgv_m, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][zgv_m] = $line['zgvmas_code']; 
					}	
				}
				
				if ($line['field'] == "115")
				{
					$anmeldungen[$anmeldung_id][zgv_m_ort] = $line['value'];
				}
				
				
				//Da das Feld Reife-Englisch beim Query absetzen benötigt wird, wird es beim Master automatisch auf TRUE gesetzt
				$anmeldungen[$anmeldung_id][reife_englisch] = "t";
				
				if ($line['field'] == "121")
				{
					$anmeldungen[$anmeldung_id][anmerkung] = $line['value'];
				}	
								
				if ($line['field'] == "111")
				{
					$anmeldungen[$anmeldung_id][reifepruef_datum] = $line['value'];
				}

				if ($line['field'] == "88")
				{
					$anmeldungen[$anmeldung_id][telefon] = $line['value'];
				}	
				
				if ($line['field'] == "133")
				{
					$anmeldungen[$anmeldung_id][semester] = $line['value'];
				}	
				

				//Master Department Wirtschaft
				if ($line['field'] == "127" && $line['value'] != "")
				{

					$zeichenkette = $line['value'];
					
					//402 - BB
					$suchmuster_1 = "/402-b/i";
					//401 - BB
					$suchmuster_2 = "/401-b/i";
					//264 - VZ
					$suchmuster_3 = "/264-v/i";
					//264 - BB
					$suchmuster_4 = "/264-b/i";
					//271 - BB
					$suchmuster_5 = "/271-b/i";
					//783 - BB
					$suchmuster_6 = "/783-b/i";
					
					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
					echo " MEST ";
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "402";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "402";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "402";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "402";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					} 
					
					if (preg_match($suchmuster_2, $zeichenkette)) 
					{
					echo " MHRM ";
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "401";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "401";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "401";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "401";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
					
					if (preg_match($suchmuster_3, $zeichenkette)) 
					{
					echo " MIWB ";
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "264";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "264";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "264";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "264";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "t";
						}
						else 
						{
							//do nothing
						}
					}
					
					if (preg_match($suchmuster_4, $zeichenkette)) 
					{
					echo " MIWB ";
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "264";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "264";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "264";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "264";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
					
					if (preg_match($suchmuster_5, $zeichenkette)) 
					{
					echo " MIWM ";
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "271";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "271";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "271";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "271";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
					
					if (preg_match($suchmuster_6, $zeichenkette)) 
					{
					echo " MPEB ";
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "783";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "783";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "783";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "783";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
				}	
			
				//Master Department Informationstechnologie und Informationsmanagement			
				if ($line['field'] == "122" && $line['value'] != "")
				{
					$zeichenkette = $line['value'];
					
					//364 - BB
					$suchmuster_1 = "/364-b/i";
					//635 - BB
					$suchmuster_2 = "/635-b/i";
					//781 - BB
					$suchmuster_3 = "/781-b/i";
					//725 - BB
					$suchmuster_4 = "/725-b/i";
					
					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "364";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "364";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "364";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "364";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					} 
					
					if (preg_match($suchmuster_2, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "635";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "635";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "635";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "635";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
					
					if (preg_match($suchmuster_3, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "781";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "781";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "781";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "781";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
					
					if (preg_match($suchmuster_4, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "725";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "725";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "725";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "725";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
				}	
				
				//Master Department Energie-Umweltmanagement
				if ($line['field'] == "119" && $line['value'] != "")
				{
					$zeichenkette = $line['value'];
					
					//266 - VZ
					$suchmuster_1 = "/266-v/i";
					//267 - BB
					$suchmuster_2 = "/267-b/i";
					//400 - BB
					$suchmuster_3 = "/400-b/i";

					
					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "266";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "266";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "266";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "t";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "266";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "t";
						}
						else 
						{
							//do nothing
						}
					} 
					
					if (preg_match($suchmuster_2, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "267";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "267";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "267";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "267";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
					
					if (preg_match($suchmuster_3, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "400";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "400";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "400";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "400";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
				}	
				
				//Master Department Gesundheit
				if ($line['field'] == "114" && $line['value'] != "")
				{
					$zeichenkette = $line['value'];
					
					//764 - BB
					$suchmuster_1 = "/764-b/i";
					//269 - BB
					$suchmuster_2 = "/269-b/i";

					if (preg_match($suchmuster_1, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "764";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "764";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "764";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "764";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					} 
					
					if (preg_match($suchmuster_2, $zeichenkette)) 
					{
						if ($anmeldungen[$anmeldung_id][studiengang_1] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_1] = "269";
							$anmeldungen[$anmeldung_id][vollzeit_1] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && $anmeldungen[$anmeldung_id][studiengang_2] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_2] = "269";
							$anmeldungen[$anmeldung_id][vollzeit_2] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && $anmeldungen[$anmeldung_id][studiengang_3] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_3] = "269";
							$anmeldungen[$anmeldung_id][vollzeit_3] = "f";
						}
						else if (isset($anmeldungen[$anmeldung_id][studiengang_1]) && isset($anmeldungen[$anmeldung_id][studiengang_2]) && isset($anmeldungen[$anmeldung_id][studiengang_3])&& $anmeldungen[$anmeldung_id][studiengang_4] == "")
						{
							$anmeldungen[$anmeldung_id][studiengang_4] = "269";
							$anmeldungen[$anmeldung_id][vollzeit_4] = "f";
						}
						else 
						{
							//do nothing
						}
					}
				}	
				
				/*
				if ($line['field'] == "")
				{
					$anmeldungen[$anmeldung_id][zgv_d] = $line['value'];
				}	
				
				if ($line['field'] == "")
				{
					$anmeldungen[$anmeldung_id][zgv_d_ort] = $line['value'];
				}
				*/
				
				//Lebenslauf auf FHC-Server kopieren und Name in Array schreiben
				if ($line['field'] == "124") 
				{
					//Vollständiger Pfad: p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/
					
					$wert = $line['value'];
					$klammern_und_hochkomma = array('[', ']', '"');
					$dateiname_ohne_klammern_und_hochkomma = str_replace($klammern_und_hochkomma, "", $wert);
					$lebenslauf_pfad = "p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/" . $dateiname_ohne_klammern_und_hochkomma;
					
					$host = 'p246607.mittwaldserver.info';
					$port = 22;
					$username = 'p246607';
					$password = 'ewemiZez+473';
					$remoteDir = '/html/typo3/uploads/tx_powermail/';
					$localDir = '/var/www/vilesci/statistik/tests/controllingboard/test_quellordner/';
					$file = $dateiname_ohne_klammern_und_hochkomma;
					
					//Eintrag in Logfile bei Fehler
					if (!function_exists("ssh2_connect")) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Function ssh2_connect not found, you cannot use ssh2 here!");
					}
								
					if (!$connection = ssh2_connect($host, $port))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to connect over ssh2!");
					}
									
					if (!ssh2_auth_password($connection, $username, $password))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to authenticate (ssh2)!");
					}
													
					if (!$stream = ssh2_sftp($connection))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create a stream. (ssh2)!");
					}
									
					if (!$dir = opendir("ssh2.sftp://{$stream}{$remoteDir}"))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Could not open the directory (ssh2)!");
					}
					
					//echo "Copying file: $file\n";
					if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}{$file}", 'r'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to open remote file (ssh2): $file\n");
						continue;
					}
	
					if (!$local = @fopen($localDir . $file, 'w'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create local file (ssh2): $file\n");
						continue;
					}

					$read = 0;
					$filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}{$file}");
					while ($read < $filesize && ($buffer = fread($remote, $filesize - $read)))
					{
						$read += strlen($buffer);
						if (fwrite($local, $buffer) === FALSE)
						{
							$date = date('Y-m-d h:i:s');
							createLog($date . " - Unable to write to local file (ssh2): $file\n");
							break;
						}
					}
					fclose($local);
					fclose($remote);
					
					
					//TODO: Auf CIS-Server Pfad ändern
					$anmeldungen[$anmeldung_id][lebenslauf] = $file; 
				
				}
					
				//Zeugnis auf CIS-Server kopieren und Name in Array schreiben
				if ($line['field'] == "118")
				{
					//Vollständiger Pfad: p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/
					
					$wert = $line['value'];
					$klammern_und_hochkomma = array('[', ']', '"');
					$dateiname_ohne_klammern_und_hochkomma = str_replace($klammern_und_hochkomma, "", $wert);
					$lebenslauf_pfad = "p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/" . $dateiname_ohne_klammern_und_hochkomma;
					
					$host = 'p246607.mittwaldserver.info';
					$port = 22;
					$username = 'p246607';
					$password = 'ewemiZez+473';
					$remoteDir = '/html/typo3/uploads/tx_powermail/';
					$localDir = '/var/www/vilesci/statistik/tests/controllingboard/test_quellordner/';
					$file = $dateiname_ohne_klammern_und_hochkomma;
					
					//Eintrag in Logfile bei Fehler
					if (!function_exists("ssh2_connect")) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Function ssh2_connect not found, you cannot use ssh2 here!");
					}
								
					if (!$connection = ssh2_connect($host, $port))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to connect over ssh2!");
					}
									
					if (!ssh2_auth_password($connection, $username, $password))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to authenticate (ssh2)!");
					}
													
					if (!$stream = ssh2_sftp($connection))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create a stream. (ssh2)!");
					}
									
					if (!$dir = opendir("ssh2.sftp://{$stream}{$remoteDir}"))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Could not open the directory (ssh2)!");
					}
					
					//echo "Copying file: $file\n";
					if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}{$file}", 'r'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to open remote file (ssh2): $file\n");
						continue;
					}
	
					if (!$local = @fopen($localDir . $file, 'w'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create local file (ssh2): $file\n");
						continue;
					}

					$read = 0;
					$filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}{$file}");
					while ($read < $filesize && ($buffer = fread($remote, $filesize - $read)))
					{
						$read += strlen($buffer);
						if (fwrite($local, $buffer) === FALSE)
						{
							$date = date('Y-m-d h:i:s');
							createLog($date . " - Unable to write to local file (ssh2): $file\n");
							break;
						}
					}
					fclose($local);
					fclose($remote);
					
					
					//TODO: Auf CIS-Server Pfad ändern
					$anmeldungen[$anmeldung_id][zeugnis] = $file; 
				}
			}
			else
			{
				//do nothing
			}
		}
	
		//WENN PhD-Programm
		else if ($line['pid'] == "643")
		{
			echo "PhD - ";
			echo $line['pid'];
			echo "  -  ";
			echo $line['mail'];
			echo "  -  ";
			echo $line['field'];
			echo "  -  ";
			echo $line['value'];
			echo "<br>";
		
			if ($line['mail'] != $aktuelle_anmeldung)
			{
				$aktuelle_anmeldung = next($mail_sortierter_index);
			}
			
			if ($line['mail'] == $aktuelle_anmeldung)
			{					
				$anmeldung_id = $aktuelle_anmeldung;
				
				$anmeldungen[$anmeldung_id][anmeldung_id] = $anmeldung_id;
				
				//Anrede - matcht von Mr/Ms auf Herr/Frau
				if ($line['field'] == "168")
				{
					if ($line['value'] == "Ms")
					{
						$anmeldungen[$anmeldung_id][anrede] = "Frau";
					}
					else if ($line['value'] == "Mr")
					{
						$anmeldungen[$anmeldung_id][anrede] = "Herr";
					}
				}
				
				if ($line['field'] == "162")
				{
					$anmeldungen[$anmeldung_id][titel_pre] = $line['value'];
				}
				
				if ($line['field'] == "158")
				{
					$anmeldungen[$anmeldung_id][titel_post] = $line['value'];
				}
				
				if ($line['field'] == "157")
				{
					$anmeldungen[$anmeldung_id][zuname] = $line['value'];
				}
				
				if ($line['field'] == "155")
				{
					$anmeldungen[$anmeldung_id][vorname] = $line['value'];
				}
				
				if ($line['field'] == "153")
				{
					$anmeldungen[$anmeldung_id][vornamen] = $line['value'];
				}
				
				//Geburtsdatum
				if ($line['field'] == "152")
				{
					$timestamp = $line['value'];

					$geburtsdatum = date('Y-m-d', $timestamp);
				
					$anmeldungen[$anmeldung_id][geburtsdatum] = $geburtsdatum;
				}
					
				
				if ($line['field'] == "151")
				{
					$anmeldungen[$anmeldung_id][geburtsort] = $line['value'];
				}	
										
				//Geburtsnation
				if ($line['field'] == "150")
				{
					$geburtsnation = $line['value'];
					
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
					
					$query_select_nationen =
						"SELECT nation_code
						FROM bis.tbl_nation
						WHERE engltext = '$geburtsnation'";

					$result_select_nationen = pg_query($query_select_nationen);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_nationen) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Abfrage fehlgeschlagen: (select nationen) " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_nationen, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][geburtsnation] = $line['nation_code']; 
					}
				}	
					
				if ($line['field'] == "148")
				{
					$anmeldungen[$anmeldung_id][svnr_anmeldung] = $line['value'];
				}
				
				//Staatsbürgerschaft
				if ($line['field'] == "147")
				{
					$staatsbuergerschaft = $line['value'];
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
					
					$query_select_nationen =
						"SELECT nation_code
						FROM bis.tbl_nation
						WHERE engltext = '$staatsbuergerschaft'";

					$result_select_nationen = pg_query($query_select_nationen);
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_nationen) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Abfrage fehlgeschlagen: (select nationen) " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_nationen, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][staatsbuergerschaft] = $line['nation_code']; 
					}
				}	
					
				//Muttersprache
				if ($line['field'] == "146")
				{
					$muttersprache = $line['value'];
					
					$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#") or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());
					
					$query_select_muttersprache =
						"SELECT sprache
						FROM public.tbl_sprache
						WHERE bezeichnung[0] = '$muttersprache'
						OR bezeichnung[1] = '$muttersprache'
						OR bezeichnung[2] = '$muttersprache'
						OR bezeichnung[3] = '$muttersprache'";

					$result_select_muttersprache = pg_query($query_select_muttersprache) or die('Abfrage fehlgeschlagen: (select sprache) ' . pg_last_error());
					
					//Eintrag in Logfile bei Fehler
					if (!$result_select_muttersprache) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - (Abfrage fehlgeschlagen: (select sprache) " . pg_last_error());
					}
					
					pg_close($dbconn);
					
					while ($line = pg_fetch_array($result_select_muttersprache, NULL, PGSQL_ASSOC))
					{
						$anmeldungen[$anmeldung_id][muttersprache] = $line['sprache']; 
					}
				}	
				

				if ($line['field'] == "145")
				{
					$anmeldungen[$anmeldung_id][straße] = $line['value'];
				}	
				
				if ($line['field'] == "144")
				{
					$anmeldungen[$anmeldung_id][plz] = $line['value'];
				}	
				
				if ($line['field'] == "143")
				{
					$anmeldungen[$anmeldung_id][ort] = $line['value'];
				}	
				
				if ($line['field'] == "142")
				{
					$anmeldungen[$anmeldung_id][gemeinde] = $line['value'];
				}	
				
				//Hauptwohnsitz ungleich Zustelladresse
				if ($line['field'] == "141")
				{
					$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = $line['value'];

					if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == '["ja"]')
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "t";
					}
					else if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == '["nein"]')
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "f";
					}
					else if ($anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] == NULL)
					{
						$anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse] = "f";
					}
				}	
				
				if ($line['field'] == "140")
				{
					$anmeldungen[$anmeldung_id][straße_2] = $line['value'];
				}	
				
				if ($line['field'] == "139")
				{
					$anmeldungen[$anmeldung_id][plz_2] = $line['value'];
									
					if ($anmeldungen[$anmeldung_id][plz_2] == NULL)
					{
						$anmeldungen[$anmeldung_id][plz_2] = "0";
					}
				}	
				

				if ($line['field'] == "138")
				{
					$anmeldungen[$anmeldung_id][ort_2] = $line['value'];
				}	
				
				if ($line['field'] == "137")
				{
					$anmeldungen[$anmeldung_id][gemeinde_2] = $line['value'];
				}	
				
				if ($line['field'] == "136")
				{
					$anmeldungen[$anmeldung_id][email] = $line['value'];
				}
								
				//TODO: ZGV-Felder PhD!!!
				/*
				if ($line['field'] == "")
				{
					$anmeldungen[$anmeldung_id][zgv_d] = $line['value'];
				}	
				
				if ($line['field'] == "")
				{
					$anmeldungen[$anmeldung_id][zgv_d_ort] = $line['value'];
				}
				*/
				
				//Da das Feld Reife-Englisch beim Query absetzen benötigt wird, wird es beim PhD automatisch auf TRUE gesetzt
				$anmeldungen[$anmeldung_id][reife_englisch] = "t";
				
				if ($line['field'] == "172")
				{
					$anmeldungen[$anmeldung_id][anmerkung] = $line['value'];
				}	
								
				if ($line['field'] == "134")
				{
					$anmeldungen[$anmeldung_id][telefon] = $line['value'];
				}	
				
				if ($line['field'] == "179")
				{
					$anmeldungen[$anmeldung_id][semester] = $line['value'];
				}	
				
				//PhD Studium
				if ($line['field'] == "178" && $line['value'] != "")
				{
					$anmeldungen[$anmeldung_id][studiengang_1] = "9001";
					$anmeldungen[$anmeldung_id][vollzeit_1] = "t";
				}	
				
				//Lebenslauf auf FHC-Server kopieren und Name in Array schreiben
				if ($line['field'] == "169") 
				{
					//Vollständiger Pfad: p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/
					
					$wert = $line['value'];
					$klammern_und_hochkomma = array('[', ']', '"');
					$dateiname_ohne_klammern_und_hochkomma = str_replace($klammern_und_hochkomma, "", $wert);
					$lebenslauf_pfad = "p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/" . $dateiname_ohne_klammern_und_hochkomma;
					
					$host = 'p246607.mittwaldserver.info';
					$port = 22;
					$username = 'p246607';
					$password = 'ewemiZez+473';
					$remoteDir = '/html/typo3/uploads/tx_powermail/';
					$localDir = '/var/www/vilesci/statistik/tests/controllingboard/test_quellordner/';
					$file = $dateiname_ohne_klammern_und_hochkomma;
					
					//Eintrag in Logfile bei Fehler
					if (!function_exists("ssh2_connect")) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Function ssh2_connect not found, you cannot use ssh2 here!");
					}
								
					if (!$connection = ssh2_connect($host, $port))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to connect over ssh2!");
					}
									
					if (!ssh2_auth_password($connection, $username, $password))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to authenticate (ssh2)!");
					}
													
					if (!$stream = ssh2_sftp($connection))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create a stream. (ssh2)!");
					}
									
					if (!$dir = opendir("ssh2.sftp://{$stream}{$remoteDir}"))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Could not open the directory (ssh2)!");
					}
					
					//echo "Copying file: $file\n";
					if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}{$file}", 'r'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to open remote file (ssh2): $file\n");
						continue;
					}
	
					if (!$local = @fopen($localDir . $file, 'w'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create local file (ssh2): $file\n");
						continue;
					}

					$read = 0;
					$filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}{$file}");
					while ($read < $filesize && ($buffer = fread($remote, $filesize - $read)))
					{
						$read += strlen($buffer);
						if (fwrite($local, $buffer) === FALSE)
						{
							$date = date('Y-m-d h:i:s');
							createLog($date . " - Unable to write to local file (ssh2): $file\n");
							break;
						}
					}
					fclose($local);
					fclose($remote);
					
					
					//TODO: Auf CIS-Server Pfad ändern
					$anmeldungen[$anmeldung_id][lebenslauf] = $file; 
				
				}
					
				//Zeugnis auf CIS-Server kopieren und Name in Array schreiben
				if ($line['field'] == "164")
				{
					//Vollständiger Pfad: p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/
					
					$wert = $line['value'];
					$klammern_und_hochkomma = array('[', ']', '"');
					$dateiname_ohne_klammern_und_hochkomma = str_replace($klammern_und_hochkomma, "", $wert);
					$lebenslauf_pfad = "p246607.mittwaldserver.info/html/typo3/uploads/tx_powermail/" . $dateiname_ohne_klammern_und_hochkomma;
					
					$host = 'p246607.mittwaldserver.info';
					$port = 22;
					$username = 'p246607';
					$password = 'ewemiZez+473';
					$remoteDir = '/html/typo3/uploads/tx_powermail/';
					$localDir = '/var/www/vilesci/statistik/tests/controllingboard/test_quellordner/';
					$file = $dateiname_ohne_klammern_und_hochkomma;
					
					//Eintrag in Logfile bei Fehler
					if (!function_exists("ssh2_connect")) 
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Function ssh2_connect not found, you cannot use ssh2 here!");
					}
								
					if (!$connection = ssh2_connect($host, $port))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to connect over ssh2!");
					}
									
					if (!ssh2_auth_password($connection, $username, $password))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to authenticate (ssh2)!");
					}
													
					if (!$stream = ssh2_sftp($connection))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create a stream. (ssh2)!");
					}
									
					if (!$dir = opendir("ssh2.sftp://{$stream}{$remoteDir}"))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Could not open the directory (ssh2)!");
					}
					
					//echo "Copying file: $file\n";
					if (!$remote = @fopen("ssh2.sftp://{$stream}/{$remoteDir}{$file}", 'r'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to open remote file (ssh2): $file\n");
						continue;
					}
	
					if (!$local = @fopen($localDir . $file, 'w'))
					{
						$date = date('Y-m-d h:i:s');
						createLog($date . " - Unable to create local file (ssh2): $file\n");
						continue;
					}

					$read = 0;
					$filesize = filesize("ssh2.sftp://{$stream}/{$remoteDir}{$file}");
					while ($read < $filesize && ($buffer = fread($remote, $filesize - $read)))
					{
						$read += strlen($buffer);
						if (fwrite($local, $buffer) === FALSE)
						{
							$date = date('Y-m-d h:i:s');
							createLog($date . " - Unable to write to local file (ssh2): $file\n");
							break;
						}
					}
					fclose($local);
					fclose($remote);
					
					
					//TODO: Auf CIS-Server Pfad ändern
					$anmeldungen[$anmeldung_id][zeugnis] = $file; 
				}
			}
			else
			{
				//do nothing
			}
		}
	}
	
	echo "<pre>";
	print_r($anmeldungen);
	

	$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#");
	
	//Eintrag in Logfile bei Fehler
	if (!$dbconn) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Verbindungsaufbau fehlgeschlagen: " . pg_last_error());
	}
	
	
	$anmeldungen_keys = array_keys($anmeldungen);
	
	$anmeldung_id = current($anmeldungen_keys);
	
	foreach ($anmeldungen as $anmeldung) 
	{		
		$anmeldung_id = $anmeldungen[$anmeldung_id][anmeldung_id];
		$anrede = $anmeldungen[$anmeldung_id][anrede];
		$titel_pre = $anmeldungen[$anmeldung_id][titel_pre]; 
		$titel_post = $anmeldungen[$anmeldung_id][titel_post]; 
		$zuname = $anmeldungen[$anmeldung_id][zuname]; 
		$vorname = $anmeldungen[$anmeldung_id][vorname]; 
		$vornamen = $anmeldungen[$anmeldung_id][vornamen];
		$geburtsort = $anmeldungen[$anmeldung_id][geburtsort]; 
		$geburtsnation = $anmeldungen[$anmeldung_id][geburtsnation]; 
		$svnr_anmeldung = $anmeldungen[$anmeldung_id][svnr_anmeldung];
		//Für den Fall, dass keine Österreichische SVNR vorhanden ist, wird an dieser Stelle eine Zufallszahl eingefügt,
		//da SVNR für die eindeutige zuordnung von Adresse usw. notwendig ist.
		if ($svnr_anmeldung == "" || $svnr_anmeldung == " " || $svnr_anmeldung == NULL)
		{
			$aut_svnr = 'f';
			//Erfundene SVNR - Für spätere Zuordnung von Adresse, Kontakt, etc. - wird nicht in Person-Tabelle übernommen
			$svnr_anmeldung = mt_rand(1000000000,9999999999);
		}
		else
		{
			$aut_svnr = 't';
		}	
		
		
		$staatsbuergerschaft = $anmeldungen[$anmeldung_id][staatsbuergerschaft]; 
		
		$muttersprache = $anmeldungen[$anmeldung_id][muttersprache]; 
		$straße = $anmeldungen[$anmeldung_id][straße]; 
		$plz = $anmeldungen[$anmeldung_id][plz];
		$ort = $anmeldungen[$anmeldung_id][ort]; 
		$gemeinde = $anmeldungen[$anmeldung_id][gemeinde]; 
		$hauptwohnsitz_ungleich_zustelladresse = $anmeldungen[$anmeldung_id][hauptwohnsitz_ungleich_zustelladresse]; 
		$straße_2 = $anmeldungen[$anmeldung_id][straße_2]; 
		$plz_2 = $anmeldungen[$anmeldung_id][plz_2]; 

		//PLZ_2 muss für Integer-Feld in Tabelle einen numerischen Wert haben
		if ($plz_2 == "" || $plz_2 == " " || $plz_2 == NULL)
		{
			$plz_2 = '0';
		}

		$ort_2 = $anmeldungen[$anmeldung_id][ort_2]; 
		$gemeinde_2 = $anmeldungen[$anmeldung_id][gemeinde_2]; 
		$email = $anmeldungen[$anmeldung_id][email]; 
		
		$zgv_b = $anmeldungen[$anmeldung_id][zgv_b]; 
		$zgv_m = $anmeldungen[$anmeldung_id][zgv_m]; 
		$zgv_b_ort = $anmeldungen[$anmeldung_id][zgv_b_ort]; 
		$zgv_m_ort = $anmeldungen[$anmeldung_id][zgv_m_ort]; 
		$reife_englisch = $anmeldungen[$anmeldung_id][reife_englisch]; 
		$anmerkung = $anmeldungen[$anmeldung_id][anmerkung]; 
		//Geburtsdatum
		$geburtsdatum = $anmeldungen[$anmeldung_id][geburtsdatum]; 
		$telefon = $anmeldungen[$anmeldung_id][telefon]; 
		//INFO: Muss jedes Semester manuell angepasst werden!!!
		$semester = $anmeldungen[$anmeldung_id][semester];
		$lebenslauf = $anmeldungen[$anmeldung_id][lebenslauf];
		
		$studiengang_1 = $anmeldungen[$anmeldung_id][studiengang_1];
		if (!isset($studiengang_1))
		{
			$studiengang_1 = 0;
		}
		
		$studiengang_2 = $anmeldungen[$anmeldung_id][studiengang_2];
		if (!isset($studiengang_2))
		{
			$studiengang_2 = 0;
		}
		
		$studiengang_3 = $anmeldungen[$anmeldung_id][studiengang_3];
		if (!isset($studiengang_3))
		{
			$studiengang_3 = 0;
		}
		
		$studiengang_4 = $anmeldungen[$anmeldung_id][studiengang_4];
		if (!isset($studiengang_4))
		{
			$studiengang_4 = 0;
		}
		
		$vollzeit_1 = $anmeldungen[$anmeldung_id][vollzeit_1];
		if (!isset($vollzeit_1))
		{
			$vollzeit_1 = 'f';
		}
		$vollzeit_2 = $anmeldungen[$anmeldung_id][vollzeit_2];
		if (!isset($vollzeit_2))
		{
			$vollzeit_2 = 'f';
		}
		$vollzeit_3 = $anmeldungen[$anmeldung_id][vollzeit_3];
		if (!isset($vollzeit_3))
		{
			$vollzeit_3 = 'f';
		}
		$vollzeit_4 = $anmeldungen[$anmeldung_id][vollzeit_4];
		if (!isset($vollzeit_4))
		{
			$vollzeit_4 = 'f';
		}
		
		$zgv_d = $anmeldungen[$anmeldung_id][zgv_d];
		$zgv_d_ort = $anmeldungen[$anmeldung_id][zgv_d_ort];
		$zeugnis = $anmeldungen[$anmeldung_id][zeugnis];
	
		
		echo $query_insert_neue_anmeldung =
			"INSERT INTO public.tbl_test_anmeldung
			(anmeldung_id, anrede, titel_pre, titel_post, zuname, vorname, vornamen, geburtsort, geburtsnation, svnr_anmeldung, staatsbuergerschaft, 
			muttersprache, straße, plz, ort, gemeinde, hauptwohnsitz_ungleich_zustelladresse, straße_2, plz_2, ort_2, gemeinde_2, email, 
			zgv_b, zgv_m, zgv_b_ort, zgv_m_ort, reife_englisch, anmerkung, geburtsdatum, telefon, semester, lebenslauf, 
			studiengang_1, studiengang_2, studiengang_3, studiengang_4, vollzeit_1, vollzeit_2, vollzeit_3, vollzeit_4, zgv_d, zgv_d_ort, zeugnis, aut_svnr)
			VALUES 
			('$anmeldung_id', '$anrede', '$titel_pre', '$titel_post', '$zuname', '$vorname', '$vornamen', '$geburtsort', '$geburtsnation', '$svnr_anmeldung', '$staatsbuergerschaft', 
			'$muttersprache', '$straße', '$plz', '$ort', '$gemeinde', '$hauptwohnsitz_ungleich_zustelladresse', '$straße_2', '$plz_2', '$ort_2', '$gemeinde_2', '$email', 
			'$zgv_b', '$zgv_m', '$zgv_b_ort', '$zgv_m_ort', '$reife_englisch', '$anmerkung', '$geburtsdatum', '$telefon', '$semester', '$lebenslauf',
			'$studiengang_1', '$studiengang_2', '$studiengang_3', '$studiengang_4', '$vollzeit_1', '$vollzeit_2', '$vollzeit_3', '$vollzeit_4', '$zgv_d', '$zgv_d_ort', '$zeugnis', '$aut_svnr')
			";

		$result_insert_neue_anmeldung = pg_query($query_insert_neue_anmeldung);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_insert_neue_anmeldung) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage fehlgeschlagen (neue Anmeldung): " . pg_last_error());
		}
		
		//TODO: Felder Transferdatum in Contemas-DB für aktuelle Anmeldung befüllen
		echo "Schreibe Transferdatum in Contemas DB..." . "<br>";
		
		$transfer_timestamp = date('Y-m-d h:i:s');

		$query_set_transferdatum_contemas = 
			"UPDATE tx_powermail_domain_model_answers SET transferdatum = '$transfer_timestamp' WHERE mail = $anmeldung_id";

		$result_set_transferdatum_contemas = mysql_query($query_set_transferdatum_contemas);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_set_transferdatum_contemas) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Update Transferdatum in Contemas DB fehlgeschlagen: " . mysql_error());
		}
		
		//Erhöht Counter
		$anmeldung_id = next($anmeldungen_keys);
		
	}
	
	pg_close($dbconn);
	mysql_close($link);

	//END CONTEMAS DB ABFRAGE
	
		

	#Datenbankverbindung - INTERN
	$dbconn = pg_connect("host=192.168.9.12 dbname=fhcomplete user=akoller password=taruzy00a2#");
	
	//Eintrag in Logfile bei Fehler
	if (!$dbconn) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Interner Verbindungsaufbau fehlgeschlagen: " . pg_last_error());
	}
	
	# TODO:
	# - Check auf SVNR Vor und Zuname -> Nur wenn noch kein Eintrag in der Tabelle public.tbl_test_person besteht, darf auch ein neuer Eintrag gemacht werden
	# 	Falls schon eine Person besteht, dann -> nur public.tbl_test_preinteressent und public.tbl_test_preinteressentstudiengang beschreiben
	# 	(Kann eine Person zwei Status haben? Z. B. Absolvent und Interessent?)
	
	# - LOG-File und dazugehörige Einträge generieren (Datum - Person - Status (erfolgreich eingefügt, fehlgeschlagen etc.)
	
	# - Mechanismus einbauen, der nur dann schreibt, wenn in alle Tabellen geschrieben werden kann, ansonst schreibt er nur einen Log-Eintrag mit Fehler ...
	
	//echo "Beginne Kopiervorgang in andere Tabellen..."; echo "<br>";


	# --- BEGINN PERSON --- #
	
	// Prüfung ob Person bereits vorhanden - falls ja, dann soll keine weitere Person, Adresse, Kontakt angelegt werden.
	// Dokument soll überschrieben werden -> DMS, Akte und DMS Version wird neu verknüpft
	$query_felder_test_anmeldung = 
		"SELECT * FROM public.tbl_test_anmeldung WHERE transfer_datum IS NULL";
	
	$result_felder_test_anmedlung = pg_query($query_felder_test_anmeldung);
	
	//Eintrag in Logfile bei Fehler
	if (!$result_felder_test_anmedlung) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage Anmeldung Person fehlgeschlagen: " . pg_last_error());
	}
	
	//Arrays mit SVNRn - für Vermeidung von Doppeleinträgen in den Tabellen person, kontakt und adresse
	$svnr_array_person = array();
	$svnr_array_kontakt = array();
	$svnr_array_adresse = array();
	
	//Arrays mit String bestehend aus Vorname, Zuname und Geburtsdatum
	$kombination_array_person = array();
	$kombination_array_kontakt = array();
	$kombination_array_adresse = array();
	
	while ($line = pg_fetch_array($result_felder_test_anmedlung, NULL, PGSQL_ASSOC))
	{
		$svnr_anmeldung = $line['svnr_anmeldung']; 
		
		$vorname = $line['vorname']; 
		$zuname = $line['zuname']; 
		$gebdatum = $line['geburtsdatum']; 
		
		//SVNR
		$query_svnr_test_person = 
		"SELECT svnr FROM public.tbl_test_person WHERE svnr = '$svnr_anmeldung'";
	
		$result_svnr_test_person = pg_query($query_svnr_test_person);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_svnr_test_person) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_svnr_test_person fehlgeschlagen: " . pg_last_error());
		}
		
		while ($line = pg_fetch_array($result_svnr_test_person, NULL, PGSQL_ASSOC))
		{
			if (!is_null($line['svnr']))
			{
				//SVNR zu Arrays hinzufügen
				$svnr_array_person[] = $line['svnr'];
				$svnr_array_adresse[] = $line['svnr'];
				$svnr_array_kontakt[] = $line['svnr'];
			}
		}
		
		//Kombination
		$query_kombination_test_person = 
			"SELECT vorname, nachname, gebdatum FROM public.tbl_test_person WHERE vorname = '$vorname' AND nachname = '$zuname' AND gebdatum = '$gebdatum'";
	
		$result_kombination_test_person = pg_query($query_kombination_test_person);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_kombination_test_person) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_kombination_test_person fehlgeschlagen: " . pg_last_error());
		}
		
		while ($line = pg_fetch_array($result_kombination_test_person, NULL, PGSQL_ASSOC))
		{
			if (!is_null($line['vorname']) && !is_null($line['nachname']) && !is_null($line['gebdatum']))
			{
				$kombination = $line['vorname'].$line['nachname'].$line['gebdatum'];

				//Kombination zu Arrays hinzufügen
				$kombination_array_person[] = $kombination;
				$kombination_array_kontakt[] = $kombination;
				$kombination_array_adresse[] = $kombination;
			}
		}
	}
	
	$query_felder_test_anmeldung = 
		"SELECT * FROM public.tbl_test_anmeldung WHERE transfer_datum IS NULL";
	
	$result_felder_test_anmedlung = pg_query($query_felder_test_anmeldung);
	
	//Eintrag in Logfile bei Fehler
	if (!$result_felder_test_anmedlung) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage result_felder_test_anmedlung fehlgeschlagen: " . pg_last_error());
	}
	
	while ($line = pg_fetch_array($result_felder_test_anmedlung, NULL, PGSQL_ASSOC))
	{
		//Wenn die SVNR ODER die Kombination aus Vornamen, Nachnamen und Geburtsdatum des PreInteressenten bereits bei einer Person existiert, so soll keine weitere Person angelegt werden
		
		$kombination = $line['vorname'].$line['zuname'].$line['geburtsdatum'];
		
		if (in_array($line['svnr_anmeldung'], $svnr_array_person) || in_array($kombination, $kombination_array_person))
		{
			#do nothing
		}
		else
		{
			$aut_svnr = $line['aut_svnr'];
			if ($aut_svnr == 't')
			{
				$svnr_anmeldung = $line['svnr_anmeldung'];
			}
			else if ($aut_svnr == 'f')
			{
				$svnr_anmeldung = NULL;
			}
		
			$staatsbuergerschaft = $line['staatsbuergerschaft']; 
			$geburtsnation = $line['geburtsnation']; 
			$muttersprache = $line['muttersprache']; 
			$anrede = $line['anrede']; 
		
			$insertvon = 'cronjob';
			
			$titel_post = $line['titel_post']; 
			if ($titel_post == '')
			{
				$titel_post = "NULL";
			}
			
			$titel_pre = $line['titel_pre'];
			if ($titel_pre == '')
			{
				$titel_pre = "NULL";
			}
			$zuname = $line['zuname']; 
			$vorname = $line['vorname']; 
			
			$vornamen = $line['vornamen']; 
			if ($vornamen == '')
			{
				$vornamen = "NULL";
			}
			
			$geburtsdatum = $line['geburtsdatum']; 
			$geburtsort = $line['geburtsort']; 
					
			$anrede = $line['anrede'];
			if ($anrede == "Herr")
			{
				$geschlecht = "m"; 
			}
			else if ($anrede == "Frau")
			{
				$geschlecht = "w";
			}
			else
			{
				$geschlecht = "NULL";
			}
			
			$aktiv = 'true';
			$insertvon = 'cronjob';
			
			$zugangscode = uniqid();
			
			$anmeldung_id = $line['anmeldung_id'];
						
			$query_insert_test_person =
				"INSERT INTO public.tbl_test_person
				(staatsbuergerschaft, geburtsnation, sprache, anrede, titelpost, titelpre, nachname, vorname, vornamen, gebdatum, gebort, svnr, geschlecht, aktiv, insertvon, zugangscode, anmeldung_id)
				VALUES 
				('$staatsbuergerschaft', '$geburtsnation', '$muttersprache', '$anrede', '$titel_post', '$titel_pre', '$zuname', '$vorname', '$vornamen', '$geburtsdatum', '$geburtsort', '$svnr_anmeldung', '$geschlecht', '$aktiv', '$insertvon', '$zugangscode', '$anmeldung_id')
				";	
			
			$result_insert_test_person = pg_query($query_insert_test_person);
			
			//Eintrag in Logfile bei Fehler
			if (!$result_insert_test_person) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage result_insert_test_person fehlgeschlagen: " . pg_last_error());
			}
			
			//SVNR der gerade hinzugefügten Person in das SVNR-Array schreiben, damit keine doppelte Erfassung möglich ist
			$svnr_array_person[] = $line['svnr_anmeldung'];
			
		}
			
	}	
	# --- ENDE PERSON --- #



	# --- BEGINN ADRESSE --- #
	$query_felder_test_anmeldung = 
		"SELECT * FROM public.tbl_test_anmeldung WHERE transfer_datum IS NULL";
		
	$result_felder_test_anmedlung = pg_query($query_felder_test_anmeldung);
	
	//Eintrag in Logfile bei Fehler
	if (!$result_felder_test_anmedlung) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage result_felder_test_anmedlung fehlgeschlagen: " . pg_last_error());
	}
	
	while ($line = pg_fetch_array($result_felder_test_anmedlung, NULL, PGSQL_ASSOC))
	{
	
		$kombination = $line['vorname'].$line['zuname'].$line['geburtsdatum'];
	
		//Wenn die SVNR des PreInteressenten bereits bei einer Person existiert, so soll keine weitere Adresse angelegt werden
		if (in_array($line['svnr_anmeldung'], $svnr_array_adresse) || in_array($kombination, $kombination_array_person))
		{
			#do nothing
		}
		else
		{
			//Aktuelle SVNR in Array kopieren
			$svnr_array_adresse[] = $line['svnr_anmeldung'];
			
			$anmeldung_id = $line['anmeldung_id'];
			
			$strasse = $line['straße']; 
			$plz = $line['plz']; 
			$ort = $line['ort']; 
			$gemeinde = $line['gemeinde']; 
			
			$strasse_2 = $line['straße_2']; 
			$plz_2 = $line['plz_2']; 
			$ort_2 = $line['ort_2']; 
			$gemeinde_2 = $line['gemeinde_2']; 
			
			$nation = $line['geburtsnation']; 

			$hauptwohnsitz_ungleich_zustelladresse = $line['hauptwohnsitz_ungleich_zustelladresse']; 
			
			#Da die person_id von der Datenbank generiert wird, muss sie nach dem Eintrag der Person, aus der Datenbank ausgelesen werden. 
			$query_find_person_id = 
				"SELECT person_id 
					FROM public.tbl_test_person 
					WHERE anmeldung_id = '$anmeldung_id'"; 
					
			$result_find_person_id = pg_query($query_find_person_id);
			
			//Eintrag in Logfile bei Fehler
			if (!$result_find_person_id) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage result_find_person_id fehlgeschlagen: " . pg_last_error());
			}
			
			while ($line = pg_fetch_array($result_find_person_id, NULL, PGSQL_ASSOC)) 
			{
				$person_id = $line['person_id']; 
			}		
			# WENN DER HAUPTWOHNSITZ UNGLEICH DER ZUSTELLADRESSE -> TRUE (ZWEI QUERIES NOTWENDIG):
			if ($hauptwohnsitz_ungleich_zustelladresse == 't')
			{
				$query_insert_test_adresse_1 =
					"INSERT INTO public.tbl_test_adresse
					(person_id, strasse, plz, ort, gemeinde, nation, typ, heimatadresse, zustelladresse, insertvon)
					VALUES 
					('$person_id', '$strasse', '$plz', '$ort', '$gemeinde', '$nation', 'h', 'TRUE', 'FALSE', 'cronjob')
					";

				$result_insert_test_adresse_1 = pg_query($query_insert_test_adresse_1);
			
				//Eintrag in Logfile bei Fehler
				if (!$result_insert_test_adresse_1) 
				{
					$date = date('Y-m-d h:i:s');
					createLog($date . " - Abfrage result_insert_test_adresse_1 fehlgeschlagen: " . pg_last_error());
				}
			
				$query_insert_test_adresse_2 =
					"INSERT INTO public.tbl_test_adresse
					(person_id, strasse, plz, ort, gemeinde, nation, typ, heimatadresse, zustelladresse, insertvon)
					VALUES 
					('$person_id', '$strasse_2', '$plz_2', '$ort_2', '$gemeinde_2', '$nation', 'n', 'FALSE', 'TRUE', 'cronjob')
					";

				$result_insert_test_adresse_2 = pg_query($query_insert_test_adresse_2);
				
				//Eintrag in Logfile bei Fehler
				if (!$result_insert_test_adresse_2) 
				{
					$date = date('Y-m-d h:i:s');
					createLog($date . " - Abfrage result_insert_test_adresse_2 fehlgeschlagen: " . pg_last_error());
				}
				
			}
			
			# WENN DER HAUPTWOHNSITZ UNGLEICH DER ZUSTELLADRESSE -> FALSE (NUR EIN QUERY NOTWENDIG):
			else if ($hauptwohnsitz_ungleich_zustelladresse == 'f')
			{
				$query_insert_test_adresse_0 =
					"INSERT INTO public.tbl_test_adresse
					(person_id, strasse, plz, ort, gemeinde, nation, typ, heimatadresse, zustelladresse, insertvon)
					VALUES 
					('$person_id', '$strasse', '$plz', '$ort', '$gemeinde', '$nation', 'h', 'TRUE', 'TRUE', 'cronjob')
					";

				#Befuellen der Tabelle Adresse
				$result_insert_test_adresse_0 = pg_query($query_insert_test_adresse_0);
				
				//Eintrag in Logfile bei Fehler
				if (!$result_insert_test_adresse_0) 
				{
					$date = date('Y-m-d h:i:s');
					createLog($date . " - Abfrage result_insert_test_adresse_0 fehlgeschlagen: " . pg_last_error());
				}
			}
					
		}
		
	}
	# --- ENDE ADRESSE --- #

	

	# --- BEGINN KONTAKT --- #
	$query_felder_test_anmeldung = 
		"SELECT * FROM public.tbl_test_anmeldung WHERE transfer_datum IS NULL";
		
	$result_felder_test_anmedlung = pg_query($query_felder_test_anmeldung);
	
	//Eintrag in Logfile bei Fehler
	if (!$result_felder_test_anmedlung) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage result_felder_test_anmedlung fehlgeschlagen: " . pg_last_error());
	}
	
	while ($line = pg_fetch_array($result_felder_test_anmedlung, NULL, PGSQL_ASSOC))
	{	
	
		$kombination = $line['vorname'].$line['zuname'].$line['geburtsdatum'];
	
		//Wenn die SVNR des PreInteressenten bereits bei einer Person existiert, so soll keine weitere Person angelegt werden
		if (in_array($line['svnr_anmeldung'], $svnr_array_kontakt)|| in_array($kombination, $kombination_array_person))
		{
			#do nothing
		}
		else
		{
			//Aktuelle SVNR in Array kopieren
			$svnr_array_kontakt[] = $line['svnr_anmeldung'];
			
			$anmeldung_id = $line['anmeldung_id'];
		
			$kontakt_email = $line['email']; 
			
			$kontakt_telefon = $line['telefon']; 
			
			$kontakttyp_email = "email";
			
			$kontakttyp_telefon = "telefon";
			
			$zustellung = TRUE;
			$insertvon = "cronjob";
			
			#Da die person_id von der Datenbank generiert wird, muss sie nach dem Eintrag der Person, aus der Datenbank ausgelesen werden.
			$query_find_person_id = 
				"SELECT person_id 
					FROM public.tbl_test_person
					WHERE anmeldung_id = '$anmeldung_id'";
					
			$result_find_person_id = pg_query($query_find_person_id);
			
			//Eintrag in Logfile bei Fehler
			if (!$result_find_person_id) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage result_find_person_id fehlgeschlagen: " . pg_last_error());
			}
			
			while ($line = pg_fetch_array($result_find_person_id, NULL, PGSQL_ASSOC))
			{
				$person_id = $line['person_id'];
			}	
			
			#Query für den EMail-Kontakt
			$query_insert_test_kontakt_email =
				"INSERT INTO public.tbl_test_kontakt
				(person_id, kontakttyp, kontakt, zustellung, insertvon)
				VALUES 
				('$person_id', '$kontakttyp_email', '$kontakt_email', '$zustellung', '$insertvon')
				";

			$result_insert_test_kontakt_email = pg_query($query_insert_test_kontakt_email);
			
			//Eintrag in Logfile bei Fehler
			if (!$result_insert_test_kontakt_email) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage result_insert_test_kontakt_email fehlgeschlagen: " . pg_last_error());
			}
			
			
			
			#Query für den Telefon-Kontakt
			$query_insert_test_kontakt_telefon =
				"INSERT INTO public.tbl_test_kontakt
				(person_id, kontakttyp, kontakt, zustellung, insertvon)
				VALUES 
				('$person_id', '$kontakttyp_telefon', '$kontakt_telefon', '$zustellung', '$insertvon')
				";

			$result_insert_test_kontakt_telefon = pg_query($query_insert_test_kontakt_telefon);
			
			//Eintrag in Logfile bei Fehler
			if (!$result_insert_test_kontakt_telefon) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage result_insert_test_kontakt_telefon fehlgeschlagen: " . pg_last_error());
			}
		}		
	}
	
	# --- ENDE KONTAKT --- #

	
	
	# --- BEGINN PREINTERESSENT --- #
	$query_felder_test_anmeldung = 
		"SELECT * FROM public.tbl_test_anmeldung WHERE transfer_datum IS NULL";
		
	$result_felder_test_anmeldung = pg_query($query_felder_test_anmeldung);
	
	//Eintrag in Logfile bei Fehler
	if (!$result_felder_test_anmeldung) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage result_felder_test_anmeldung fehlgeschlagen: " . pg_last_error());
	}

	while ($line = pg_fetch_array($result_felder_test_anmeldung, NULL, PGSQL_ASSOC))
	{	

		$anmeldung_id = $line['anmeldung_id'];
		
		$vorname = $line['vorname'];
		$zuname = $line['zuname'];
		$geburtsdatum = $line['geburtsdatum'];
		
		$studiensemester_kurzbz = $line['semester'];
		$aufmerksamdurch_kurzbz = "k.A.";
		$erfassungsdatum = date('Y-m-d');
		$einverstaendnis = "FALSE";
		$anmerkung = $line['anmerkung'];
		$insertvon = "cronjob"; "<br>";
		$maturajahr = $line['reifepruef_datum'];
		$zgv_code = $line['zgv_b'];
		$zgvort = $line['zgv_b_ort'];
		echo $zgvmas_code = $line['zgv_m'];
		$zgvmaort = $line['zgv_m_ort'];
		$zgvdoktor_code = $line['zgv_d'];
		$zgvdoktorort = $line['zgv_d_ort'];
		
		$svnr_anmeldung = $line['svnr_anmeldung'];
				
		
		#Da die person_id von der Datenbank generiert wird, muss sie nach dem Eintrag der Person, aus der Datenbank ausgelesen werden.
		$query_find_person_id = 
			"SELECT person_id 
				FROM public.tbl_test_person
				WHERE anmeldung_id = '$anmeldung_id'";

		$result_find_person_id = pg_query($query_find_person_id);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_find_person_id) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_find_person_id fehlgeschlagen: " . pg_last_error());
		}
		
		if (!is_array($result_find_person_id))
		{
			$query_find_person_id = 
				"SELECT person_id 
					FROM public.tbl_test_person
					WHERE vorname = '$vorname'
					AND nachname = '$zuname'
					AND gebdatum = '$geburtsdatum'";
					
			$result_find_person_id = pg_query($query_find_person_id);

			//Eintrag in Logfile bei Fehler
			if (!$result_find_person_id) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage result_find_person_id fehlgeschlagen: " . pg_last_error());
			}			
		}
		
		
		while ($line = pg_fetch_array($result_find_person_id, NULL, PGSQL_ASSOC))
		{
			
			echo "--> ";
			echo $person_id = $line['person_id'];
			echo " <--";
			
			if ($person_id == NULL || $person_id == "" || $person_id == " ")
			{
				echo "person_id == NULL";
			}
		}
		
		#INSERT
		//Vorbereitungslehrgang und Bachelor
		if ($zgv_code != NULL && $zgv_code != "" && $zgv_code != " ")
		{
			$query_insert_test_preinteressent =
				"INSERT INTO public.tbl_test_preinteressent
				(person_id, studiensemester_kurzbz, aufmerksamdurch_kurzbz, erfassungsdatum, einverstaendnis, anmerkung, insertvon, zgv_code, zgvort, anmeldung_id)
				VALUES 
				('$person_id', '$studiensemester_kurzbz', '$aufmerksamdurch_kurzbz', '$erfassungsdatum', '$einverstaendnis', '$anmerkung', '$insertvon', '$zgv_code', '$zgvort', '$anmeldung_id')";
			
			$result_insert_test_preinteressent = pg_query($query_insert_test_preinteressent);
			
			//Eintrag in Logfile bei Fehler
			if (!$result_insert_test_preinteressent) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage result_insert_test_preinteressent fehlgeschlagen: " . pg_last_error());
			}	
		}
		
		//Master
		else if ($zgvmas_code != NULL && $zgvmas_code != "" && $zgvmas_code != " ")
		{
			$query_insert_test_preinteressent =
				"INSERT INTO public.tbl_test_preinteressent
				(person_id, studiensemester_kurzbz, aufmerksamdurch_kurzbz, erfassungsdatum, einverstaendnis, anmerkung, insertvon, zgvmas_code, zgvmaort, anmeldung_id)
				VALUES 
				('$person_id', '$studiensemester_kurzbz', '$aufmerksamdurch_kurzbz', '$erfassungsdatum', '$einverstaendnis', '$anmerkung', '$insertvon', '$zgvmas_code', '$zgvmaort', '$anmeldung_id')";
				
			$result_insert_test_preinteressent_master = pg_query($query_insert_test_preinteressent);
			
			//Eintrag in Logfile bei Fehler
			if (!$result_insert_test_preinteressent_master) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage result_insert_test_preinteressent_master fehlgeschlagen: " . pg_last_error());
			}	
			
		}
		
		//PhD
		else if ($zgvdoktor_code != NULL && $zgvdoktor_code != "" && $zgvdoktor_code != " ")
		{
			$query_insert_test_preinteressent =
				"INSERT INTO public.tbl_test_preinteressent
				(person_id, studiensemester_kurzbz, aufmerksamdurch_kurzbz, erfassungsdatum, einverstaendnis, anmerkung, insertvon, zgvdoktor_code, zgvdoktorort, anmeldung_id)
				VALUES 
				('$person_id', '$studiensemester_kurzbz', '$aufmerksamdurch_kurzbz', '$erfassungsdatum', '$einverstaendnis', '$anmerkung', '$insertvon', '$zgvdoktor_code', '$zgvdoktorort', '$anmeldung_id')";
				
			$result_insert_test_preinteressent_doktor = pg_query($query_insert_test_preinteressent);
			
			//Eintrag in Logfile bei Fehler
			if (!$result_insert_test_preinteressent_doktor) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage result_insert_test_preinteressent_doktor fehlgeschlagen: " . pg_last_error());
			}
		}
	
	
	
	}
	# --- ENDE PREINTERESSENT --- #



	# --- BEGINN PREINTERESSENTSTUDIENGANG --- #
	$query_felder_test_anmeldung = 
		"SELECT * FROM public.tbl_test_anmeldung WHERE transfer_datum IS NULL";
		
	$result_felder_test_anmedlung = pg_query($query_felder_test_anmeldung);
	
	//Eintrag in Logfile bei Fehler
	if (!$result_felder_test_anmedlung) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage result_felder_test_anmedlung fehlgeschlagen: " . pg_last_error());
	}
	
	while ($line = pg_fetch_array($result_felder_test_anmedlung, NULL, PGSQL_ASSOC))
	{	
		$anmeldung_id = $line['anmeldung_id'];
	
		if ($line['studiengang_1'] != 0)
		{
			$studiengang_1 = $line['studiengang_1'];
			
			// Wenn Vollzeit == true, dann orgform_kurzbz = VZ, wenn == false, dann = BB
			$vollzeit_1 = $line['vollzeit_1'];
			
			if ($vollzeit_1 == "t")
			{
				$orgform_kurzbz_1 = "VZ";
			}
			else if ($vollzeit_1 == "f")
			{
				$orgform_kurzbz_1 = "BB";
			}
		}
		else if ($line['studiengang_1'] == 0)
		{
			$studiengang_1 = NULL;
			$vollzeit_1 = NULL;
		}
		
		// Falls sich Interessent für mehrere Studiengänge bewirbt
		if ($line['studiengang_2'] != 0)
		{
			$studiengang_2 = $line['studiengang_2'];

			$vollzeit_2 = $line['vollzeit_2'];
			
			if ($vollzeit_2 == "t")
			{
				$orgform_kurzbz_2 = "VZ";
			}
			else if ($vollzeit_2 == "f")
			{
				$orgform_kurzbz_2 = "BB";
			}
		}
		else if ($line['studiengang_2'] == 0)
		{
			$studiengang_2 = NULL;
			$vollzeit_2 = NULL;
		}
		
		if ($line['studiengang_3'] != 0)
		{
			$studiengang_3 = $line['studiengang_3'];
			
			$vollzeit_3 = $line['vollzeit_3'];
			
			if ($vollzeit_3 == "t")
			{
				$orgform_kurzbz_3 = "VZ";
			}
			else if ($vollzeit_3 == "f")
			{
				$orgform_kurzbz_3 = "BB";
			}
		}	
		else if ($line['studiengang_3'] == 0)
		{
			$studiengang_3 = NULL;
			$vollzeit_3 = NULL;
		}
		
		if ($line['studiengang_4'] != 0)
		{
			$studiengang_4 = $line['studiengang_4'];
			
			$vollzeit_4 = $line['vollzeit_4'];
			
			if ($vollzeit_4 == "t")
			{
				$orgform_kurzbz_4 = "VZ";
			}
			else if ($vollzeit_4 == "f")
			{
				$orgform_kurzbz_4 = "BB";
			}
		}
		else if ($line['studiengang_4'] == 0)
		{
			$studiengang_4 = NULL;
			$vollzeit_4 = NULL;
		}
						
		#Da die preinteressent_id von der Datenbank generiert wird, muss sie nach dem Eintrag des PreInteressenten, aus der Datenbank ausgelesen werden.
		$query_find_preinteressent_id = 
			"SELECT preinteressent_id
				FROM public.tbl_test_preinteressent
				WHERE anmeldung_id = '$anmeldung_id'";
				
		$result_find_preinteressent_id = pg_query($query_find_preinteressent_id);

		//Eintrag in Logfile bei Fehler
		if (!$result_find_preinteressent_id) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_find_preinteressent_id fehlgeschlagen: " . pg_last_error());
		}
		
		while ($line = pg_fetch_array($result_find_preinteressent_id, NULL, PGSQL_ASSOC))
		{
			$preinteressent_id = $line['preinteressent_id'];
		}
		
		$prioritaet = "1";
		# Freigabe, Insert und Updatedatum werden in der Test-DB-Tabelle durch now() gesetzt. Durch dieses Skript werden alle drei Aktionen quasi 
		# zum gleichen Zeitpunkt durchgeführt, dass Übernahmedatum wird dann gesetzt, wenn der PreInteressent im FAS übernommen wird.
		$insertvon = 'cronjob';
		$updatevon = 'cronjob';

		
		$query_insert_test_preinteressentstudiengang =
				"INSERT INTO public.tbl_test_preinteressentstudiengang
				(studiengang_kz, preinteressent_id, prioritaet, insertvon, updatevon, orgform_kurzbz)
				VALUES 
				('$studiengang_1', '$preinteressent_id', $prioritaet, '$insertvon', '$updatevon', '$orgform_kurzbz_1')";
					
		$preintstudiengang = pg_query($query_insert_test_preinteressentstudiengang);

		//Eintrag in Logfile bei Fehler
		if (!$preintstudiengang) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage preintstudiengang fehlgeschlagen: " . pg_last_error());
		}
		
		
		if (!is_null($studiengang_2))
		{
			$query_insert_test_preinteressentstudiengang =
				"INSERT INTO public.tbl_test_preinteressentstudiengang
				(studiengang_kz, preinteressent_id, prioritaet, insertvon, updatevon, orgform_kurzbz)
				VALUES 
				('$studiengang_2', '$preinteressent_id', $prioritaet, '$insertvon', '$updatevon', '$orgform_kurzbz_2')";
				
			$preintstudiengang = pg_query($query_insert_test_preinteressentstudiengang);
		
			//Eintrag in Logfile bei Fehler
			if (!$preintstudiengang) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage preintstudiengang fehlgeschlagen: " . pg_last_error());
			}
		}
		
		if (!is_null($studiengang_3))
		{
			$query_insert_test_preinteressentstudiengang =
				"INSERT INTO public.tbl_test_preinteressentstudiengang
				(studiengang_kz, preinteressent_id, prioritaet, insertvon, updatevon, orgform_kurzbz)
				VALUES 
				('$studiengang_3', '$preinteressent_id', $prioritaet, '$insertvon', '$updatevon', '$orgform_kurzbz_3')";
				
			$preintstudiengang = pg_query($query_insert_test_preinteressentstudiengang);
			
			//Eintrag in Logfile bei Fehler
			if (!$preintstudiengang) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage preintstudiengang fehlgeschlagen: " . pg_last_error());
			}
		}
		
		if (!is_null($studiengang_4))
		{
			$query_insert_test_preinteressentstudiengang =
				"INSERT INTO public.tbl_test_preinteressentstudiengang
				(studiengang_kz, preinteressent_id, prioritaet, insertvon, updatevon, orgform_kurzbz)
				VALUES 
				('$studiengang_4', '$preinteressent_id', $prioritaet, '$insertvon', '$updatevon', '$orgform_kurzbz_4')";
				
			$preintstudiengang = pg_query($query_insert_test_preinteressentstudiengang);
			
			//Eintrag in Logfile bei Fehler
			if (!$preintstudiengang) 
			{
				$date = date('Y-m-d h:i:s');
				createLog($date . " - Abfrage preintstudiengang fehlgeschlagen: " . pg_last_error());
			}
		}
		
	}
	# --- ENDE PREINTERESSENTSTUDIENGANG --- #
	
	

	
	# --- BEGINN DOKUMENTENUPLOAD --- #
	# Für die Tests wird ein PDF in den Ordner /var/www/vilesci/statistik/tests/controllingboard/test_quellordner gespeichert
	# Der Name des Files wird in der Tabelle tbl_test_anmeldung in der Spalte lebenslauf hinterlegt
	# Der Lebenslauf soll nach der Ausführung des Skripts im Ordner /test_zielordner sein
	
	# Info: Rechte auf den Ordnern (rekursiv) müssen richtig gesetzt sein, damit Kopieren funktioniert
	
	
	# -- LEBENSLAUF -- #
	$query_felder_test_anmeldung = 
		"SELECT * FROM public.tbl_test_anmeldung WHERE transfer_datum IS NULL";
		
	$result_felder_test_anmedlung = pg_query($query_felder_test_anmeldung);
	
	//Eintrag in Logfile bei Fehler
	if (!$result_felder_test_anmedlung) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage result_felder_test_anmedlung fehlgeschlagen: " . pg_last_error());
	}
	
	while ($line = pg_fetch_array($result_felder_test_anmedlung, NULL, PGSQL_ASSOC))
	{	
	
		//echo "Beginne Abschnitt fuer Dokumente"; echo "<br>";
	
		//Lebenslauf
		$anmeldung_id = $line['anmeldung_id'];
		
		$svnr_anmeldung = $line['svnr_anmeldung'];
		
		$lebenslauf = $line['lebenslauf'];	
		
		//TODO: Pfad muss für den Produktivbetrieb angepasst werden. Evtl. auch sonst noch wo -> prüfen.
		$ordner_lebenslauf = "/var/www/vilesci/statistik/tests/controllingboard/test_quellordner/";
		
		$file_lebenslauf = $ordner_lebenslauf.$lebenslauf;
		
		$neuer_unique_dateiname_lebenslauf = uniqid();
		
		$newfile_lebenslauf = $neuer_unique_dateiname_lebenslauf.".pdf";
		
		//TODO: Pfad muss für den Produktivbetrieb angepasst werden. Evtl. auch sonst noch wo -> prüfen.
		$newfile_pfad_lebenslauf = "/var/www/vilesci/statistik/tests/controllingboard/test_zielordner/".$newfile_lebenslauf;
		
		if (!copy($file_lebenslauf, $newfile_pfad_lebenslauf)) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - copy $file schlug fehl...\n");
			//echo "copy $file schlug fehl...\n"; echo "<br>";
		}
		
		
		# INSERT DMS - LEBENSLAUF
		$query_select_test_dms_last_id =
			"SELECT MAX(dms_id) FROM campus.tbl_test_dms";
			
		$result_select_test_dms_last_id = pg_query($query_select_test_dms_last_id);
				
		//Eintrag in Logfile bei Fehler
		if (!$result_select_test_dms_last_id) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_select_test_dms_last_id fehlgeschlagen: " . pg_last_error());
		}
				
				
		while ($line = pg_fetch_array($result_select_test_dms_last_id, NULL, PGSQL_ASSOC))
		{
			$last_dms_id = $line['max']; 
		}
		
		$new_dms_id = $last_dms_id + 1; 

		
		$query_insert_test_dms =
			"INSERT INTO campus.tbl_test_dms
			(dms_id, kategorie_kurzbz)
			VALUES 
			('$new_dms_id', 'Akte')";
				
		$result_insert_test_dms = pg_query($query_insert_test_dms);

		//Eintrag in Logfile bei Fehler
		if (!$result_insert_test_dms) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_insert_test_dms fehlgeschlagen: " . pg_last_error());
		}
		
		
		# INSERT DMS VERSION - LEBENSLAUF
		$dms_id = $new_dms_id;
		$version = "0";
		$filename_lebenslauf = $newfile_lebenslauf;
		$mimetype = "application/pdf";
		$name = $lebenslauf;
		$insertamum = date('Y-m-d h:i:s');
		$insertvon = "cronjob";
		
		$query_insert_test_dms_version =
			"INSERT INTO campus.tbl_test_dms_version
			(dms_id, version, filename, mimetype, name, insertamum, insertvon)
			VALUES 
			('$dms_id', '$version', '$filename_lebenslauf','$mimetype','$name','$insertamum','$insertvon')";
				
		$result_insert_test_dms_version = pg_query($query_insert_test_dms_version);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_insert_test_dms_version) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_insert_test_dms_version fehlgeschlagen: " . pg_last_error());
		}
		
		# INSERT AKTE - LEBENSLAUF
		
		#Da die person_id von der Datenbank generiert wird, muss sie nach dem Eintrag der Person, aus der Datenbank ausgelesen werden.
		$query_find_person_id = 
			"SELECT person_id 
				FROM public.tbl_test_person
				WHERE anmeldung_id = '$anmeldung_id'";

		$result_find_person_id = pg_query($query_find_person_id);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_find_person_id) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_find_person_id fehlgeschlagen: " . pg_last_error());
		}
		
		while ($line = pg_fetch_array($result_find_person_id, NULL, PGSQL_ASSOC))
		{
			$person_id = $line['person_id'];
		}

		$dokument_kurzbz = "Lebenslf";
		$mimetype = "application/pdf";
		$erstelltam = date('Y-m-d');
		$gedruckt = "FALSE";
		$titel = "Lebenslauf.pdf";
		$bezeichnung = $lebenslauf;
		$insertamum = date('Y-m-d h:i:s');
		$insertvon = "cronjob";
		$dms_id;
		$nachgereicht = "FALSE";
		$titel_intern = "Lebenslf";
		
		$query_insert_test_akte =
			"INSERT INTO public.tbl_test_akte
			(person_id, dokument_kurzbz, mimetype, erstelltam, gedruckt, titel, bezeichnung, insertamum, insertvon, dms_id, nachgereicht, titel_intern)
			VALUES 
			('$person_id', '$dokument_kurzbz', '$mimetype', '$erstelltam', '$gedruckt', '$titel', '$bezeichnung', '$insertamum', '$insertvon', '$dms_id', '$nachgereicht', '$titel_intern')";
				
		$result_insert_test_akte = pg_query($query_insert_test_akte);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_insert_test_akte) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_insert_test_akte fehlgeschlagen: " . pg_last_error());
		}
	}	

		
	# -- ZEUGNIS -- #
	$query_felder_test_anmeldung = 
	"SELECT * FROM public.tbl_test_anmeldung WHERE transfer_datum IS NULL";
	
	$result_felder_test_anmedlung = pg_query($query_felder_test_anmeldung);
	
	//Eintrag in Logfile bei Fehler
	if (!$result_felder_test_anmedlung) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage result_felder_test_anmedlung fehlgeschlagen: " . pg_last_error());
	}
	
	while ($line = pg_fetch_array($result_felder_test_anmedlung, NULL, PGSQL_ASSOC))
	{	
		$anmeldung_id = $line['anmeldung_id'];
	
		$svnr_anmeldung = $line['svnr_anmeldung'];
		
		$zeugnis = $line['zeugnis'];	
		
		$ordner_zeugnis = "/var/www/vilesci/statistik/tests/controllingboard/test_quellordner/";
		
		$file_zeugnis = $ordner_zeugnis.$zeugnis;
		
		$neuer_unique_dateiname_zeugnis = uniqid();
		
		$newfile_zeugnis = $neuer_unique_dateiname_zeugnis.".pdf";
			
		$newfile_pfad_zeugnis = "/var/www/vilesci/statistik/tests/controllingboard/test_zielordner/".$newfile_zeugnis;
				
		if (!copy($file_zeugnis, $newfile_pfad_zeugnis)) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - copy $file schlug fehl...\n ");
			//echo "copy $file schlug fehl...\n"; echo "<br>";
		}
		
		# INSERT DMS
		$query_select_test_dms_last_id =
			"SELECT MAX(dms_id) FROM campus.tbl_test_dms";
			
		$result_select_test_dms_last_id = pg_query($query_select_test_dms_last_id);
				
		//Eintrag in Logfile bei Fehler
		if (!$result_select_test_dms_last_id) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_select_test_dms_last_id fehlgeschlagen: " . pg_last_error());
		}
				
		while ($line = pg_fetch_array($result_select_test_dms_last_id, NULL, PGSQL_ASSOC))
		{
			$last_dms_id = $line['max']; 
		}
		
		$new_dms_id = $last_dms_id + 1; 

		
		$query_insert_test_dms =
			"INSERT INTO campus.tbl_test_dms
			(dms_id, kategorie_kurzbz)
			VALUES 
			('$new_dms_id', 'Akte')";
				
		$result_insert_test_dms = pg_query($query_insert_test_dms);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_insert_test_dms) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_insert_test_dms fehlgeschlagen: " . pg_last_error());
		}
		
		
		# INSERT DMS VERSION - ZEUGNIS
		$dms_id = $new_dms_id;
		$version = "0";
		$filename_zeugnis = $newfile_zeugnis;
		$mimetype = "application/pdf";
		$name = $zeugnis;
		$insertamum = date('Y-m-d h:i:s');
		$insertvon = "cronjob";
		
		$query_insert_test_dms_version =
			"INSERT INTO campus.tbl_test_dms_version
			(dms_id, version, filename, mimetype, name, insertamum, insertvon)
			VALUES 
			('$dms_id', '$version', '$filename_zeugnis','$mimetype','$name','$insertamum','$insertvon')";
				
		$result_insert_test_dms_version = pg_query($query_insert_test_dms_version);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_insert_test_dms_version) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_insert_test_dms_version fehlgeschlagen: " . pg_last_error());
		}
		
		# INSERT AKTE - ZEUGNIS
		
		#Da die person_id von der Datenbank generiert wird, muss sie nach dem Eintrag der Person, aus der Datenbank ausgelesen werden.
		$query_find_person_id = 
			"SELECT person_id 
				FROM public.tbl_test_person
				WHERE anmeldung_id = '$anmeldung_id'";

		$result_find_person_id = pg_query($query_find_person_id);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_find_person_id) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_find_person_id fehlgeschlagen: " . pg_last_error());
		}
		
		while ($line = pg_fetch_array($result_find_person_id, NULL, PGSQL_ASSOC))
		{
			$person_id = $line['person_id'];
		}

		$dokument_kurzbz = "Zeugnis";
		$mimetype = "application/pdf";
		$erstelltam = date('Y-m-d');
		$gedruckt = "FALSE";
		$titel = "Zeugnis.pdf";
		$bezeichnung = $zeugnis;
		$insertamum = date('Y-m-d h:i:s');
		$insertvon = "cronjob";
		$dms_id;
		$nachgereicht = "FALSE";
		$titel_intern = "Zeugnis";
		
		$query_insert_test_akte =
			"INSERT INTO public.tbl_test_akte
			(person_id, dokument_kurzbz, mimetype, erstelltam, gedruckt, titel, bezeichnung, insertamum, insertvon, dms_id, nachgereicht, titel_intern)
			VALUES 
			('$person_id', '$dokument_kurzbz', '$mimetype', '$erstelltam', '$gedruckt', '$titel', '$bezeichnung', '$insertamum', '$insertvon', '$dms_id', '$nachgereicht', '$titel_intern')";
				
		$result_insert_test_akte = pg_query($query_insert_test_akte);
		
		//Eintrag in Logfile bei Fehler
		if (!$result_insert_test_akte) 
		{
			$date = date('Y-m-d h:i:s');
			createLog($date . " - Abfrage result_insert_test_akte fehlgeschlagen: " . pg_last_error());
		}
	}
	
	//echo "Vorgang für Dokumente abgeschlossen"; echo "<br>";
	# --- ENDE DOKUMENTENUPLOAD --- #

	
	# --- TRANSFER DATUM IN DB SCHREIBEN --- #
	$datum = date('Y-m-d h:i:s');
	
	$query_update_transferdatum =
		"UPDATE public.tbl_test_anmeldung
		SET transfer_datum = '$datum'
		WHERE transfer_datum IS NULL";

	$result_update_transferdatum = pg_query($query_update_transferdatum);
	
	//Eintrag in Logfile bei Fehler
	if (!$result_update_transferdatum) 
	{
		$date = date('Y-m-d h:i:s');
		createLog($date . " - Abfrage result_update_transferdatum fehlgeschlagen: " . pg_last_error());
	}
	
	# Datenbankverbindung schließen
	pg_close($dbconn);
	
	
	//echo "Kopiervorgang abgeschlossen";
	
	
	createLog("\r\n" . "-------------------------------------------------------------------------- " ." \r\n");
	
	
	//FUNKTIONEN
	
	//Logfile
	function createLog($data)
	{ 
		$file = "errorlog.txt";
		$fh = fopen($file, 'a') or die("can't open file");
		fwrite($fh,$data);
		fclose($fh);
	}


?>

</body>
</html>