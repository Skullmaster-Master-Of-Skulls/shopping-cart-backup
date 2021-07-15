<?php

// If not logged in, send to login page
if (!isset($_SESSION['logged_in'])) {
	header('location:index.php');
} else {
	// If logged in, but not an admin, send to landing page
	if ($_SESSION['admin'] == 0) {
		header('location:index.php');
	}
}

?>