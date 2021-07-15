	<?php
	
		// If user logged in
		if (isset($_SESSION['logged_in'])) {

			// Total number of a single item a user can store in their cart
			// Used in productQuantity.php, AddToCartButton.php, cartItem.php
			$product_limit = 10;

			// Get Product Inventory
			$inventory = $product['Product_Inventory'];

			// Determine how many of those items are currently in the users cart
			$user_id = $_SESSION['user_id'];
			$product_id = $product['Product_ID'];
			
			$cart_sql = "SELECT * FROM cart WHERE User_ID = '$user_id' AND Product_ID = '$product_id';";
			$r = @mysqli_query($conn, $cart_sql);
			$cartItem = mysqli_fetch_array($r);
			$numberInCart = $cartItem['Product_Quantity'] ?? 0;
			
			// If inventory - Number in User Cart is 0, display Out of Stock
			if (($inventory - $numberInCart) <= 0) {
				echo "<button disabled>Out of Stock</button>";
			// If Number in Cart matches Product Limit, display Limit Reached
			} elseif ($numberInCart == $product_limit) {
				echo "<button disabled>Limit Reached</button>";
			// Else, Display Add to Cart
			} else {
				echo "<button type='submit' name='addToCart'>Add to cart</button>";
			}
			
		// If user logged out	
		} else {
			
			// Get Product Inventory
			$inventory = $product['Product_Inventory'];
			
			// If inventory is 0, display Out of Stock
			if ($inventory <= 0) {
				echo "<button disabled>Out of Stock</button>";
			} else {
				echo "<button type='submit' name='addToCart'>Add to cart</button>";
			}
		}
	
	?>