<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();
	
	if(ISSET($_POST['save'])){

		$database = new db_connect();
		$db = $database->connect();
		$admin = new db_class($db);

		$ltype_name=$_POST['ltype_name'];
		$ltype_desc=$_POST['ltype_desc'];
		
		$admin->save_ltype($ltype_name,$ltype_desc);
		
		header("location: admin_loan_type.php");
	}
?>