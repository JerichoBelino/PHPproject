<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class_borrower.php';
$borrower = new db_borrower(); 
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
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Log out -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="image/admin_logo.png">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Borrower</h1>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Firstname</th>
                                            <th>Middlename</th>
                                            <th>Lastname</th>
                                            <th>Contact No</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($borrower->display_borrower() as $fetch) { ?>
                                            <tr>
                                                <td><?php echo $fetch['firstname']; ?></td>
                                                <td><?php echo $fetch['middlename']; ?></td>
                                                <td><?php echo $fetch['lastname']; ?></td>
                                                <td><?php echo $fetch['contact_no']; ?></td>
                                                <td><?php echo $fetch['address']; ?></td>
                                                <td><?php echo $fetch['email']; ?></td>
                                                <td>
                                                    <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteborrower<?php echo $fetch['borrower_id']; ?>">Delete</a>
                                                </td>
                                            </tr>
                                            <!-- Delete Borrower -->
                                            <div class="modal fade" id="deleteborrower<?php echo $fetch['borrower_id']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white">System Information</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">Are you sure you want to delete this record?</div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                            <a class="btn btn-danger" href="admin_delete_borrower.php?borrower_id=<?php echo $fetch['borrower_id']; ?>">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">System Information</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="js/sb-admin-2.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [[2, "asc"]]
            });
        });
    </script>
</body>
</html>
