<?php
	
	// Start session
	session_start();

	// Connect to the Database
	include_once "../resources/database.php";
	
	// Ensure User cannot access Admin page
	include_once "../resources/library/ensure_admin.php";
	
	if (isset($_POST['submitted'])) {
		$productToRemove = $_POST['product_id'];
		
		// First, remove product from user carts
		$sql = "DELETE FROM cart WHERE Product_ID='$productToRemove';";
		mysqli_query($conn, $sql);

		// Next, set Is_Active of the product to 0 (discontinued)
		$sql = "UPDATE product SET Is_Active=0 WHERE Product_ID='$productToRemove';";
		mysqli_query($conn, $sql);

	}
	
	// Return to admin page
	header('location:admin.php');
	
?>