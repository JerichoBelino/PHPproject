<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class_home.php';
$get = new db_home(); 

// Check if user is logged in
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $result = $get->get_user_by_id($user_id);
    $username = $result ? $result['username'] : "Guest";
} else {
    $username = "Guest";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loan Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <nav class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="user_home.php">
                <div class="sidebar-brand-text mx-3">Welcome <?php echo htmlspecialchars($username); ?>!</div>
            </a>
            <li class="nav-item active"><a class="nav-link" href="user_home.php"><i class="fas fa-fw fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link" href="user_loan.php"><i class="fas fa-fw fas fa-comment-dollar"></i> Loans</a></li>
            <li class="nav-item"><a class="nav-link" href="user_payment.php"><i class="fas fa-fw fas fa-coins"></i> Payments</a></li>
            <li class="nav-item"><a class="nav-link" href="user_borrower.php"><i class="fas fa-fw fas fa-book"></i> Borrowers</a></li>
        </nav>

        </body>
        </html>