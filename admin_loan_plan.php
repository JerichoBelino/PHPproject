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
                                    <img class="img-profile rounded-circle" src="image/admin_logo.png">
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
                                                <!-- Display Loan PLan -->
                                                <?php
                                                    foreach ($admin->display_lplan() as $fetch) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $fetch['lplan_month']; ?></td>
                                                    <td><?php echo $fetch['lplan_interest']; ?></td>
                                                    <td><?php echo $fetch['lplan_penalty']; ?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">Action</button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item bg-warning text-white" href="#" data-toggle="modal" data-target="#updatelplan<?php echo $fetch['lplan_id']; ?>">Edit</a>
                                                                <a class="dropdown-item bg-danger text-white" href="#" data-toggle="modal" data-target="#deletelplan<?php echo $fetch['lplan_id']; ?>">Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Delete Loan Plan -->
                                                <div class="modal fade" id="deletelplan<?php echo $fetch['lplan_id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger">
                                                                <h5 class="modal-title text-white">System Information</h5>
                                                                <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                                            </div>
                                                            <div class="modal-body">Are you sure you want to delete this record?</div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                                <a class="btn btn-danger" href="delete_lplan.php?lplan_id=<?php echo $fetch['lplan_id']; ?>">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit Loan Plan -->
                                                <div class="modal fade" id="updatelplan<?php echo $fetch['lplan_id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST" action="update_lplan.php">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-warning">
                                                                    <h5 class="modal-title text-white">Edit Loan Plan</h5>
                                                                    <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group"><label>Plan(months)</label><input type="text" class="form-control" value="<?php echo $fetch['lplan_month']; ?>" name="lplan_month" required/><input type="hidden" value="<?php echo $fetch['lplan_id']; ?>" name="lplan_id"/></div>
                                                                    <div class="form-group"><label>Interest</label><div class="input-group"><input type="number" class="form-control" value="<?php echo $fetch['lplan_interest']; ?>" name="lplan_interest" min="0" required /><div class="input-group-prepend"><span class="input-group-text">%</span></div></div></div>
                                                                    <div class="form-group"><label>Penalty</label><div class="input-group"><input type="number" class="form-control" value="<?php echo $fetch['lplan_penalty']; ?>" name="lplan_penalty" min="0" required /><div class="input-group-prepend"><span class="input-group-text">%</span></div></div></div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                                    <button class="btn btn-warning" name="update" type="submit">Update</button>
                                                                </div>
                                                            </div>
                                                        </form>
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
        </div>
    </div>

		<!-- Logout-->
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
				"order": [[1 , "asc" ]]
			});
		});
	</script>
</body>
</html>