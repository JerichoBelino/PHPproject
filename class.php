<?php
	
	class db_class {

		private $conn;

		public function __construct($db){
			$this->conn = $db;
		}

		 // To access the connection and to interact with conn
		public function getConnection(){
			 return $this->conn;
		 }
		
		// Admin Login
		public function login($username, $password){
			// Prepare the query with placeholders
			$query = "SELECT * FROM `user` WHERE `username` = :username AND `password` = :password";
			$stmt = $this->conn->prepare($query); 

			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);

			if ($stmt->execute()) {
				// Fetch the result
				$fetch = $stmt->fetch(PDO::FETCH_ASSOC);
				$valid = $fetch ? 1 : 0; // 1 if user found, 0 if not
				return array(
					'user_id' => isset($fetch['user_id']) ? $fetch['user_id'] : 0,
					'count' => $valid
				);
			}
			return array('user_id' => 0, 'count' => 0);
		}

        // User Login
        public function user_login($username, $password) {
			// Prepare the query with placeholders
			$query = "SELECT * FROM `sign_up` WHERE `username` = :username";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		
			if ($stmt->execute()) {
				$fetch = $stmt->fetch(PDO::FETCH_ASSOC);
				$valid = $fetch ? 1 : 0; // 1 if user found, 0 if not
				if ($valid && password_verify($password, $fetch['password'])) {
					return array(
						'id' => isset($fetch['id']) ? $fetch['id'] : 0,
						'count' => $valid
					);
				}
			}
			return array('user_id' => 0, 'count' => 0);
		}

		// Sign up
		public function sign_up($username, $password) {
			// Prepare the SQL statement for inserting a new user into the 'sign_up' table
			$query = $this->conn->prepare("INSERT INTO sign_up (username, password) VALUES (:username, :password)");
			// Hash the password for security
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);		
			// Bind the parameters to the SQL query
			$query->bindParam(':username', $username, PDO::PARAM_STR);
			$query->bindParam(':password', $hashed_password, PDO::PARAM_STR);	
			// Execute the query and check if it was successful
			if ($query->execute()) {
				return true; // Return true on success
			} else {
				// Optionally, handle errors here
				return false; // Return false on failure
			}
		}
		
		// Username is taken, passed by reference
		public function if_username_taken($username, &$count) {
			// Prepare the SQL query to check if the username already exists
			$stmt = $this->conn->prepare("SELECT COUNT(*) FROM sign_up WHERE username = :username");		
			// Bind the username parameter to the SQL query
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);		
			$stmt->execute();		
			// Fetch the result (the count)
			$count = $stmt->fetchColumn(); // fetchColumn() gets the first column of the first row		
			// Close the statement
			$stmt->closeCursor(); // Equivalent to $stmt->close() in PDO		
			// Return true if the count is greater than 0 (meaning the username is taken)
			return $count > 0;
		}


		// Function for Borrower
		public function save_borrower($firstname, $middlename, $lastname, $contact_no, $address, $email) {
			try {
				$query = "INSERT INTO `borrower` (`firstname`, `middlename`, `lastname`, `contact_no`, `address`, `email`) VALUES (:firstname, :middlename, :lastname, :contact_no, :address, :email)";
				$stmt = $this->conn->prepare($query);
				// Bind parameters to the query
				$stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
				$stmt->bindParam(':middlename', $middlename, PDO::PARAM_STR);
				$stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
				$stmt->bindParam(':contact_no', $contact_no, PDO::PARAM_STR);
				$stmt->bindParam(':address', $address, PDO::PARAM_STR);
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);
				if ($stmt->execute()) {
					return true;
				}
				return false;
			} catch (Exception $e) {
				throw new Exception("Error saving borrower: " . $e->getMessage());
			}			
		}
        // Display
		public function display_borrower() {
			// Prepare the query
			$query = "SELECT * FROM borrower" ;
			$stmt = $this->conn->prepare($query);
			if ($stmt->execute()) {
				// Fetch all results
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
			return false;
		}
        // Delete
		public function delete_borrower($borrower_id) {
			$query = "DELETE FROM `borrower` WHERE `borrower_id` = :borrower_id";
			$stmt = $this->conn->prepare($query);
			// Bind the borrower_id parameter
			$stmt->bindParam(':borrower_id', $borrower_id, PDO::PARAM_INT);
			if ($stmt->execute()) {
				return true;
			}
			return false;
		}
        // Update
		public function update_borrower($borrower_id, $firstname, $middlename, $lastname, $contact_no, $address, $email) {
			$query = "UPDATE `borrower` SET `firstname` = :firstname, `middlename` = :middlename, `lastname` = :lastname, `contact_no` = :contact_no, `address` = :address, `email` = :email WHERE `borrower_id` = :borrower_id";
			$stmt = $this->conn->prepare($query);
			// Bind the parameters to the query
			$stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
			$stmt->bindParam(':middlename', $middlename, PDO::PARAM_STR);
			$stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
			$stmt->bindParam(':contact_no', $contact_no, PDO::PARAM_STR);
			$stmt->bindParam(':address', $address, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':borrower_id', $borrower_id, PDO::PARAM_INT);
			if ($stmt->execute()) {
				return true;
			}
			return false;
		}


		// Function for Loan Plan
		public function save_lplan($lplan_month, $lplan_interest, $lplan_penalty) {
			// Prepare the query 
			$query = $this->conn->prepare("INSERT INTO loan_plan (lplan_month, lplan_interest, lplan_penalty) VALUES (:lplan_month, :lplan_interest, :lplan_penalty)");
			// Binding Parameters
			$query->bindParam(':lplan_month', $lplan_month, PDO::PARAM_INT);
			$query->bindParam(':lplan_interest', $lplan_interest, PDO::PARAM_STR);
			$query->bindParam(':lplan_penalty', $lplan_penalty, PDO::PARAM_STR);		
			// Execute the query
			if ($query->execute()) {
				return true;
			}	
			return false;
		}
		// Display
		public function display_lplan() {
			// Prepare the query 
			$query = $this->conn->prepare("SELECT * FROM loan_plan");		
			$query->execute();		
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		// Delete  
		public function delete_lplan($lplan_id) {
			// Prepare the query
			$query = $this->conn->prepare("DELETE FROM loan_plan WHERE lplan_id = :lplan_id");		
			$query->bindParam(':lplan_id', $lplan_id, PDO::PARAM_INT);		
			if ($query->execute()) {
				return true;
			} else {
				return false; 
			}
		}
		// Update
		public function update_lplan($lplan_id, $lplan_month, $lplan_interest, $lplan_penalty) {
			// Prepare the query 
			$query = $this->conn->prepare("UPDATE loan_plan SET lplan_month = :lplan_month, lplan_interest = :lplan_interest, lplan_penalty = :lplan_penalty WHERE lplan_id = :lplan_id");
			$query->bindParam(':lplan_month', $lplan_month, PDO::PARAM_STR);
			$query->bindParam(':lplan_interest', $lplan_interest, PDO::PARAM_INT);
			$query->bindParam(':lplan_penalty', $lplan_penalty, PDO::PARAM_INT);
			$query->bindParam(':lplan_id', $lplan_id, PDO::PARAM_INT);	
			if ($query->execute()) {
				return true;
			} else {
				return false; 
			}
		}
		

		// Payment Function 
		public function display_payment() {
			// Prepare the SELECT query using PDO
			$query = $this->conn->prepare("SELECT * FROM payment");		
			if ($query->execute()) {
				// Fetch the result as an associative array
				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			} else {
				die("Error: " . $query->errorInfo()[2]);
			}
		}
		// Also like display
		public function new_payment() {
			// Prepare the query using PDO
			$query = "SELECT * FROM payment INNER JOIN loan ON payment.loan_id = loan.loan_id";
			$stmt = $this->conn->prepare($query);
			
			if ($stmt->execute()) {
				// Fetch all results
				$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
				// Output the rows
				foreach ($payments as $i => $payment) {
					echo "<tr>
						<td>".($i+1)."</td>
						<td>{$payment['ref_no']}</td>
						<td>{$payment['payee']}</td>
						<td>&#8369; ".number_format($payment['pay_amount'], 2)."</td>
						<td>&#8369; ".number_format($payment['penalty'], 2)."</td>
					</tr>";
				}
			}
		}

		// Save 
		public function save_payment($loan_id, $payee, $payment, $penalty, $overdue) {
			try {
				// Prepare the query using PDO
				$query = $this->conn->prepare("INSERT INTO payment (loan_id, payee, pay_amount, penalty, overdue) VALUES (?, ?, ?, ?, ?)");	
				// Check if the query preparation was successful
				if (!$query) {
					throw new Exception("Failed to prepare query: " . implode(", ", $this->conn->errorInfo()));
				}	
				// Bind parameters
				$query->bindParam(1, $loan_id, PDO::PARAM_INT);
				$query->bindParam(2, $payee, PDO::PARAM_STR);
				$query->bindParam(3, $payment, PDO::PARAM_STR);
				$query->bindParam(4, $penalty, PDO::PARAM_STR);
				$query->bindParam(5, $overdue, PDO::PARAM_STR);	
				if (!$query->execute()) {
					throw new Exception("Query execution failed: " . implode(", ", $query->errorInfo()));
				}		
				return true;		
			} catch (Exception $e) {
				die("Error saving payment: " . $e->getMessage());
			}
		}


		//Function for Loan Type
		public function save_ltype($ltype_name, $ltype_desc) {
			// Prepare the query 
			$query = $this->conn->prepare("INSERT INTO loan_type (ltype_name, ltype_desc) VALUES (:ltype_name, :ltype_desc)");
			$query->bindParam(':ltype_name', $ltype_name, PDO::PARAM_STR);
			$query->bindParam(':ltype_desc', $ltype_desc, PDO::PARAM_STR);		
			if ($query->execute()) {
				return true;
			} else {
				return false; 
			}
		}
		//Display
		public function display_ltype() {
			// Prepare the query 
			$query = $this->conn->prepare("SELECT * FROM loan_type");
			if ($query->execute()) {
				return $query->fetchAll(PDO::FETCH_ASSOC);
			} else {
				return false; 
			}
		}
		// Delete
		public function delete_ltype($ltype_id) {
			// Prepare the query using PDO
			$query = $this->conn->prepare("DELETE FROM loan_type WHERE ltype_id = :ltype_id");
			// Bind the parameter to prevent SQL injection
			$query->bindParam(':ltype_id', $ltype_id, PDO::PARAM_INT);
			if ($query->execute()) {
				return true; 
			} else {
				return false;
			}
		}
		// Update
		public function update_ltype($ltype_id, $ltype_name, $ltype_desc) {
			// Prepare the update query using PDO
			$query = $this->conn->prepare("UPDATE loan_type SET ltype_name = :ltype_name, ltype_desc = :ltype_desc WHERE ltype_id = :ltype_id");
			$query->bindParam(':ltype_name', $ltype_name, PDO::PARAM_STR);
			$query->bindParam(':ltype_desc', $ltype_desc, PDO::PARAM_STR);
			$query->bindParam(':ltype_id', $ltype_id, PDO::PARAM_INT);
			if ($query->execute()) {
				return true; 
			} else {
				return false; 
			}
		}


		// CREATE LOAN FUNCTION 
		public function save_loan($borrower, $ltype, $lplan, $loan_amount, $purpose, $date_created) {
			// Generate a unique reference number, Generate random integer
			$ref_no = mt_rand(1, 99999999);
			// Check if the reference number already exists
			do {
				$stmt = $this->conn->prepare("SELECT COUNT(*) FROM `loan` WHERE `ref_no` = :ref_no");
				$stmt->bindParam(':ref_no', $ref_no, PDO::PARAM_INT);
				$stmt->execute();
				// Fetch the count of rows with the same reference number
				$count = $stmt->fetchColumn();
				// If the ref_no already exists, generate a new one
				if ($count > 0) {
					$ref_no = mt_rand(1, 99999999);
				}
			} while ($count > 0);
			// Prepare the SQL query to insert the new loan
			$query = "INSERT INTO `loan` (`ref_no`, `ltype_id`, `borrower_id`, `purpose`, `amount`, `lplan_id`, `date_created`) 
					  VALUES (:ref_no, :ltype, :borrower, :purpose, :amount, :lplan, :date_created)";
			$stmt = $this->conn->prepare($query);
			// Bind parameters to the query
			$stmt->bindParam(':ref_no', $ref_no, PDO::PARAM_INT);
			$stmt->bindParam(':ltype', $ltype, PDO::PARAM_INT);
			$stmt->bindParam(':borrower', $borrower, PDO::PARAM_INT);
			$stmt->bindParam(':purpose', $purpose, PDO::PARAM_STR);
			$stmt->bindParam(':amount', $loan_amount, PDO::PARAM_INT);
			$stmt->bindParam(':lplan', $lplan, PDO::PARAM_INT);
			$stmt->bindParam(':date_created', $date_created, PDO::PARAM_STR);
			if ($stmt->execute()) {
				return true; // Return true if insertion is successful
			}
			return false;
		}
		// Delete Loan
		public function delete_loan($loan_id) {
			$query = "DELETE FROM `loan` WHERE `loan_id` = :loan_id";
			$stmt = $this->conn->prepare($query);

			$stmt->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
			if ($stmt->execute()) {
				return true;
			}
			return false; // Return false if the query execution fails
		}

		// for Update Loan (user)
		public function getLoanDetails($user, $loan_id) {
			$loanQuery = $this->conn->prepare("SELECT * FROM `loan` WHERE `loan_id` = :loan_id");
			$loanQuery->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
			$loanQuery->execute();
			return $loanQuery->fetch(PDO::FETCH_ASSOC);
		}
		// Function to fetch loan plan details
		public function getLoanPlanDetails($user, $lplan) {
			$lplanQuery = $this->conn->prepare("SELECT * FROM `loan_plan` WHERE `lplan_id` = :lplan_id");
			$lplanQuery->bindParam(':lplan_id', $lplan, PDO::PARAM_INT);
			$lplanQuery->execute();
			return $lplanQuery->fetch(PDO::FETCH_ASSOC);
		}
		// Function to create loan schedule
		public function createLoanSchedule($user, $loan_id, $month) {
			for ($i = 1; $i <= $month; $i++) {
				$date_schedule = date("Y-m-d", strtotime("+$i month"));
				$scheduleQuery = $this->conn->prepare("INSERT INTO `loan_schedule` (`loan_id`, `due_date`) VALUES (:loan_id, :due_date)");
				$scheduleQuery->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
				$scheduleQuery->bindParam(':due_date', $date_schedule, PDO::PARAM_STR);
				$scheduleQuery->execute();
			}
		}
		// Function to update loan details
		public function updateLoanDetails($user, $loan_id, $borrower, $ltype, $lplan, $loan_amount, $purpose, $date_released) {
			$updateQuery = $this->conn->prepare(
				"UPDATE `loan` 
				 SET `borrower_id` = :borrower, `ltype_id` = :ltype, `lplan_id` = :lplan, 
					 `amount` = :loan_amount, `purpose` = :purpose, 
					 `date_released` = :date_released 
				 WHERE `loan_id` = :loan_id"
			);
			$updateQuery->bindParam(':borrower', $borrower, PDO::PARAM_INT);
			$updateQuery->bindParam(':ltype', $ltype, PDO::PARAM_INT);
			$updateQuery->bindParam(':lplan', $lplan, PDO::PARAM_INT);
			$updateQuery->bindParam(':loan_amount', $loan_amount, PDO::PARAM_STR);
			$updateQuery->bindParam(':purpose', $purpose, PDO::PARAM_STR);
			$updateQuery->bindParam(':date_released', $date_released, PDO::PARAM_STR);
			$updateQuery->bindParam(':loan_id', $loan_id, PDO::PARAM_INT);
			$updateQuery->execute();
		}

		// Display
		public function display_loan() {
			// Query to get the loan data with JOINs
			$query = "SELECT loan.*, borrower.lastname, borrower.firstname, borrower.middlename, borrower.contact_no, borrower.address, loan_type.ltype_name, loan_plan.lplan_month, loan_plan.lplan_interest, loan_plan.lplan_penalty 
					  FROM loan
					  INNER JOIN borrower ON loan.borrower_id = borrower.borrower_id
					  INNER JOIN loan_type ON loan.ltype_id = loan_type.ltype_id
					  INNER JOIN loan_plan ON loan.lplan_id = loan_plan.lplan_id";
			$stmt = $this->conn->prepare($query);
			if ($stmt->execute()) {
				// Fetch all results as an associative array
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			return false; 
		}
		// Display next payment
		public function getNextPaymentDetails($loanId, $status, $monthly, $penalty) {
			if (!isset($loanId)) {
				return ["error" => "Invalid Loan ID."];
			}
			// Prepare the query to fetch payment details for the given loan ID
			$query = "SELECT * FROM payment WHERE loan_id = :loan_id";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':loan_id', $loanId, PDO::PARAM_INT);
			$stmt->execute();
			// Get the number of payments already made
			$paid = $stmt->rowCount();
			$offset = $paid ? " OFFSET $paid" : "";
		
			if ($status == 2) {
				// Prepare the query to fetch the next loan schedule based on loan ID and status
				$nextQuery = "SELECT * FROM loan_schedule WHERE loan_id = :loan_id ORDER BY date(due_date) ASC LIMIT 1 $offset";
				$nextStmt = $this->conn->prepare($nextQuery);
				$nextStmt->bindParam(':loan_id', $loanId, PDO::PARAM_INT);
				$nextStmt->execute();
		
				if ($nextRow = $nextStmt->fetch(PDO::FETCH_ASSOC)) {
					$next = $nextRow['due_date'];
					// Check if the next payment date is past due and apply penalty if necessary
					$add = (date('Ymd', strtotime($next)) < date("Ymd")) ? $penalty : 0;
					return [
						"next" => $next,
						"monthly" => $monthly,
						"penalty" => $add,
						"total" => $monthly + $add
					];
				} else {
					return ["error" => "No upcoming payments."];
				}
			}
			return ["error" => "No upcoming payments."];
		}
		// Get this 4 to create loan also for update
		public function getBorrowers() {
			$stmt = $this->conn->query("SELECT borrower_id, lastname, firstname, middlename FROM borrower");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getLoanTypes() {
			$stmt = $this->conn->query("SELECT ltype_id, ltype_name FROM loan_type");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getLoanPlans() {
			$stmt = $this->conn->query("SELECT lplan_id, lplan_month, lplan_interest, lplan_penalty FROM loan_plan");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getStatusOptions() {
			return [
				0 => 'For Approval',
				1 => 'Approved',
				2 => 'Released',
				4 => 'Denied'
			];
		}
		
		// View Payment Sched
		public function getLoanSchedule($loanId) {
			// Prepare the SQL statement to fetch the loan schedule
			$query = "SELECT * FROM loan_schedule WHERE loan_id = :loan_id";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':loan_id', $loanId, PDO::PARAM_INT);
			$stmt->execute();
			// Initialize an array to hold the schedule data
			$scheduleData = [];
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$scheduleData[] = [
					'due_date' => date("F d, Y", strtotime($row['due_date'])),
				];
			}
			return $scheduleData;
		}
	}
?>