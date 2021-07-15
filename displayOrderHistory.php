<!-- For each order history... -->
<?php foreach ($result as $orderHistory): ?>


	<?php
		// Create total variable, initialize to 0
		$total = 0;
	?>

	<?php 
		// Get each purchased item from the current order history
		$sql = "SELECT * FROM order_detail WHERE order_id = '$orderHistory[Order_ID]';";
		$order_detail_result = @mysqli_query($conn, $sql);
		

	?>
		
	<h5>Date of Order: <span class="small-text"><?php echo $orderHistory['Order_Date']; ?></span></h5>		
		
	<!-- For each Order Detail (item) -->	
	<?php foreach ($order_detail_result as $orderDetail): ?>
		<div id="orderHistoryItem">
			<?php
				// Make SQL call to retrieve product information
				$sql = "SELECT * FROM product WHERE Product_ID='$orderDetail[Product_ID]';";
				$product = mysqli_fetch_array(@mysqli_query($conn, $sql));
				
				// Calculate Cost (Price * Quantity)
				$itemCost = $orderDetail['Price'] * $orderDetail['Product_Quantity'];
				// Add Cost to Total
				$total += $itemCost;
			?>
			
			<!-- Display Product Image -->
			<img src="../resources/img/products/<?php echo $product['Product_Image']; ?>" class="CartItemImg"></img>
			
			<!-- Display Product name -->
			<span class="ProductName"><?php echo $product['Product_Name']; ?></span>   
			
			<!-- Display selected item quantity -->
			<label>Quantity # <?php echo $orderDetail['Product_Quantity']; ?></label> 
			
			<!-- Display Cost -->
			<!-- nbsp used to space price further from Quantity -->
			<span class="CartItemPrice"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$" . number_format($itemCost, 2); ?></span>
		</div>
	<?php endforeach; ?>
	
	<!-- Display Total -->
	<div id="total">
			<!-- This space is where a discount code should be placed if there is one in future requirements-->
			<h5><span id="discount">Discount: $0.00 </span> Total: $<?php echo number_format($total,2); ?></h5><br><br>
	</div><br>
	
<?php endforeach; ?>