<?php
	require_once 'config.php';
	
	class db_class extends db_connect{
		
		public function __construct(){
			$this->connect();
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
		
        
	}
?>