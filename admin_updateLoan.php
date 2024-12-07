<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'class.php';
require_once 'config.php';
session_start();

if (isset($_POST['update'])) {
    try {

        $database = new db_connect();
        $db = $database->connect();
        $admin = new db_class($db);

        // Retrieve form data securely
        $loan_id = $_POST['loan_id'];
        $borrower = $_POST['borrower'];
        $ltype = $_POST['ltype'];
        $lplan = $_POST['lplan'];
        $loan_amount = $_POST['loan_amount'];
        $purpose = $_POST['purpose'];
        $status = $_POST['status'];
        $date_released = null;

        // Fetch existing loan details securely
        $loanQuery = $admin->getConnection()->prepare("SELECT * FROM `loan` WHERE `loan_id` = :loan_id");
        $loanQuery->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
        $loanQuery->execute();
        $fetch = $loanQuery->fetch(PDO::FETCH_ASSOC);

        // Fetch loan plan details securely
        $lplanQuery = $admin->getConnection()->prepare("SELECT * FROM `loan_plan` WHERE `lplan_id` = :lplan_id");
        $lplanQuery->bindParam(':lplan_id', $lplan, PDO::PARAM_INT);
        $lplanQuery->execute();
        $fetch1 = $lplanQuery->fetch(PDO::FETCH_ASSOC);
        $month = $fetch1['lplan_month'];

        // Determine the release date
        if (preg_match('/[1-9]/', $fetch['date_released'])) {
            $date_released = $fetch['date_released'];
        } else {
            if ($status == 2) { // Status 2 indicates release
                $date_released = date("Y-m-d H:i:s");

                // Schedule payment dates based on loan duration
                for ($i = 1; $i <= $month; $i++) {
                    $date_schedule = date("Y-m-d", strtotime("+$i month"));
                    $scheduleQuery = $admin->getConnection()->prepare("INSERT INTO `loan_schedule` (`loan_id`, `due_date`) VALUES (:loan_id, :due_date)");
                    $scheduleQuery->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
                    $scheduleQuery->bindParam(':due_date', $date_schedule, PDO::PARAM_STR);
                    $scheduleQuery->execute();
                }
            }
        }

        // Update the loan details securely
        $updateQuery = $admin->getConnection()->prepare(
            "UPDATE `loan` 
            SET `borrower_id` = :borrower, `ltype_id` = :ltype, `lplan_id` = :lplan, 
                `amount` = :loan_amount, `purpose` = :purpose, `status` = :status, 
                `date_released` = :date_released 
            WHERE `loan_id` = :loan_id"
        );
        $updateQuery->bindParam(':borrower', $borrower, PDO::PARAM_INT);
        $updateQuery->bindParam(':ltype', $ltype, PDO::PARAM_INT);
        $updateQuery->bindParam(':lplan', $lplan, PDO::PARAM_INT);
        $updateQuery->bindParam(':loan_amount', $loan_amount, PDO::PARAM_STR);
        $updateQuery->bindParam(':purpose', $purpose, PDO::PARAM_STR);
        $updateQuery->bindParam(':status', $status, PDO::PARAM_INT);
        $updateQuery->bindParam(':date_released', $date_released, PDO::PARAM_STR);
        $updateQuery->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
        $updateQuery->execute();

        // Success message
        echo "<script>alert('Update Loan successfully!')</script>";
        echo "<script>window.location='admin_loan.php'</script>";
    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "<script>alert('Error: " . $e->getMessage() . "')</script>";
    }
}
?>
