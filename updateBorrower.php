<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();
	
	if(ISSET($_POST['update'])){

		$database = new db_connect();
        $db = $database->connect();
        $user = new db_class($db);

		$borrower_id=$_POST['borrower_id'];
		$firstname=$_POST['firstname'];
		$middlename=$_POST['middlename'];
		$lastname=$_POST['lastname'];
		$contact_no=$_POST['contact_no'];
		$address=$_POST['address'];
		$email=$_POST['email'];
	
		$user->update_borrower($borrower_id,$firstname,$middlename,$lastname,$contact_no,$address,$email);
		echo"<script>alert('Update Borrower successfully!')</script>";
		echo"<script>window.location='user_borrower.php'</script>";
	}
?>