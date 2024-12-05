<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();
	
	if(ISSET($_REQUEST['lplan_id'])){

		$database = new db_connect();
		$db = $database->connect();
		$admin = new db_class($db);

		$lplan_id = $_REQUEST['lplan_id'];
		$admin->delete_lplan($lplan_id);
		header('location:admin_loan_plan.php');
	}
?>	