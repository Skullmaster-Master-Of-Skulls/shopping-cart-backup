<?php

	// Start session
	session_start();
	
	// Connect to the Database
	include_once "../resources/database.php";

	
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
	<?php include_once "../resources/templates/simple_menu.php"; ?>	

	<!--Content begins here -->
	<div id="overlay"></div>
	<div id="overlaybutton2">
		<a id="returnlink" href="../public_html/index.php"></a>
	</div>
	<form id="CreateAccountForm" action="" method="POST">
	
	
		<?php
		
				// Declare necessary variables, used for sticky form
				$username = "";
				$password = "";
				$firstname = "";
				$lastname = "";
				$email = "";
				$street = "";
				$city = "";
				$postal = "";
				$phone = "";
				$errors = [];
		
			if (isset($_POST['submitted-create-account'])) {
				
				// Get values from form, and sanitize input
				$username = mysqli_real_escape_string($conn, trim(strip_tags($_POST['UsernameC'])));
				$passwordLength = strlen($_POST['PasswordC']);
				$password = SHA1($_POST['PasswordC']);
				$firstname = mysqli_real_escape_string($conn, trim(strip_tags($_POST['FirstnameC'])));
				$lastname = mysqli_real_escape_string($conn, trim(strip_tags($_POST['LastnameC'])));
				$email = mysqli_real_escape_string($conn, trim(strip_tags($_POST['EmailC'])));
				$street = mysqli_real_escape_string($conn, trim(strip_tags($_POST['StreetC'])));
				$city = mysqli_real_escape_string($conn, trim(strip_tags($_POST['CityC'])));
				$postal = mysqli_real_escape_string($conn, trim(strip_tags($_POST['PostalcodeC'])));
				$phone = mysqli_real_escape_string($conn, trim(strip_tags($_POST['PhonenumberC'])));
				
				// Regex for various inputs
				$usernamePattern = "/^[a-z0-9][a-z0-9][a-z0-9][a-z0-9]*$/i";
				$firstnamePattern = "/^[a-z][a-z][a-z]*[\-\s]?[a-z]*$/i";
				$lastnamePattern = "/^[a-z][a-z][a-z]*[\-\s]?[a-z]*$/i";
				$streetPattern = "/^[a-z0-9\s][a-z0-9\s][a-z0-9\s][a-z0-9\s]*$/i";
				$cityPattern = "/^[a-z][a-z\s\-][a-z\s\-]*$/i";
				$postalPattern = "/^[a-z][0-9][a-z][\s][0-9][a-z][0-9]$/i";
				$phonePattern = "/^[0-9][0-9][0-9][\-][0-9][0-9][0-9][\-][0-9][0-9][0-9][0-9]$/i";
				
				// Check for Regex and Length errors
				if (!preg_match($usernamePattern, $username)) {
					$errors[] = "Username must be a minimum of 3 characters, only consisting of letters and numbers.";
				}
				
				if ($passwordLength < 6) {
					$errors[] = "Password must be at least 6 characters";
				}
				
				if (!preg_match($firstnamePattern, $firstname)) {
					$errors[] = "First name must be a mimimum of 2 characters, begin with a letter, and the only possible special characters are spaces and hypens.";
				}
				
				if (!preg_match($lastnamePattern, $lastname)) {
					$errors[] = "Last name must be a mimimum of 2 characters, begin with a letter, and the only possible special characters are spaces and hypens.";
				}
				
				if (!preg_match($streetPattern, $street)) {
					$errors[] = "Street can only consist of Letters, Numbers, and Spaces, and must be longer than 3 characters.";
				}
				
				if (!preg_match($cityPattern, $city)) {
					$errors[] = "City name must be a minimum of 2 characters, and the only possible special characters are spaces and hypens.";
				}
				
				if (!preg_match($postalPattern, $postal)) {
					$errors[] = "Postal Code must be in the form of LNL NLN (Example: A0A 0A0)";
				}
				
				if (!preg_match($phonePattern, $phone)) {
					$errors[] = "Phone number must be in the form of 555-555-5555";
				}
				
				if (strlen($username) > 32 ||
						strlen($firstname) > 32 ||
						strlen($lastname) > 32 ||
						strlen($email) > 32 ||
						strlen($street) > 32 ||
						strlen($city) > 32 ) {
							
					$errors[] = "No field (other than password) can be greater than 32 characters.";
					
				}
				
				// If no errors, run SQL
				if(empty($errors)) {
					// First check username doesn't already exist
					$sql = "SELECT * FROM user WHERE LOWER(Username)=LOWER('$username');";
					
					$result = @mysqli_query($conn, $sql);
					
					if (mysqli_num_rows($result) >= 1) {
						$errors[] = "Username already exists";
					} else {
					// If it doesn't, add user to database
						$sql = "INSERT INTO User (Username, Password, Is_Admin, First_Name, Last_Name, Email, Street, City, Zip, Phone_Number, Accepted_Policy) VALUES ('$username', '$password', 0, '$firstname', '$lastname', '$email', '$street', '$city', '$postal', '$phone', 1);";
						@mysqli_query($conn, $sql);
						header('location:index.php?account-created-successfully');
					}
	
				}
				
			}
		
		?>
	
		<p><h2>Create Account</h2></p>
		
		<!-- Display Errors -->
		<?php if (!empty($errors)): ?>
			<ul>
				<?php foreach ($errors as $error):?>
					<li><?php echo $error ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<!-- Form is 'sticky'. Remove slashes \ if generated by mysqli -->
		<label for="UsernameC">Username: </label>
		<input type="text" id="UsernameC" name="UsernameC" value="<?php echo str_replace("\\", "", $username) ?>" required><br>
		
		<label for="PasswordC">Password: </label>
		<input type="password" id="PasswordC" name="PasswordC" value="" required><br>
		
		<label for="FirstnameC">First Name: </label>
		<input type="text" id="FirstnameC" name="FirstnameC" value="<?php echo str_replace("\\", "", $firstname) ?>" required><br>
		
		<label for="LastnameC">Last Name: </label>
		<input type="text" id="LastnameC" name="LastnameC" value="<?php echo str_replace("\\", "", $lastname) ?>" required><br>
		
		<label for="EmailC">Email: </label>
		<input type="email" id="EmailC" name="EmailC" value="<?php echo str_replace("\\", "", $email) ?>" required><br>
		
		<label for="StreetC">Street: </label>
		<input type="text" id="StreetC" name="StreetC" value="<?php echo str_replace("\\", "", $street) ?>" required><br>
		
		<label for="CityC">City: </label>
		<input type="text" id="CityC" name="CityC" value="<?php echo str_replace("\\", "", $city) ?>" required><br>
		
		<label for="PostalcodeC">Postal Code: </label>
		<input type="text" id="PostalcodeC" name="PostalcodeC" value="<?php echo str_replace("\\", "", $postal) ?>" required><br>

		<label for="PhonenumberC">Phone Number: </label>
		<input type="text" id="PhonenumberC" name="PhonenumberC" value="<?php echo str_replace("\\", "", $phone) ?>" required><br>

		<br>

		<input type="checkbox" id="PrivacyPolicyCheckbox" name="PrivacyPolicy" required>
		<label for="PrivacyPolicyCheckbox">I have read and agree to Iroh's Tea House's <a href="privacypolicy.php" target="_blank">Privacy Policy</a></label>
		
		<br><br>

		<button type="submit" name="submitted-create-account">Submit</button>
	</form>

	
	<div id="content">
	<?php include_once "../resources/library/determineCheckboxes.php" ?>
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
			
	</body>	
	<?php include_once "../resources/templates/footer.php"; ?>
</html>