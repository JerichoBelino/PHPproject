<?php
	require_once 'class.php';
	require_once 'config.php';
	session_start();

	if(ISSET($_POST['update'])){

		$database = new db_connect();
		$db = $database->connect();
		$admin = new db_class($db);

		$ltype_id=$_POST['ltype_id'];
		$ltype_name=$_POST['ltype_name'];
		$ltype_desc=$_POST['ltype_desc'];
		$admin->update_ltype($ltype_id,$ltype_name,$ltype_desc);
		echo"<script>alert('Update loan type successfully!')</script>";
		echo"<script>window.location='admin_loan_type.php'</script>";
	}
?>