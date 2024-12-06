<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();
	
	if(ISSET($_REQUEST['borrower_id'])){

		$database = new db_connect();
        $db = $database->connect();
        $user = new db_class($db);

		$borrower_id = $_REQUEST['borrower_id'];
		$user->delete_borrower($borrower_id);
		header('location:user_borrower.php');
	}
?>	