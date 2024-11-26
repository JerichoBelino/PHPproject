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


    <!-- Signup -->
			<div class="signup">
				<form method="POST" action="sign_up.php">
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="username" placeholder="Username" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<button type="submit" name="sign_up">Sign up</button>
				</form>
			</div>

	
    <!-- Login -->
			<div class="login">
				<form method="POST" action="user_login.php">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="text" name="username" placeholder="Username" required="required">
					<input type="password" name="password" placeholder="Password" required="required">
					<button type="submit" name="user_login">Login</button>
				</form>
			</div>
	</div>
    </div>
</body>
</html>

  
</body>
</html>
