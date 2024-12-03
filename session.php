<?php
	session_start();
	// Check if both 'id' and 'user_id' are set in the session
	if (!isset($_SESSION['id']) || !isset($_SESSION['user_id'])) {
		header('Location: index.php');
		exit();
	}
?>
