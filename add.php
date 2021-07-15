<?php

	// Start session
	session_start();

	// Connect to the Database
	include_once "../resources/database.php";
	
	// Ensure User cannot access Admin page
	include_once "../resources/library/ensure_admin.php";

	// Insert Product
	include_once "../resources/library/insert_product.php";
	
?>

<!DOCTYPE html>
<html lang="en">
	<head> 
		<meta charset="UTF-8">
		<title>Iroh's Tea House</title>
		<meta name="viewport" content="width=device-width">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
			  integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	</head>
	<body>

	<div id="addOverlay">
		<!-- nav bar -->
		<?php include_once "../resources/templates/admin_menu.php"; ?>
	
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
			<button type="submit" name="submitted">Submit</button>
		</form>
		
	</div>
	</body>
</html>