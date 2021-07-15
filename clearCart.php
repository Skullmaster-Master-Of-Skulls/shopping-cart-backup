<?php

	if (isset($_POST['clearCart'])) {
		// Get user_id
		$user = $_SESSION['user_id'];
		
		// Create and run SQL
		$clearCart_sql = "DELETE FROM cart WHERE (User_ID='$user');";
		@mysqli_query($conn, $clearCart_sql);
		
		// Refresh page to apply changes
		header('Refresh:0');
	}

?>