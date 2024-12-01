<?php
    require_once 'class.php';
    session_start();
    
    if (isset($_POST['user_login'])) {
        $db = new db_class();
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        // Perform user login check
        $get_id = $db->user_login($username, $password);
    
        if ($username === 'admin' && $password === 'admin') { 
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
                title: 'Welcome Admin!',
                text: 'You have successfully signed in as admin.',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                
                    window.location.href = 'admin_home.php'; // Redirect to admin dashboard  
                    document.getElementById('loginForm').reset(); // Clear the form
                }
            });
            </script>
            </body>
            </html>";
            exit();
        } else if ($get_id['count'] > 0) {
            $_SESSION['id'] = $get_id['id'];
            unset($_SESSION['message']);
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
                title: 'Login Successfully!',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'user_home.php';
                    document.getElementById('loginForm').reset(); // Clear the form
                }
            });
            </script>
            </body>
            </html>";
           
        } else {
             $_SESSION['message'] = "Invalid Username or Password";
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
                text: 'Invalid Username or Password',
                icon: 'error'
            }).then((result) => {
                if (result.isConfirmed) {
                   
                    window.location.href = 'index.php';  // Redirect back to login page 
                    document.getElementById('loginForm').reset();  // Clear the form
                }
            });
            </script>
            </body>
            </html>";

        }
    }
    
?>
