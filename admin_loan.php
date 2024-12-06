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
	<link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.0.0/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

<div id="wrapper">
		<nav class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">	
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_home.html">
                <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
            </a>
            <li class="nav-item"><a class="nav-link" href="admin_home.php"><i class="fas fa-fw fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_loan.php"><i class="fas fa-fw fa-comment-dollar"></i> Loans</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_payment.php"><i class="fas fa-fw fa-coins"></i> Payments</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_borrower.php"><i class="fas fa-fw fa-book"></i> Borrowers</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_loan_plan.php"><i class="fas fa-fw fa-piggy-bank"></i> Loan Plans</a></li>
            <li class="nav-item"><a class="nav-link" href="admin_loan_type.php"><i class="fas fa-fw fa-money-check"></i> Loan Types</a></li>
        </nav>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
				<!-- Log out -->
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
                        <h1 class="h3 mb-0 text-gray-800">Loan List</h1>
                    </div>
		
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Borrower</th>
                                            <th>Loan Detail</th>
                                            <th>Payment Detail</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											$tbl_loan = $admin->display_loan();
											$i=1;
											foreach ($tbl_loan as $fetch){
										?>
                                        <tr>
											<td><?php echo $i++;?></td>
											<td>
												<p><small>Name: <strong><?php echo $fetch['lastname'].", ".$fetch['firstname']." ".substr($fetch['middlename'], 0, 1)."."?></strong></small></p>
												<p><small>Contact: <strong><?php echo $fetch['contact_no']?></strong></small></p>
												<p><small>Address: <strong><?php echo $fetch['address']?></strong></small></p>
											</td>
											<td>
												<p><small>Reference no: <strong><?php echo $fetch['ref_no']?></strong></small></p>
												<p><small>Loan Type: <strong><?php echo $fetch['ltype_name']?></strong></small></p>
												<p><small>Loan Plan: <strong><?php echo "{$fetch['lplan_month']} months[{$fetch['lplan_interest']}%, {$fetch['lplan_penalty']}%]"?></strong> interest, penalty</small></p>
												<?php
													$monthly = ($fetch['amount'] + ($fetch['amount'] * ($fetch['lplan_interest'] / 100))) / $fetch['lplan_month'];
													$penalty = $monthly * ($fetch['lplan_penalty'] / 100);
													$totalAmount = $fetch['amount'] + $monthly;
												?>
												<p><small>Amount: <strong>&#8369; <?php echo number_format($fetch['amount'], 2)?></strong></small></p>
												<p><small>Total: <strong>&#8369; <?php echo number_format($totalAmount, 2)?></strong></small></p>
												<p><small>Monthly: <strong>&#8369; <?php echo number_format($monthly, 2)?></strong></small></p>
												<p><small>Overdue: <strong>&#8369; <?php echo number_format($penalty, 2)?></strong></small></p>
												<?php if (preg_match('/[1-9]/', $fetch['date_released'])) echo "<p><small>Released: <strong>".date("M d, Y", strtotime($fetch['date_released']))."</strong></small></p>"; ?>
											</td>
											<td>
												<?php 
												if (isset($fetch['loan_id'])) {
													$details = $admin->getNextPaymentDetails($fetch['loan_id'], $fetch['status'], $monthly, $penalty);
												
													if (isset($details['error'])) {
														echo "<p><small>{$details['error']}</small></p>";
													} else {
														echo "<p><small>Next: <strong>" . date('F d, Y', strtotime($details['next'])) . "</strong></small></p>";
														echo "<p><small>Amount: <strong>&#8369; " . number_format($details['monthly'], 2) . "</strong></small></p>";
														echo "<p><small>Penalty: <strong>&#8369; " . number_format($details['penalty'], 2) . "</strong></small></p>";
														echo "<p><small>Total: <strong>&#8369; " . number_format($details['total'], 2) . "</strong></small></p>";
													}
												} else {
													echo "<p><small>Invalid Loan ID.</small></p>";
												}
												 ?>
											</td>
											<td>
											<?php 
													if($fetch['status']==0){
														echo '<span class="badge badge-warning">For Approval</span>';
													}else if($fetch['status']==1){
														echo '<span class="badge badge-info">Approved</span>';
													}else if($fetch['status']==2){
														echo '<span class="badge badge-primary">Released</span>';
													}else if($fetch['status']==3){
														echo '<span class="badge badge-success">Completed</span>';
													}else if($fetch['status']==4){
														echo '<span class="badge badge-danger">Denied</span>';
													}
												?>
											</td>
											<td>
												<?php if ($fetch['status'] == 2) { ?>
													<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#viewSchedule<?php echo $fetch['loan_id']?>">View Schedule</button>
												<?php } elseif ($fetch['status'] == 3) { ?>
													<button class="btn btn-lg btn-success" readonly>COMPLETED</button>
												<?php } else { ?>
													<div class="dropdown">
														<button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Action</button>
														<div class="dropdown-menu">
															<a class="dropdown-item bg-warning text-white" data-toggle="modal" data-target="#updateloan<?php echo $fetch['loan_id']?>">Edit</a>
															<a class="dropdown-item bg-danger text-white" data-toggle="modal" data-target="#deleteborrower<?php echo $fetch['loan_id']?>">Delete</a>
														</div>
													</div>
												<?php } ?>
											</td>
										</tr>
										
									<!-- Update User -->
									<div class="modal fade" id="updateloan<?php echo htmlspecialchars($fetch['loan_id']); ?>" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<form method="POST" action="admin_updateLoan.php">
													<div class="modal-content">
														<div class="modal-header bg-warning">
															<h5 class="modal-title text-white">Edit Loan</h5>
															<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
														</div>
														<div class="modal-body">
															<div class="form-row">
																<div class="form-group col-md-6">
																	<label>Borrower</label>
																	<input type="hidden" name="loan_id" value="<?php echo htmlspecialchars($fetch['loan_id']); ?>" />
																	<select name="borrower" class="borrow" required style="width:100%;" disabled>
																		<?php
																		foreach ($admin->getBorrowers() as $borrower) {
																			$selected = $fetch['borrower_id'] == $borrower['borrower_id'] ? 'selected' : '';
																			$middlenameInitial = substr($borrower['middlename'], 0, 1) . '.';
																			echo "<option value='{$borrower['borrower_id']}' {$selected}>" .
																				htmlspecialchars("{$borrower['lastname']}, {$borrower['firstname']} {$middlenameInitial}") .
																				"</option>";
																		}
																		?>
																	</select>
																	<input type="hidden" name="borrower" value="<?php echo htmlspecialchars($fetch['borrower_id']); ?>" />
																</div>
																<div class="form-group col-md-6">
																	<label>Loan Type</label>
																	<select name="ltype" class="loan" required style="width:100%;" disabled>
																		<?php
																		foreach ($admin->getLoanTypes() as $loanType) {
																			$selected = $fetch['ltype_id'] == $loanType['ltype_id'] ? 'selected' : '';
																			echo "<option value='{$loanType['ltype_id']}' {$selected}>" .
																				htmlspecialchars($loanType['ltype_name']) .
																				"</option>";
																		}
																		?>
																	</select>
																	<input type="hidden" name="ltype" value="<?php echo htmlspecialchars($fetch['ltype_id']); ?>" />
																</div>
															</div>
															<div class="form-row">
																<div class="form-group col-md-6">
																	<label>Loan Plan</label>
																	<select name="lplan" class="form-control" required id="ulplan" disabled>
																		<?php
																		foreach ($admin->getLoanPlans() as $loanPlan) {
																			$selected = $fetch['lplan_id'] == $loanPlan['lplan_id'] ? 'selected' : '';
																			echo "<option value='{$loanPlan['lplan_id']}' {$selected}>" .
																				htmlspecialchars("{$loanPlan['lplan_month']} months [{$loanPlan['lplan_interest']}%, {$loanPlan['lplan_penalty']}%]") .
																				"</option>";
																		}
																		?>
																	</select>
																	<label>Months [Interest%, Penalty%]</label>
																	<input type="hidden" name="lplan" value="<?php echo htmlspecialchars($fetch['lplan_id']); ?>" />
																</div>
																<div class="form-group col-md-6">
																	<label>Loan Amount</label>
																	<input type="number" name="loan_amount" class="form-control" id="uamount" value="<?php echo htmlspecialchars($fetch['amount']); ?>" required readonly />
																</div>
															</div>
															<div class="form-row">
																<div class="form-group col-md-6">
																	<label>Purpose</label>
																	<textarea name="purpose" class="form-control" required readonly><?php echo htmlspecialchars($fetch['purpose']); ?></textarea>
																</div>
															</div>
															<hr>
															<div class="row text-center">
																<div class="col-md-4"><span>Total Payable</span><br><span id="utpa"><?php echo "&#8369; " . number_format($totalAmount, 2); ?></span></div>
																<div class="col-md-4"><span>Monthly Payable</span><br><span id="umpa"><?php echo "&#8369; " . number_format($monthly, 2); ?></span></div>
																<div class="col-md-4"><span>Penalty</span><br><span id="upa"><?php echo "&#8369; " . number_format($penalty, 2); ?></span></div>
															</div>
															<hr>
															<div class="form-row">
																<div class="form-group col-md-6">
																	<label>Status</label>
																	<select name="status" class="form-control">
																		<?php
																		foreach ($admin->getStatusOptions() as $statusValue => $statusLabel) {
																			$selected = $fetch['status'] == $statusValue ? 'selected' : '';
																			$readonly = $statusValue == 2 ? 'readonly' : '';
																			echo "<option value='{$statusValue}' {$selected} {$readonly}>{$statusLabel}</option>";
																		}
																		?>
																	</select>
																</div>
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

									<!-- Delete Loan -->		
									<div class="modal fade" id="deleteborrower<?php echo $fetch['loan_id']?>" tabindex="-1" aria-hidden="true">
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
														<a class="btn btn-danger" href="admin_deleteLoan.php?loan_id=<?php echo $fetch['loan_id']?>">Delete</a>
												</div>
											</div>
										</div>
									</div>
										
									<!-- View Payment Schedule -->
									<div class="modal fade" id="viewSchedule<?php echo $fetch['loan_id']?>" tabindex="-1" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-info">
													<h5 class="modal-title text-white">Payment Schedule</h5>
													<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
												</div>
												<div class="modal-body">
													<div class="row">
														<div class="col-md-5"><p>Reference No:</p><p><strong><?php echo $fetch['ref_no']?></strong></p></div>
														<div class="col-md-7"><p>Name:</p><p><strong><?php echo $fetch['firstname']." ".substr($fetch['middlename'], 0, 1).". ".$fetch['lastname']?></strong></p></div>
													</div><hr/>
													<div class="container">
														<div class="row"><div class="col-sm-6"><center>Months</center></div><div class="col-sm-6"><center>Monthly Payment</center></div></div><hr/>
															<?php
																if (isset($fetch['loan_id'])) {
																	$scheduleData = $admin->getLoanSchedule($fetch['loan_id']);
																	foreach ($scheduleData as $row): ?>
																		<div class="row">
																			<div class="col-sm-6 p-2 pl-5" style="border-right: 1px solid black; border-bottom: 1px solid black;">
																				<strong><?= $row['due_date']; ?></strong>
																			</div>
																			<div class="col-sm-6 p-2 pl-5" style="border-bottom: 1px solid black;">
																				<strong>&#8369; <?= number_format($monthly, 2); ?></strong>
																			</div>
																		</div>
																	<?php endforeach; 
																} else {
																	echo "<p><small>Invalid Loan ID.</small></p>";
																}
															?>
													</div>
												</div>
												<div class="modal-footer">
													<button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
												</div>
											</div>
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

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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

    <!-- Script -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
	<script src="js/sb-admin-2.js"></script>
	<!-- For computation -->
	<script>
		$(document).ready(function() {
		$("#calcTable").hide();
		$('.borrow, .loan').select2({ placeholder: 'Select an option' });
		function calculateAmount(planSelector, amountSelector, tpa, mpa, pa) {
    if ($(planSelector).val() == "" || $(amountSelector).val() == "") {
        alert("Please enter a Loan Plan or Amount to Calculate");
    } else {
        var lplan = $(planSelector + " option:selected").text();
        var [months, remainder] = lplan.split('months');
        var [interest, penalty] = remainder.split('%').map(val => parseFloat(val.replace(/[^0-9.]/g, "")));
        var amount = parseFloat($(amountSelector).val());
        months = parseInt(months.trim(), 10); // Ensure months is an integer
        // Calculate total payable amount
        var totalInterest = amount * (interest / 100);
        var totalAmount = amount + totalInterest;
        // Calculate monthly payable amount
        var monthly = totalAmount / months;
        // Calculate penalty
        var penaltyAmount = monthly * (penalty / 100);
        // Display the results
        $(tpa).text("\u20B1 " + totalAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $(mpa).text("\u20B1 " + monthly.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $(pa).text("\u20B1 " + penaltyAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $("#calcTable").show();
    }
}
		$("#calculate").click(function() { calculateAmount("#lplan", "#amount", "#tpa", "#mpa", "#pa"); });
		$("#updateCalculate").click(function() { calculateAmount("#ulplan", "#uamount", "#utpa", "#umpa", "#upa"); });
		$('#dataTable').DataTable();
	});
	</script>

</body>
</html>