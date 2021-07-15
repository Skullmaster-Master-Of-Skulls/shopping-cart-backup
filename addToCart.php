<?php

	// Start session
	session_start();
	
	// Connect to the Database
	include_once "../resources/database.php";
	
	// Ensure Admin can't access user page
	include_once "../resources/library/ensure_user.php";
	
	// Ensure User is logged in
	if ($_SESSION['logged_in']) {
		
		if (isset($_POST['addToCart'])) {
			// Gather userid, productid, item quantity
			$user_id = $_SESSION['user_id'];
			$productToAdd = $_POST['product_id'];
			$quantityToAdd = $_POST['quantity'];

			// Check if the item exists in the cart
			$sql = "SELECT * FROM cart WHERE User_ID = '$user_id' AND Product_ID = '$productToAdd';";		
			$result = @mysqli_query($conn, $sql);

			// If it exists, update the cart, adding the new quantity to the existing in cart
			if(mysqli_num_rows($result) > 0)
			{
				$cartItem = @mysqli_fetch_array($result);
				
				$quantityToAdd += $cartItem['Product_Quantity'];
				$sql = "UPDATE cart SET Product_Quantity = '$quantityToAdd' WHERE User_ID = '$user_id' AND Product_ID = '$productToAdd';";
				@mysqli_query($conn, $sql);
				
				// Redirect to Cart Page
				header('location:Cart.php');
			
			}
			// Else, insert new line into cart
			else
			{
				$sql = "INSERT INTO cart VALUES('$user_id', '$productToAdd', '$quantityToAdd');";
				@mysqli_query($conn, $sql);
				
				// Redirect to Cart Page
				header('location:Cart.php');
			}
		}
		
	} else {
		// If user isn't logged in, redirect back to index page, and prompt to login
		header('location:index.php?please-login');
	}

?>