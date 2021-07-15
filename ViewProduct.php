<?php

	// Start session
	session_start();
	
	// Connect to the Database
	include_once "../resources/database.php";
	
	// Ensure Admin can't access user page
	include_once "../resources/library/ensure_user.php";

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

        <div id="overlay"></div>
        <div id="ViewItem">
        <button id="x">X</button>
            <img src="../resources/img/products/Placeholder_Image.png" id="ProductImage"></img>
           
            <p id="ProductDescription">hhhhhhhhhhhhhhhhhhhhhhh
                hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
                hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
                hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
            </p>
            <button id="addtocart"> Add to Cart</button>
            <span id="InStock"> Quantity:</span>
            <select name="quantity" id="quantity"> <!-- change select based on quantity in DB-->
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
            
        </div>






    </body>
    <script src="js/scripts.js"></script>
</html>


