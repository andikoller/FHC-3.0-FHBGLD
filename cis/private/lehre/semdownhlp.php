<<<<<<< HEAD
<?php
// Dieses Script verhindert, dass das Dokument inline geoeffnet wird.
=======
<?php
// Dieses Script verhindert, dass das Dokument inline geoeffnet wird.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
// Es erschein automatisch das Download/Speichern Fenster
	if (isset($_GET["format"]) && $_GET["format"] == "doc"){
		$filename= "../../cisdocs/muster_semesterplan.doc";
		$format = "doc";
	}
<<<<<<< HEAD
	else{
    	$filename = "../../cisdocs/muster_semesterplan_index.html";
		$format = "html";    
    }
    $fp = fopen($filename, "rb");
    if ($fp)
    {
    	header("Content-Type: application/html");
		    	
    	header("Content-Disposition: attachment; filename=\"Semesterplan.".$format."\"");
        $buffer = fread ($fp, filesize ($filename));
        echo $buffer;
        fclose($fp);
    }
    else 
    	echo 'Datei wurde nicht gefunden';
    exit();
=======
	else{
    	$filename = "../../cisdocs/muster_semesterplan_index.html";
		$format = "html";    
    }
    $fp = fopen($filename, "rb");
    if ($fp)
    {
    	header("Content-Type: application/html");
		    	
    	header("Content-Disposition: attachment; filename=\"Semesterplan.".$format."\"");
        $buffer = fread ($fp, filesize ($filename));
        echo $buffer;
        fclose($fp);
    }
    else 
    	echo 'Datei wurde nicht gefunden';
    exit();
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
?> 