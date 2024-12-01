<?php
require_once 'class.php'; 
require_once 'sweet_alert.php';

if (isset($_POST['sign_up'])) {     // Check if the form is submitted
    $db = new db_class();           // Create an instance of the database/connection class
    $username = $_POST['username']; // Get the username from the form
    $password = $_POST['password']; // Get the password from the form

    // Check if the username is already taken
    $count = 0;
    if ($db->if_username_taken($username, $count)) { 
        echo sweetAlert('Error!', 'Username is already taken!', 'error', 'index.php');
        exit();
    }

    // Call the signUp method to save the user
    if ($db->sign_up($username, $password)) {
        echo sweetAlert('Success!', 'Signup Successfully!', 'success', 'index.php');
        exit();
    } else {
        echo "Sign-up failed!";
    }
}
?>