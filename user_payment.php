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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loan Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
</head>
<body id="page-top">

    <div id="wrapper">
        <!-- Sidebar -->
        <nav class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">PAYMENTS</div>
            </a>
            <li class="nav-item"><a class="nav-link" href="user_home.php"><i class="fas fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link" href="user_loan.php"><i class="fas fa-comment-dollar"></i> Loans</a></li>
            <li class="nav-item"><a class="nav-link" href="user_payment.php"><i class="fas fa-coins"></i> Payments</a></li>
            <li class="nav-item"><a class="nav-link" href="user_borrower.php"><i class="fas fa-book"></i> Borrowers</a></li>
        </nav>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                                <img class="img-profile rounded-circle" src="image/admin_profile.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- Page Content -->
                <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Payment List</h1>
                        </div>
                    <button class="btn btn-primary btn-lg mb-3" data-toggle="modal" data-target="#addModal">
                        <i class="fa fa-plus"></i> New Payment
                    </button>
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table table-bordered" id="dataTable" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Loan Ref. No.</th><th>Payee</th><th>Amount</th><th>Penalty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $payments = $db->conn->query("SELECT * FROM `payment` INNER JOIN `loan` ON payment.loan_id=loan.loan_id");
                                        foreach ($payments as $i => $payment) {
                                            echo "<tr>
                                                <td>".($i+1)."</td>
                                                <td>{$payment['ref_no']}</td>
                                                <td>{$payment['payee']}</td>
                                                <td>&#8369; ".number_format($payment['pay_amount'], 2)."</td>
                                                <td>&#8369; ".number_format($payment['penalty'], 2)."</td>
                                            </tr>";
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

    <!-- Add Payment -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <form method="POST" action="save_payment.php">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Payment Form</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <label>Reference No</label>
                        <select name="loan_id" class="form-control ref_no" id="ref_no" required>
                            <option value="">Select Loan</option>
                            <?php
                                foreach ($db->display_loan() as $loan) {
                                    if ($loan['status'] == 2) {
                                        echo "<option value='{$loan['loan_id']}'>{$loan['ref_no']}</option>";
                                    }
                                }
                            ?>
                        </select>
                        <div id="formField"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Logout -->
    <div class="modal fade" id="logoutModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">System Information</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
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
        $(function() {
            $('#dataTable').DataTable();
            $('.ref_no').select2({ placeholder: 'Select Loan' });
            $('#ref_no').change(function() {
                $('#formField').load(`get_field.php?loan_id=${$(this).val()}`);
            });
        });
    </script>

</body>
</html>
