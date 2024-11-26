<?php
require_once 'class.php'; 

if (isset($_POST['sign_up'])) {     // Check if the form is submitted
    $db = new db_class();           // Create an instance of the database/connection class
    $username = $_POST['username']; // Get the username from the form
    $password = $_POST['password']; // Get the password from the form

    // Check if the username is already taken

    $count = 0;
    if ($db->if_username_taken($username, $count)) { 
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>SweetAlert</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
        <script>
        Swal.fire({
            title: 'Error!',
            text: 'Username is already taken!',
            icon: 'error'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php'; // Redirect back to signup page
            }
        });
        </script>
        </body>
        </html>";
        exit();
    }

    // Call the signUp method to save the user
    if ($db->sign_up($username, $password)) {
        // Display a SweetAlert success message and redirect
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>SweetAlert</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
        <script>
        Swal.fire({
            title: 'Success!',
            text: 'Signup Successfully!',
            icon: 'success'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php'; // Redirect to home page
            }
        });
        </script>
        </body>
        </html>";
        exit();
    } else {
        echo "Sign-up failed!"; // Display error message
    }
}
?>
