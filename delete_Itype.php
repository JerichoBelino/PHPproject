<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();
	
	if(ISSET($_REQUEST['ltype_id'])){

		$database = new db_connect();
		$db = $database->connect();
		$admin = new db_class($db);

		$ltype_id = $_REQUEST['ltype_id'];
		$admin->delete_ltype($ltype_id);
		header('location:admin_loan_type.php');
	}
?>	