<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();
	
	if(ISSET($_POST['update'])){

		$database = new db_connect();
		$db = $database->connect();
		$admin = new db_class($db);

		$lplan_id=$_POST['lplan_id'];
		$lplan_month=$_POST['lplan_month'];
		$lplan_interest=$_POST['lplan_interest'];
		$lplan_penalty=$_POST['lplan_penalty'];
		$admin->update_lplan($lplan_id,$lplan_month,$lplan_interest,$lplan_penalty);
		echo"<script>alert('Update loan Plan successfully!')</script>";
		echo"<script>window.location='admin_loan_plan.php'</script>";
	}
?>