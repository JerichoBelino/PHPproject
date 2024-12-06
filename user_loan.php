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

<body id="page-top">
    <div id="wrapper">

		<nav class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">LOANS</div>
            </a>
			<li class="nav-item"><a class="nav-link" href="user_home.php"><i class="fas fa-fw fa-home"></i> Home</a></li>
			<li class="nav-item"><a class="nav-link" href="user_loan.php"><i class="fas fa-fw fas fa-comment-dollar"></i> Loans</a></li>
			<li class="nav-item"><a class="nav-link" href="user_payment.php"><i class="fas fa-fw fas fa-coins"></i> Payments</a></li>
			<li class="nav-item"><a class="nav-link" href="user_borrower.php"><i class="fas fa-fw fas fa-book"></i> Borrowers</a></li>
		</nav>
 
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
					<!-- Log out -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <img class="img-profile rounded-circle"
                                    src="image/admin_logo.png">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>