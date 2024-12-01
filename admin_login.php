<?php
	require_once 'class.php';
    require_once 'sweet_alert.php';
	session_start();
	
	if(ISSET($_POST['admin_login'])) {
	
		$db=new db_class();
		$username=$_POST['username'];
		$password=$_POST['password'];
		
		$get_id=$db->login($username, $password);
		
		if($get_id['count'] > 0){
			$_SESSION['user_id']=$get_id['user_id'];
			unset($_SESSION['message']);
            echo sweetAlert('Success!', 'Admin Login Successful!', 'success', 'admin_home.php');
           
        } else {
            //$_SESSION['message'] = "Invalid Username or Password";
            echo sweetAlert('Error!', 'Invalid Username or Password', 'error', 'index.php');
        }
	}
?>