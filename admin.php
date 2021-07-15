<?php
	
	// Start session
	session_start();

	// Connect to the Database
	include_once "../resources/database.php";
	
	// Ensure User cannot access Admin page
	include_once "../resources/library/ensure_admin.php";

	// Insert Product
	include_once "../resources/library/insert_product.php";
	
	// Insert Product
	include_once "../resources/library/edit_product.php";

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
		<?php include_once "../resources/templates/admin_menu.php"; ?>

		<!--Content begins here -->
		
		<?php include_once "../resources/library/determineCheckboxes.php" ?>
		
			<div id="content">
				<br>

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
				
					<!-- Add sort functionality (SQL Query generation) -->
					<?php include_once "../resources/library/sortProductsAdmin.php"; ?>
					
					<!-- For each product returned from the query, add to page inside 'card -->
					<?php foreach ($result as $product): ?>
						<div class="card">
							<img src="../resources/img/products/<?php echo $product['Product_Image']; ?>" alt="Tea/Coffee image here" style="width:100%">
							<div class="container">
								<h4><b><?php echo $product['Product_Name'];?></b></h4>
								<h5><?php echo "$" . $product['Product_Price'];?></h5>
								<!-- Display only first 18 words of description -->
								<p><?php echo substr($product['Product_Description'], 0, 100) . "..."; ?></p>
								<div id="adminButtons">
	<!-- Edit item popup-->		<form action="edit.php" id="editItemButton" method="GET"><!-- This part needs to be changed to not pass data to a separate page-->
								    <input type="hidden" name="productID" value="<?php echo $product['Product_ID']; ?>">
								    <button type="submit" name="submitted">Edit item</button>
								</form>
									<!-- Remove or Reactivate Item Displayed depending on it's current status -->
									<?php if ($product['Is_Active'] == 1):  ?>
										<form action="remove.php" method="POST">
											<input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">
											<button name="submitted">Remove</button>
										</form>
									<?php endif; ?>
									<?php if ($product['Is_Active'] == 0):  ?>
										<form action="reactivate.php" method="POST">
											<input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">
											<button name="submitted">Reactivate</button>
										</form>
									<?php endif; ?>
								</div>
							</div>				
						</div>
					<?php endforeach; ?>
				
				</div>
				
			</div>

		<div id="overlay"></div>

		<div id="addOverlay">
			<form id="Additem" action="" method="post" enctype="multipart/form-data">
				<p id="AddItemTitle"><h3>Add item</h3></p>

				<label for="AddItemName">Item Name: </label>
				<input type="text" id="AddItemName" name="prodName" required><br>

				<p id="LabelForTextArea">Item Description: </p>
				<textarea id="AddItemDescription" name="prodDesc" required></textarea><br>

				<label for="AddItemCategory">Category:</label>
				<select id="AddItemCategory" name="prodCat">
					<option value="2">Tea</option>
					<option value="1">Coffee</option>
				</select>
				<label for="AddItemSubcategory">Subcategory (if applicable):</label> <!--hide if coffee is selected?-->
				<select id="AddItemSubcategory" name="prodSubcat">
					<option value="0">None</option>
					<option value="1">Herbal</option>
					<option value="2">Black</option>
					<option value="3">Green</option>
					<option value="4">Oolong</option>
					<option value="5">White</option>
					<option value="6">Iced</option>
				</select><br>

				<label for="AddItemPrice">Price: </label>
				<input type="text" id="AddItemPrice" name="prodPrice" required><br>

				<label for="AddItemQuantity">Quantity in stock: </label>
				<input type="text" id="AddItemQuantity" name="prodQuantity"><br>

				<input id="AddItemImage" type="file" action="" name="prodImage" required><br> <!--on submit of image display preview image in next img tag-->
				<!-- <img id="AddItemPreviewImage" src="../resources/img/products/Placeholder_Image.png" alt="No Image Selected"> -->
				<button type="submit" name="submitted-add-product">Submit</button>
			</form>
		</div>

		<!--Footer-->
		<?php include_once "../resources/templates/footer.php"; ?>
	</body>

	
	<script src="js/scripts.js"></script>
</html>