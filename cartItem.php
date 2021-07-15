<?php foreach ($result as $cartitem): ?>
	<div id="Cartitem">
			<?php
				// Make SQL call to retrieve product information
				$sql = "SELECT * FROM product WHERE Product_ID='$cartitem[Product_ID]';";
				$product = mysqli_fetch_array(@mysqli_query($conn, $sql));
				
				// Calculate Cost (Price * Quantity)
				$itemCost = $product['Product_Price'] * $cartitem['Product_Quantity'];
				// Add Cost to Total
				$total += $itemCost;
			?>
			
			<!-- Display Product Image -->
			<img src="../resources/img/products/<?php echo $product['Product_Image']; ?>" class="CartItemImg"></img>
			
			<!-- Display Product name -->
			<span class="ProductName"><?php echo $product['Product_Name']; ?></span>   
			
			<!-- Display selected item quantity -->
			<label for="QuantitySelect">Quantity # </label> 
			
			<!-- Change Quantity upon selection of new quantity -->
			<form class="inlineForm" action="" method="POST">
				<select name="CartQuantity" class="CartQuantity" onchange="this.form.submit()"> <!-- change quantity in cart-->
					<?php
						// Create up to $product_limit dropdown options. If less than $product_limit in inventory, stop there.
						// Add 'selected' to the option which matches number in cart
						$quantity = 1;
						$inventory = $product['Product_Inventory'];
								
						// Total number of a single item a user can store in their cart
						// Used in productQuantity.php, AddToCartButton.php, cartItem.php					
						$product_limit = 10;
						
						if ($inventory >= $product_limit) {
							while($quantity <= $product_limit) {
								if ($quantity == $cartitem['Product_Quantity']) {
									echo "<option value='" . $quantity . "' selected>" . $quantity . "</option>";
								} else {
									echo "<option value='" . $quantity . "'>" . $quantity . "</option>";
								}
								$quantity++;
							}
						} else {
							while($quantity <= $inventory) {
								if ($quantity == $cartitem['Product_Quantity']) {
									echo "<option value='" . $quantity . "' selected>" . $quantity . "</option>";
								} else {
									echo "<option value='" . $quantity . "'>" . $quantity . "</option>";
								}
								$quantity++;
							}
						}
					?>
				</select>
				<input type="hidden" name="product" value="<?php echo $product['Product_ID']; ?>">
				<input type="hidden" name="changeQuantity">
			</form>
			
			<!-- Display Cost -->
			<span class="CartItemPrice"><?php echo "$" . number_format($itemCost, 2); ?></span> <!-- Display Product Cost -->
			
			<!-- Remove From Cart Button -->
			<form class="inlineForm" action="" method="POST">
				<input type="hidden" name="itemToRemove" value="<?php echo $product['Product_ID']; ?>">
				<button name="removeSubmitted" class="RemoveItemButton">X</button>
			</form>
	</div>
<?php endforeach; ?>