<?php

	if (isset($_POST['removeSubmitted'])) {
		// Get user_id and product_id
		$itemToRemove = $_POST['itemToRemove'];
		$user = $_SESSION['user_id'];
		
		// Create and run SQL
		$removal_sql = "DELETE FROM cart WHERE (User_ID='$user') AND (Product_ID='$itemToRemove');";
		@mysqli_query($conn, $removal_sql);
		
		// Refresh page to apply changes
		header('Refresh:0');
	}

?>