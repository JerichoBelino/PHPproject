<?php
    require_once 'class.php';
    require_once 'config.php';
    require_once 'sweet_alert.php';
    session_start();
    
    if (isset($_POST['user_login'])) {

        $database = new db_connect();
        $db = $database->connect();
        $user = new db_class($db);


        $username = $_POST['username'];
        $password = $_POST['password'];
        // Perform user login check
        $get_id = $user->user_login($username, $password);
    
        if ($get_id['count'] > 0) {
            $_SESSION['id'] = $get_id['id'];
            unset($_SESSION['message']);
            echo sweetAlert('Success!', 'Login Successful!', 'success', 'user_home.php');
           
        } else {
            //$_SESSION['message'] = "Invalid Username or Password";
            echo sweetAlert('Error!', 'Invalid Username or Password', 'error', 'index.php');
        }
    }
    
?>
