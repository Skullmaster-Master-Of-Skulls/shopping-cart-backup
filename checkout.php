<?php

	// Start session
	session_start();
	
	// Connect to the Database
	include_once "../resources/database.php";
	
	// Included Library Code (PHP)
	
	// Ensure Admin can't access user page
	include_once "../resources/library/ensure_user.php";
	
	// Remove Single Item Functionality (called by Form)
	include_once "../resources/library/removeItemFromCart.php";
	
	// Clear Cart Functionality (called by Form)
	include_once "../resources/library/clearCart.php";
	
	// Change Cart Item Quantity (called by Form)
	include_once "../resources/library/changeCartQuantity.php";

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
				
    <p><h3>Checkout</h3></p>
            
            <?php
            
                // Get UserID from Session
                $userid = $_SESSION['user_id'];
                // Initialize Total Cost Variable
                $total = 0;
                
                // Retrieve Cart of Logged in User
                $sql = "SELECT * FROM cart WHERE User_ID='$userid';";
                $result = @mysqli_query($conn, $sql);
            
                // If no items in cart, display message indicating such.
                if (@mysqli_num_rows($result) == 0) {
                    echo "<p>Currently no items in Cart</p>";
                }
            ?>
            
            <!-- Display Each Cart Item (Template) -->
            <?php include_once "../resources/templates/cartItem.php"; ?>	

            <!-- Clear Cart -->
            <form  class="inlineForm" action="" method="POST">
                <button id="checkoutClear" type="submit" name="clearCart" value="<?php echo $userID ?>">Clear Cart</button>
            </form>

            <!-- Display Total -->
    <div id="total">
        <!-- This space is where a discount code should be placed if there is one in future requirements-->
        
        <h5><span id="discount">Discount: $0.00 </span> Total: $<?php echo number_format($total,2); ?></h5><br><br>

        <!-- Purchase button -->
        <button id="Purchase" href="Stripe.php">Purchase</button> <!-- add link to stripe page once it is complete-->
    </div>
            
            
            
    </div>
		
    </body>
    <script src="js/scripts.js"></script>		
</html>