<?php
	date_default_timezone_set("Etc/GMT+8");
	require_once 'session.php';
	require_once 'class.php';
	require_once 'config.php';
	
	$database = new db_connect();
	$db = $database->connect();
	$user = new db_class($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<style>
		input[type=number]::-webkit-inner-spin-button, 
		input[type=number]::-webkit-outer-spin-button{ 
			-webkit-appearance: none; 
		}
	</style>
	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Loan Management System</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
  	<link href="css/sb-admin-2.css" rel="stylesheet">

</head>