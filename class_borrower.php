<?php
	require_once 'config.php';
	
	class db_borrower extends db_connect{

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
				die("Error saving borrower: " . $e->getMessage());
			}
		}
		
        // Display
		public function display_borrower() {
			// Prepare the query
			$query = "SELECT * FROM `borrower`";
			$stmt = $this->conn->prepare($query);
			// Execute the statement
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

    }
?>