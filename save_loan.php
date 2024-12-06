<?php
	date_default_timezone_set("Etc/GMT+8");
	require_once 'class.php';
	require_once 'config.php';
	session_start();

	if(ISSET($_POST['apply'])){

		$database = new db_connect();
		$db = $database->connect();
		$user = new db_class($db);

		$borrower=$_POST['borrower'];
		$ltype=$_POST['ltype'];
		$lplan=$_POST['lplan'];
		$loan_amount=$_POST['loan_amount'];
		$purpose=$_POST['purpose'];
		$date_created=date("Y-m-d H:i:s");
		
		$user->save_loan($borrower,$ltype,$lplan,$loan_amount,$purpose, $date_created);
		
		header("location: user_loan.php");
	}
?>