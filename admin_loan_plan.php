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
    <link href="css/sb-admin-2.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
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
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Log out -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <img class="img-profile rounded-circle" src="image/admin_profile.svg">
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Loan Plan</h1>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Add/Saave Loan Plan -->
                                    <form method="POST" action="save_lplan.php">
                                        <div class="form-group"><label>Plan(months)</label><input type="number" class="form-control" name="lplan_month" required /></div>
                                        <div class="form-group"><label>Interest</label><div class="input-group"><input type="number" class="form-control" name="lplan_interest" min="0" required /><div class="input-group-prepend"><span class="input-group-text">%</span></div></div></div>
                                        <div class="form-group"><label>Monthly Overdue Penalty</label><div class="input-group"><input type="number" class="form-control" name="lplan_penalty" min="0" required /><div class="input-group-prepend"><span class="input-group-text">%</span></div></div></div>
                                        <button type="submit" class="btn btn-primary btn-block" name="save">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-9 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr><th>Plan(months)</th><th>Interest(%)</th><th>Monthly Overdue Penalty(%)</th><th>Action</th></tr>
                                            </thead>
                                            <tbody>