<?php
	#Security
    if(!defined("OxionUserCP")) exit;

    require_once("Inc/database.php");
    require_once("Inc/functions.php");
	
	#New instance of sqlsrv()
    $db = new sqlsrv();

	#Start session
    session_start();
?>