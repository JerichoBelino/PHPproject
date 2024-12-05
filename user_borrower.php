<?php
	date_default_timezone_set("Etc/GMT+8");
	require_once 'session.php';
	require_once 'class.php';
	require_once 'config.php';

	$database = new db_connect();
	$db = $database->connect();
	$user = new db_class($db);
	
?>