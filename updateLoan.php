<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'class.php';
require_once 'config.php';

session_start();
if (isset($_POST['update'])) {
    try {
        // Create a database connection and user object
        $database = new db_connect();
        $db = $database->connect();
        $user = new db_class($db);

        // Retrieve form data securely
        $loan_id = $_POST['loan_id'];
        $borrower = $_POST['borrower'];
        $ltype = $_POST['ltype'];
        $lplan = $_POST['lplan'];
        $loan_amount = $_POST['loan_amount'];
        $purpose = $_POST['purpose'];

        // Fetch existing loan details securely
        $fetch = $user->getLoanDetails($user, $loan_id);

        // Fetch loan plan details securely
        $fetch1 = $user->getLoanPlanDetails($user, $lplan);
        $month = $fetch1['lplan_month'];

        // Determine the release date
        $date_released = null;
        if (preg_match('/[1-9]/', $fetch['date_released'])) {
            $date_released = $fetch['date_released'];
        } else {
            if ($fetch['status'] == 2) { // Status 2 indicates release
                $date_released = date("Y-m-d H:i:s");
                $user->createLoanSchedule($user, $loan_id, $month);
            }
        }

        // Update the loan details securely
        $user->updateLoanDetails($user, $loan_id, $borrower, $ltype, $lplan, $loan_amount, $purpose, $date_released);

        // Success message
        echo "<script>alert('Update Loan successfully!')</script>";
        echo "<script>window.location='user_loan.php'</script>";
    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "<script>alert('Error: " . $e->getMessage() . "')</script>";
    }

}
?>
