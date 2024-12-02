<?php
	require_once 'config.php';
	
	class db_class extends db_connect{
		
		public function __construct(){
			$this->connect();
		}
		
		public function sign_up($username, $password) {
			// Prepare the SQL statement for inserting a new user into the 'users' table
			$query = $this->conn->prepare("INSERT INTO sign_up (username, password) VALUES (?, ?)") or die($this->conn->error);
			
			// Hash the password for security
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			
			// Bind parameters to the SQL query (omit the id since it is auto-increment)
			$query->bind_param("ss", $username, $hashed_password);
			
			// Execute the query and check if it was successful
			if ($query->execute()) {
				$query->close();
				return true; // Return true on success
			} else {
				// Optionally, handle errors here
				return false; // Return false on failure
			}
		}
	}
?>