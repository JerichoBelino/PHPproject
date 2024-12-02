<?php
	require_once 'config.php';
	
	class db_home extends db_connect{
		
		public function __construct(){
			$this->connect();
		}


        // View the actie loans
        public function get_active_loan($status = 2) {
            // Prepare the SQL statement
            $stmt = $this->conn->prepare("SELECT * FROM `loan` WHERE `status` = :status");
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);   
            $stmt->execute();     
            // Return the count of active loans, or 0 if none
            return $stmt->rowCount() > 0 ? $stmt->rowCount() : 0;
	}
    

        // Get the total payment Today
		public function get_total_payments() {
			// Get the current date
			$current_date = date("Y-m-d");
			$stmt = $this->conn->prepare("SELECT SUM(pay_amount) as total FROM `payment` WHERE DATE(date_created) = :current_date");	
			$stmt->bindParam(':current_date', $current_date, PDO::PARAM_STR);	
			$stmt->execute();	
			$result = $stmt->fetch(PDO::FETCH_ASSOC);	
			// Return the formatted total, or 0.00 if no payments
			return $result['total'] ? "&#8369; " . number_format($result['total'], 2) : "&#8369; 0.00";
		}


        // Get the total borrowers
        public function get_total_borrowers() {
            // Prepare the SQL statement
            $stmt = $this->conn->prepare("SELECT * FROM `borrower`");    
            $stmt->execute();
            // Return the row count or 0 if no borrowers are found
            return $stmt->rowCount() > 0 ? $stmt->rowCount() : 0;
        }

}
?>