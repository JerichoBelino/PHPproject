<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'class.php';

if (isset($_POST['save'])) {
    // Initialize the database connection
    $db = new db_class();
    if (!$db->conn) {
        die("Database connection failed.");
    }
    $loan_id = $_POST['loan_id'];
    $payee = $_POST['payee'];
    $penalty = isset($_POST['penalty']) ? (float)str_replace(",", "", $_POST['penalty']) : 0;
    $payable = isset($_POST['payable']) ? (float)str_replace(",", "", $_POST['payable']) : 0;
    $payment = isset($_POST['payment']) ? (float)str_replace(",", "", $_POST['payment']) : 0;
    $month = isset($_POST['month']) ? (int)$_POST['month'] : 0;
    // Determine overdue status
    $overdue = $penalty > 0 ? 1 : 0;
    // Validate the payment amount
    if ($payable !== $payment) {
        echo "<script>alert('Please enter the correct amount to pay!')</script>";
        echo "<script>window.location='user_payment.php'</script>";
        exit();
    }
    // Save the payment
    try {
        $db->save_payment($loan_id, $payee, $payment, $penalty, $overdue);
        // Count payments made for this loan
        $stmtCount = $db->conn->prepare("SELECT COUNT(*) AS count FROM `payment` WHERE `loan_id` = :loan_id");
        $stmtCount->bindParam(':loan_id', $loan_id);
        $stmtCount->execute();
        $result = $stmtCount->fetch(PDO::FETCH_ASSOC);
        $count_pay = $result['count'];
        // Check if the total payments made match the required number of months
        if ($count_pay === $month) {
            // Update loan status if all payments are completed
            $stmtUpdate = $db->conn->prepare("UPDATE `loan` SET `status` = 3 WHERE `loan_id` = :loan_id");
            $stmtUpdate->bindParam(':loan_id', $loan_id);
            if (!$stmtUpdate->execute()) {
                throw new Exception("Failed to update loan status.");
            }
        }
        header("Location: user_payment.php");
        exit();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
