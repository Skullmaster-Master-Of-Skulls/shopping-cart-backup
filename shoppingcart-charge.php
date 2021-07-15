<?php
 
	// Start session
	session_start();
	
	// Connect to the Database
	include_once "../database.php";
 
  require_once('config.php');

  $token  = $_POST['stripeToken'];
   
  $totalamt = $_POST['total'];
  
  // echo "Total amt: $totalamt";
  $customer = \Stripe\Customer::create(array(
      'source'  => $token
  ));

  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => $totalamt,
      'currency' => 'cad'
  ));

  $amount = number_format(($totalamt / 100), 2);
	
	// When Payment Successful, Create Order History, Order Details, Receipt (file), then redirect home
	
	// 1. Create Receipt File
	
	// Set Timezone to match Vancouver Time Zone
	date_default_timezone_set("America/Los_Angeles");
	
	// Generate Receipt Name
	$receipt_location = "./receipts/";
	$receipt_name = $_SESSION['username'] . "_" . date('m-d-Y_hia') . "_receipt.txt";
	$receipt_file = $receipt_location . $receipt_name;
	
	// Start Text Content
	$txt = "Iroh's Tea House Receipt for " . $_SESSION['username'] . " on " . date("F j, Y, g:i a") . "\n\n";
	
	// Create File and add content (for each cart item)
	$receipt = fopen($receipt_file, "w");
	
	$user_id = $_SESSION['user_id'];
	$sql = "SELECT * FROM cart WHERE User_ID = '$user_id';";
	$result = @mysqli_query($conn, $sql);
	
	foreach ($result as $cartItem) {
		// Get Product Information and add to Text Content
		$product_sql = "SELECT * FROM product WHERE Product_ID = '$cartItem[Product_ID]';";
		$p_result = @mysqli_query($conn, $product_sql);
		$product = @mysqli_fetch_array($p_result);
		
		$txt .= $cartItem['Product_Quantity'] . " x " . $product['Product_Name'] . " at $" . $product['Product_Price'] . " each.\n";
	}
	
	$txt .= "\nTotal: $" . $amount;
	
	// Write to Receipt
	fwrite($receipt, $txt);
	fclose($receipt);
	
	// 2. Create new order history
	$sql = "INSERT INTO Order_History (User_ID, Order_Date, Order_Status, Order_Information)
					VALUES ('$_SESSION[user_id]', CURRENT_TIMESTAMP(), 'Received', '$receipt_name');";
					
	@mysqli_query($conn, $sql);
	
	// Get most recent Order History for User_ID
	$sql = "SELECT * FROM Order_History WHERE User_ID = '$user_id' ORDER BY Order_ID DESC;";
	$result = @mysqli_query($conn, $sql);
	// Fetching first item of ORDER BY Order_ID DESC will fetch most recent
	$order_history = mysqli_fetch_array($result);
	$order_id = $order_history['Order_ID'];
	
	// 3. Create Order Details (using most recent Order ID)
	
	// Get current cart for User
	$sql = "SELECT * FROM cart WHERE User_ID = '$user_id';";
	$result = @mysqli_query($conn, $sql);
	
	// For each cart item, add item to Order Detail
	foreach ($result as $cartItem) {
		// Get current product price
		$sql = "SELECT * FROM product WHERE Product_ID = '$cartItem[Product_ID]';";
		$p_result = @mysqli_query($conn, $sql);
		$product = @mysqli_fetch_array($p_result);
		
		// Add to Order Detail
		$sql = "INSERT INTO order_detail VALUES ('$order_id', '$cartItem[Product_ID]', '$cartItem[Product_Quantity]', '$product[Product_Price]');";
		@mysqli_query($conn, $sql);
	}
	
	// 4. Adjust Inventory for each Product

	// Get current cart for User
	$sql = "SELECT * FROM cart WHERE User_ID = '$user_id';";
	$result = @mysqli_query($conn, $sql);
	
	// For each cart item, adjust Product Inventory
	foreach ($result as $cartItem) {
		// Get current product inventory
		$sql = "SELECT * FROM product WHERE Product_ID = '$cartItem[Product_ID]';";
		$p_result = @mysqli_query($conn, $sql);
		$product = @mysqli_fetch_array($p_result);
		
		// Adjust Product Inventory (current - items purchased)
		$inv = $product['Product_Inventory'] - $cartItem['Product_Quantity'];
		
		// Update Product Inventory
		$sql = "UPDATE product SET Product_Inventory = '$inv' WHERE Product_ID = '$product[Product_ID]';";
		@mysqli_query($conn, $sql);
	}
	
	// 5. Adjust Cart Quantity if < Product Inventory
	
	// Get current cart for all users
	$sql = "SELECT * FROM cart;";
	$result = @mysqli_query($conn, $sql);
	
	// For each cart item, check if greater than product_inventory, if so, set to product_inventory
	foreach ($result as $cartItem) {
		// Get current product inventory
		$sql = "SELECT * FROM product WHERE Product_ID = '$cartItem[Product_ID]';";
		$p_result = @mysqli_query($conn, $sql);
		$product = @mysqli_fetch_array($p_result);
		
		// If the product Inventory is 0, remove that item from all carts
		if ($product['Product_Inventory'] <= 0) {
			$sql = "DELETE FROM cart WHERE Product_ID = '$cartItem[Product_ID]' AND User_ID = '$cartItem[User_ID]';";
			@mysqli_query($conn, $sql);
		// Else, Set CartItems Quantity to match Product Inventory
		}  elseif ($cartItem['Product_Quantity'] > $product['Product_Inventory']) {
			$sql = "UPDATE cart SET Product_Quantity = '$product[Product_Inventory]' WHERE Product_ID = '$cartItem[Product_ID]';";
			@mysqli_query($conn, $sql);
		}
		
	}
	
	// 6. Clear Cart
	$sql = "DELETE FROM cart WHERE User_ID = '$user_id';";
	@mysqli_query($conn, $sql);
	
	// 7. Set Session variable to recipt file name
	$_SESSION['receipt'] = $receipt_name;
	
	// 8. Redirect back to home page, display payment successful overlay
	header('location:../../public_html/index.php?payment-successful');
	

	

?>