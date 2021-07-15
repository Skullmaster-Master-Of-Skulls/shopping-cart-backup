<?php

// If logged in, ensure user has accepted privacy policy
if (isset($_SESSION['logged_in'])) {
	$userid = $_SESSION['user_id'];
	$sql = "SELECT * FROM User WHERE User_ID = '$userid';";
	$r = @mysqli_query($conn, $sql);
	$user = mysqli_fetch_array($r);
	
	if ($user['Accepted_Policy'] == 0) {
		header('location:privacypolicy.php');
	}
}

?>