<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
require_once 'config.php';

$database = new db_connect();
$db = $database->connect();
$admin = new db_class($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loan Management System</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
</head>


<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
            </a>
            <!-- Sidebar --> 
            <li class="nav-item"><a class="nav-link" href="admin_home.php"><i class="fas fa-fw fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_loan.php"><i class="fas fa-fw fas fa-comment-dollar"></i> Loans</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_payment.php"><i class="fas fa-fw fas fa-coins"></i> Payments</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_borrower.php"><i class="fas fa-fw fas fa-book"></i> Borrowers</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_loan_plan.php"><i class="fas fa-fw fa-piggy-bank"></i> Loan Plans</a></li>
            <li class="nav-item active"><a class="nav-link" href="admin_loan_type.php"><i class="fas fa-fw fa-money-check"></i> Loan Types</a></li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Loan Type</h1>
                    </div>
                    <!-- Save Loan Type --> 
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="save_ltype.php">
                                        <div class="form-group"><label>Loan Name</label><input type="text" class="form-control" name="ltype_name" required/></div>
                                        <div class="form-group"><label>Loan Description</label><textarea class="form-control" name="ltype_desc" required style="resize:none;"></textarea></div>
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
                                                <tr>
                                                    <th>Loan Name</th>
                                                    <th>Loan Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <!-- Display Loan Type --> 
                                            <tbody>
                                                <?php
                                                $tbl_ltype = $admin->display_ltype();
                                                foreach ($tbl_ltype as $fetch) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $fetch['ltype_name'] ?></td>
                                                    <td><?php echo $fetch['ltype_desc'] ?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item bg-warning text-white" href="#" data-toggle="modal" data-target="#updateltype<?php echo $fetch['ltype_id'] ?>">Edit</a>
                                                                <a class="dropdown-item bg-danger text-white" href="#" data-toggle="modal" data-target="#deleteltype<?php echo $fetch['ltype_id'] ?>">Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Delete Loan Type -->
                                                <div class="modal fade" id="deleteltype<?php echo $fetch['ltype_id'] ?>" tabindex="-1" aria-hidden="true">
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
                                                                <a class="btn btn-danger" href="delete_ltype.php?ltype_id=<?php echo $fetch['ltype_id'] ?>">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <!-- Update Loan Type -->
                                                <div class="modal fade" id="updateltype<?php echo $fetch['ltype_id'] ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST" action="update_ltype.php">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-warning">
                                                                    <h5 class="modal-title text-white">Edit Loan Type</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Loan Name</label>
                                                                        <input type="text" class="form-control" value="<?php echo $fetch['ltype_name'] ?>" name="ltype_name" required/>
                                                                        <input type="hidden" class="form-control" value="<?php echo $fetch['ltype_id'] ?>" name="ltype_id"/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Loan Description</label>
                                                                        <textarea class="form-control" name="ltype_desc" required style="resize:none;"><?php echo $fetch['ltype_desc'] ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>  
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({"order": [[1, "asc"]]});
        });
    </script>
</body>
</html>
