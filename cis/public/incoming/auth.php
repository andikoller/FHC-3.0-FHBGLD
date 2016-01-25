<<<<<<< HEAD
<?php
	session_cache_limiter('none'); //muss gesetzt werden sonst funktioniert der Download mit IE8 nicht
	session_start();

	if (!isset($_SESSION['incoming/user']) || $_SESSION['incoming/user']=='') 
	{
		$_SESSION['request_uri']=$_SERVER['REQUEST_URI'];
		
		header('Location: index.php');
		exit;
    }
=======
<?php
	session_cache_limiter('none'); //muss gesetzt werden sonst funktioniert der Download mit IE8 nicht
	session_start();

	if (!isset($_SESSION['incoming/user']) || $_SESSION['incoming/user']=='') 
	{
		$_SESSION['request_uri']=$_SERVER['REQUEST_URI'];
		
		header('Location: index.php');
		exit;
    }
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
?>