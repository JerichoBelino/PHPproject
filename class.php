<?php
	require_once 'config.php';
	
	class db_class extends db_connect{
		
		public function __construct(){
			$this->connect();
		}
		
<<<<<<< HEAD
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
=======

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

		
>>>>>>> f996c034ecfebfe1970af8f1520678bd2e3a940c
	}
?>