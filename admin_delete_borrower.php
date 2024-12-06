<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();
	
	if(ISSET($_REQUEST['borrower_id'])){
		$database = new db_connect();
		$db = $database->connect();
		$admin = new db_class($db);

		$borrower_id = $_REQUEST['borrower_id'];
		$admin->delete_borrower($borrower_id);
		header('location:admin_borrower.php');
	}
?>	