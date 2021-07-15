<?php

// If logged in, but an admin, send to admin page
if (isset($_SESSION['logged_in'])) {
	if ($_SESSION['admin'] == 1) {
		header('location:admin.php');
	}
}

?>