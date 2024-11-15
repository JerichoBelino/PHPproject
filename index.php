<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Loan Management System</title>
  <link rel="stylesheet" href="./Login.css">

</head>
<body>

<!DOCTYPE html>
<html>
<head>
	<title>Slide Navbar</title>
	<link rel="stylesheet" type="text/css" href="slide navbar Login.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">


</head>
<body>
    
    <h1 class="loantxt">
        <span>Loan Management</span>
        <span>System</span>
    </h1>

    <div class="all">
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form>
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="txt" placeholder="User name" required="">
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="pswd" placeholder="Password" required="">
					<button>Sign up</button>
				</form>
			</div>


			<div class="login">
				<form method="POST" action="Login.php">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="text" name="username" placeholder="Username" required="required">
					<input type="password" name="password" placeholder="Password" required="required">

                    <?php 
						session_start();
						if(ISSET($_SESSION['message'])){
						echo "<center><label class='text-danger'>".$_SESSION['message']."</label></center>";
						}
					?>

  					<?php 
						session_start();
						if(ISSET($_SESSION['message'])){
						echo "<center><label class='text-danger'>".$_SESSION['message']."</label></center>";
						}
					?>

					<button>Login</button>
				</form>
			</div>
	</div>
    </div>
</body>
</html>

  
</body>
</html>
