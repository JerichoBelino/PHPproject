<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Loan Management System</title>
    <link rel="stylesheet" href="css/Login.css"> <!-- Link to the CSS file -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script> <!-- Include the reusable script -->
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
                <form id="signupForm" onsubmit="return handleSignUpFormSubmission(event)">
                    <label for="chk" aria-hidden="true">Sign up</label>
                    <input type="text" id="username" name="username" placeholder="Username" required="required">
                    <input type="password" id="password" name="password" placeholder="Password" required="required">
                    <button class="buttons" type="submit">Sign up</button>
                </form>
            </div>

            <!-- Login -->
            <div class="login">
                <form method="POST" action="user_login.php">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="text" name="username" placeholder="Username" required="required">
                    <input type="password" name="password" placeholder="Password" required="required">
                    <button class="buttons" type="submit" name="user_login">Login</button>
                </form>
            </div>
        </div>
    </div>

			<!-- Circular button for Admin Login -->
			<a href="javascript:void(0);" class="circle-button" title="Admin Login" id="adminLoginBtn">
				<img src="image/admin.png" alt="Admin Profile">
			</a>

		<!-- Admin Login -->
		<div id="adminLoginModal" class="modal" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
			<div class="modal-content">
				<span class="close" id="closeModal" aria-label="Close">&times;</span>
				<h2 id="modalTitle">Admin Login</h2>
				<form method="POST" action="admin_login.php">
					<input type="text" name="username" placeholder="Admin Username" required="" aria-required="true">
					<input type="password" name="password" placeholder="Admin Password" required="" aria-required="true">
					<button class="buttons" type="submit" name="admin_login">Login</button>
				</form>
			</div>
		</div>


<script>
    var modal = document.getElementById("adminLoginModal");
    var btn = document.getElementById("adminLoginBtn");
    var span = document.getElementById("closeModal");
    // Show the modal when the button is clicked
    btn.onclick = function() {
        modal.style.display = "block";
        modal.setAttribute("aria-hidden", "false");
    }
    // Hide the modal when the close button is clicked
    span.onclick = function() {
        modal.style.display = "none";
        modal.setAttribute("aria-hidden", "true");
    }
    // Close the modal if user clicks outside of the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            modal.setAttribute("aria-hidden", "true");
        }
    }
</script>

</body>
</html>