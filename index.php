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
		<?php include_once "../resources/templates/login_box.php"; ?>

		<!--Content begins here -->
		
		<?php include_once "../resources/library/determineCheckboxes.php" ?>
		
			<div id="content">
				<br>
				
			<!-- Payment Successful overlay -->
			<?php include_once "../resources/templates/paymentsuccess.php" ?>

				<div id="Categories"> <!--Sorting Menu-->
					<form method="POST" action="">
						<input type="checkbox" id="Tea" name="tea[]" <?php if ($teaChecked) { echo "checked='checked'"; } ?>> Tea <br>
						<div id="subcategories">
							<input type="checkbox" id="Tea" name="tea[]" value="herbal" <?php if ($herbalChecked) { echo "checked='checked'"; } ?>> Herbal <br>
							<input type="checkbox" id="Tea" name="tea[]" value="black" <?php if ($blackChecked) { echo "checked='checked'"; } ?>> Black <br>
							<input type="checkbox" id="Tea" name="tea[]" value="green" <?php if ($greenChecked) { echo "checked='checked'"; } ?>> Green <br>
							<input type="checkbox" id="Tea" name="tea[]" value="oolong" <?php if ($oolongChecked) { echo "checked='checked'"; } ?>> Oolong <br>
							<input type="checkbox" id="Tea" name="tea[]" value="white" <?php if ($whiteChecked) { echo "checked='checked'"; } ?>> White <br>
							<input type="checkbox" id="Tea" name="tea[]" value="iced" <?php if ($icedChecked) { echo "checked='checked'"; } ?>> Iced <br>
						</div>
						<input type="checkbox" name="coffee[]" <?php if ($coffeeChecked) { echo "checked='checked'"; } ?>> Coffee <br>
						<button type="submit" name="submitted">Apply</button><br>
					</form>	
				</div>
			
				<div id="products"> <!--Cards/Products-->
				
					<!-- Login Failed Message -->
					<?php include_once "../resources/templates/loginfailed.php"; ?>
					<!-- Login Request Message -->
					<?php include_once "../resources/templates/login-request.php"; ?>
					<!-- Account Created Message -->
					<?php include_once "../resources/templates/createaccountsuccess.php"; ?>
					<!-- Policy Declined Message -->
					<?php include_once "../resources/templates/policy-declined.php"; ?>
				
					<!-- Sort functionality (SQL Query generation) -->
					<?php include_once "../resources/library/sortProducts.php"; ?>
					
					<!-- For each product returned from the query, add to page inside 'card -->
					<?php foreach ($result as $product): ?>
						<div class="card">
							<img src="../resources/img/products/<?php echo $product['Product_Image']; ?>" alt="Tea/Coffee image here" style="width:100%">
							<div class="container">
								<h4><b><?php echo $product['Product_Name'];?></b></h4>
								<h5><?php echo "$" . $product['Product_Price'];?></h5>
								<!-- Display only first 21 words of description -->
								<p><?php echo substr($product['Product_Description'], 0, 100) . "..."; ?></p>
								
								<!-- Add to Cart Button / Quantity -->
								<form action="addToCart.php" method="POST">
									<input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">
									<!-- Add to Cart / Out of Stock Button -->
									<?php include "../resources/templates/AddToCartButton.php"; ?>
									<label for="quantity">Quantity:</label>
									<select name="quantity" id="quantity">
										<!-- Quantity Options -->
										<?php include "../resources/templates/productQuantity.php"; ?>
									</select>
								</form>
								
							</div>				
						</div>
					<?php endforeach; ?>
				
				</div>
				
			</div>

		<!--Footer-->
		<?php include_once "../resources/templates/footer.php"; ?>
	</body>
	
	<script src="js/scripts.js"></script>

</html>