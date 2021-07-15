	<?php

		// If user logged in
		if (isset($_SESSION['logged_in'])) {

			// Total number of a single item a user can store in their cart
			// Used in productQuantity.php, AddToCartButton.php, cartItem.php
			$product_limit = 10;

			$inventory = $product['Product_Inventory'];
			$quantity = 1;

			// Determine how many of those items are currently in the users cart
			$user_id = $_SESSION['user_id'];
			$product_id = $product['Product_ID'];
			
			$cart_sql = "SELECT * FROM cart WHERE User_ID = '$user_id' AND Product_ID = '$product_id';";
			$r = @mysqli_query($conn, $cart_sql);
			$cartItem = mysqli_fetch_array($r);
			$numberInCart = $cartItem['Product_Quantity'];
			
			// If Inventory is larger than Product Limit
			if ($inventory > $product_limit) {
				// If Product Limit - Number in User Cart > 0, Display Difference in Options
				if (($product_limit - $numberInCart) > 0) {
					while($quantity <= ($product_limit - $numberInCart)) {
						if ($quantity == 1) {
							echo "<option value='" . $quantity . "' selected>" . $quantity . "</option>";
						} else {
							echo "<option value='" . $quantity . "'>" . $quantity . "</option>";
						}
						$quantity++;
					}
				// Otherwise, Display 0
				} else {
					echo "<option value='0' selected>0</option>";
				}
			// If Inventory or difference between Inventory and Number in Cart is 0, Display 0
			} elseif ($inventory <= 0 || ($inventory - $numberInCart) <= 0) {
				echo "<option value='0' selected>0</option>";
			// If Inventory is Between 1 and $product_limit, Display ($inventory-$numberInCart) options
			} else {
				while($quantity <= ($inventory - $numberInCart)) {
					if ($quantity == 1) {
						echo "<option value='" . $quantity . "' selected>" . $quantity . "</option>";
					} else {
						echo "<option value='" . $quantity . "'>" . $quantity . "</option>";
					}
					$quantity++;
				}
			}

		// If User logged out
		} else {
			
			$product_limit = 10;
			
			// Get Product Inventory
			$inventory = $product['Product_Inventory'];
			$quantity = 1;
			
			// If Inventory >= $product_limit, Display $product_limit options
			if ($inventory >= $product_limit) {
				while($quantity <= $product_limit) {
					if ($quantity == 1) {
						echo "<option value='" . $quantity . "' selected>" . $quantity . "</option>";
					} else {
						echo "<option value='" . $quantity . "'>" . $quantity . "</option>";
					}
					$quantity++;
				}
			// If Inventory is 0, Display 0 options
			} elseif ($inventory <= 0) {
				echo "<option value='0' selected>0</option>";
			// Otherwise, Display as many options needed between 1-10 based on inventory
			} else {
				while($quantity <= $inventory) {
					if ($quantity == 1) {
						echo "<option value='" . $quantity . "' selected>" . $quantity . "</option>";
					} else {
						echo "<option value='" . $quantity . "'>" . $quantity . "</option>";
					}
					$quantity++;
				}
			}
		}

	?>