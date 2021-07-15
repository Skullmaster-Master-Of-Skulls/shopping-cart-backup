<?php

	// Start session
	session_start();
	
	// Connect to the Database
	include_once "../resources/database.php";
	
	// Ensure Admin can't access user page
	include_once "../resources/library/ensure_user.php";
	
	// Ensure User has accepted privacy policy
	include_once "../resources/library/ensure_privacypolicy.php";

?>

<!DOCTYPE html>
<html lang="en">
	<head> 
		<meta charset="UTF-8">
		<title>Iroh's Tea House</title>
		<meta name="viewport" content="width=device-width">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
	</head>
	<body>
		
    <!-- nav bar -->
    <?php include_once "../resources/templates/user_menu.php"; ?>	
    <br>
		
    <!--Content begins here -->
    <div id="content">
				
    <p><h2>Order History</h2></p><br>
        
			<div class="anOrder">
			
					<?php
					
							// Get UserID from Session
							$userid = $_SESSION['user_id'];
							
							// Retrieve Order History of Logged in User
							$sql = "SELECT * FROM order_history WHERE User_ID='$userid' ORDER BY Order_Date DESC;";
							$result = @mysqli_query($conn, $sql);
					
							// If no order history, display message indicating such.
							if (@mysqli_num_rows($result) == 0) {
									echo "<p>Currently no Order History.</p>";
							}
					?>
					
					<!-- Display Each Order History (Template) -->
					<?php include "../resources/templates/displayOrderHistory.php"; ?>	

			</div>
			
    </div>
		
    </body>		
</html>