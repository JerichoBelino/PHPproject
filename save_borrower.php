<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();
	
	if(isset($_POST['save'])){

		$database = new db_connect();
        $db = $database->connect();
        $user = new db_class($db);

		$firstname=$_POST['firstname'];
		$middlename=$_POST['middlename'];
		$lastname=$_POST['lastname'];
		$contact_no=$_POST['contact_no'];
		$address=$_POST['address'];
		$email=$_POST['email'];
	
		$user->save_borrower($firstname,$middlename,$lastname,$contact_no,$address,$email);
		
		header("location: user_borrower.php");
	}
?>