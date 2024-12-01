<?php
	require_once 'config.php';
	
	class db_class extends db_connect{
		
		public function __construct(){
			$this->connect();
		}
		
		// //admin Login
		// public function login($username, $password){
		// 	$query=$this->conn->prepare("SELECT * FROM `user` WHERE `username`='$username' && `password`='$password'") or die($this->conn->error);
		// 	if($query->execute()){						
		// 		$result=$query->get_result();				
		// 		$valid=$result->num_rows;			
		// 		$fetch=$result->fetch_array();
		// 		return array(
		// 			'user_id'=>isset($fetch['user_id']) ? $fetch['user_id'] : 0,
		// 			'count'=>isset($valid) ? $valid: 0
		// 		);	
		// 	}
		// }

		
		//user_login
		public function user_login($username, $password) {
			// Secure query with placeholders
			$query = $this->conn->prepare("SELECT * FROM `sign_up` WHERE `username` = ?") or die($this->conn->error);
			$query->bind_param("s", $username); // Use prepared statements to prevent SQL injection
		
			if ($query->execute()) {
				$result = $query->get_result();
				$valid = $result->num_rows;
		
				if ($valid > 0) {
					$fetch = $result->fetch_array();
					// Use password_verify to check password against hash stored in the database
					if (password_verify($password, $fetch['password'])) {
						return array(
							'id' => $fetch['id'],
							'count' => $valid
						);
					}
				}
				// Return an array indicating failed login
				return array(
					'id' => 0,
					'count' => 0
				);
			} else {
				// Handle query execution failure
				throw new Exception("Database query failed: " . $this->conn->error);
			}
		}
		
	}
?>