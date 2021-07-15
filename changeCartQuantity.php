<?php

	if (isset($_POST['changeQuantity'])) {
		// Get User ID, Product_ID, New Quantity
		$user_id = $_SESSION['user_id'];
		$product_id = $_POST['product'];
		$newQuantity = $_POST['CartQuantity'];
		
		// Generate and Run Update SQL
		$changeQuantity_sql = "UPDATE cart SET Product_Quantity='$newQuantity' WHERE (User_ID = '$user_id') AND (Product_ID = '$product_id');";
		@mysqli_query($conn, $changeQuantity_sql);
	}

?>