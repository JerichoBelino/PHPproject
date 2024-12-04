<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
$db = new db_class();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Loan Management System</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <style>
        input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <nav class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_home.html">
                <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
            </a>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="admin_home.php"><i class="fas fa-fw fa-home"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_loan.php"><i class="fas fa-fw fa-comment-dollar"></i> Loans</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_payment.php"><i class="fas fa-fw fa-coins"></i> Payments</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_borrower.php"><i class="fas fa-fw fa-book"></i> Borrowers</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_loan_plan.php"><i class="fas fa-fw fa-piggy-bank"></i> Loan Plans</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_loan_type.php"><i class="fas fa-fw fa-money-check"></i> Loan Types</a></li>
            </ul>
        </nav>