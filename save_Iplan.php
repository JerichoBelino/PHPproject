<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();

	if(ISSET($_POST['save'])){

		$database = new db_connect();
		$db = $database->connect();
		$admin = new db_class($db);

		$lplan_month=$_POST['lplan_month'];
		$lplan_interest=$_POST['lplan_interest'];
		$lplan_penalty=$_POST['lplan_penalty'];
		
		$admin->save_lplan($lplan_month,$lplan_interest,$lplan_penalty);
		header("location: admin_loan_plan.php");
	}
?>