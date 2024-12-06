<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
require_once 'config.php';
session_start();

$database = new db_connect();
$db = $database->connect();
$user = new db_class($db);

// Check if loan_id is set
if (isset($_REQUEST['loan_id'])) {
    $loan_id = $_REQUEST['loan_id'];
} else {
    header("Location: user_payment.php");
    exit();
}

// Prepare and execute PDO query to fetch loan details
$stmt = $user->getConnection()->prepare("SELECT * FROM `loan` 
    INNER JOIN `borrower` ON loan.borrower_id = borrower.borrower_id 
    INNER JOIN `loan_plan` ON loan.lplan_id = loan_plan.lplan_id 
    WHERE `loan_id` = :loan_id");
$stmt->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    die("No loan data found for loan_id $loan_id.");
}

$fetch = $stmt->fetch(PDO::FETCH_ASSOC);
$monthly = ($fetch['amount'] + ($fetch['amount'] * ($fetch['lplan_interest'] / 100))) / $fetch['lplan_month'];
$penalty = $monthly * ($fetch['lplan_penalty'] / 100);
$totalAmount = $fetch['amount'] + $monthly;

// Fetch payment details using PDO
$stmt_payment = $user->getConnection()->prepare("SELECT * FROM `payment` WHERE `loan_id` = :loan_id");
$stmt_payment->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
$stmt_payment->execute();
$paid = $stmt_payment->rowCount();
$offset = $paid > 0 ? " OFFSET $paid" : "";

// Fetch next due date using PDO
$stmt_schedule = $user->getConnection()->prepare("SELECT * FROM `loan_schedule` 
    WHERE `loan_id` = :loan_id 
    ORDER BY date(due_date) ASC LIMIT 1 $offset");
$stmt_schedule->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
$stmt_schedule->execute();

if ($stmt_schedule->rowCount() > 0) {
    $next = $stmt_schedule->fetch(PDO::FETCH_ASSOC)['due_date'];
} else {
    $next = null; // Handle the case where no schedule is found
}

// Calculate penalty if applicable
$add = ($next && date('Ymd', strtotime($next)) < date("Ymd")) ? $penalty : 0;
?>

<hr />
<div class="form-row">
    <div class="form-group col-xl-6 col-md-6">
        <label>Payee</label>
        <input type="text" 
               value="<?php echo htmlspecialchars($fetch['lastname'] . ", " . $fetch['firstname'] . " " . substr($fetch['middlename'], 0, 1)) ?>."
               name="payee" class="form-control" readonly="readonly" />
        <input type="hidden" value="<?php echo number_format($add, 2) ?>" name="penalty" />
        <input type="hidden" value="<?php echo number_format($monthly + $add, 2) ?>" name="payable" />
        <input type="hidden" value="<?php echo $fetch['lplan_month']; ?>" name="month" />
    </div>
</div>

<hr />

<div class="form-row">
    <div class="form-group col-xl-6 col-md-6">
        <p>Monthly Amount: <strong>&#8369; <?php echo number_format($monthly, 2) ?></strong></p>
        <p>Penalty: <strong>&#8369; <?php echo number_format($add, 2) ?></strong></p>
        <p>Payable Amount: <strong>&#8369; <?php echo number_format($monthly + $add, 2) ?></strong></p>
    </div>
    <div class="form-group col-xl-6 col-md-6">
        <label>Amount</label>
        <input type="text" class="form-control" name="payment" required 
               onkeyup="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" />
    </div>
</div>
