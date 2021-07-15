<?php

	// Start session
	session_start();

	// Connect to the Database
	include_once "../resources/database.php";


// If already logged in, forward to correct location
if (isset($_SESSION['logged_in'])) {
	if ($_SESSION['admin'] == 1) {
		header('location:admin.php');
	} else {
		header('location:index.php');
	}
}


if (isset($_POST['login'])) {
	$username = mysqli_real_escape_string($conn, trim(strip_tags($_POST['username'])));
	$password = SHA1($_POST['password']);
	
	$sql = "SELECT * FROM user WHERE LOWER(username)=LOWER('$username') AND password='$password';";
	$result = @mysqli_query($conn, $sql);
	
	if (@mysqli_num_rows($result) == 1) {	
		$row = @mysqli_fetch_array($result);
		
		$_SESSION['logged_in'] = true;
		$_SESSION['username'] = $row['Username'];
		$_SESSION['user_id'] = $row['User_ID'];
		$_SESSION['admin'] = $row['Is_Admin'];
		
		if ($_SESSION['admin'] == 1) {
			header('location:admin.php');
		} else {
			header('location:index.php');
		}
		
	} else {
		header('location:index.php?login-failed=true');
	}
}

?>