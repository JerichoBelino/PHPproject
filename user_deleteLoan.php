<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();
	
	if(ISSET($_REQUEST['loan_id'])){
		$loan_id = $_REQUEST['loan_id'];

		$database = new db_connect();
        $db = $database->connect();
        $user = new db_class($db);

		$user->delete_loan($loan_id);
		header('location:user_loan.php');
	}
?>	