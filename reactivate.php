<?php
	
	// Start session
	session_start();

	// Connect to the Database
	include_once "../resources/database.php";
	
	// Ensure User cannot access Admin page
	include_once "../resources/library/ensure_admin.php";
	
	if (isset($_POST['submitted'])) {
		$productToActivate = $_POST['product_id'];

		// Set Is_Active to 1 (active)
		$sql = "UPDATE product SET Is_Active=1 WHERE Product_ID='$productToActivate';";
		mysqli_query($conn, $sql);

	}
	
	// Return to admin page
	header('location:admin.php');
	
?>