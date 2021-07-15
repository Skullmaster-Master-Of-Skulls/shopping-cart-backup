<?php
	// Runs on form submission
	if(isset($_POST['update']))
	{
				// Pulls the product_id from the page and runs a query to obtain that product's information
				$productID = $_POST['productID'];
				$sql = "SELECT Product_Name, Product_Description, Product_Image, Product_Price, Product_Inventory, category_ID, subcategory_ID
									FROM irohsteahouse.product
									WHERE LOWER(product_ID) = '$productID'";
        $result = @mysqli_query($conn, $sql);
				$product = mysqli_fetch_array($result);
		
        $name = mysqli_real_escape_string($conn, trim(strip_tags($_POST["prodName"])));
        $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST["prodDesc"])));
        $cat = mysqli_real_escape_string($conn, trim(strip_tags($_POST["prodCat"])));
        $subcat = mysqli_real_escape_string($conn, trim(strip_tags($_POST["prodSubcat"])));
        $price = mysqli_real_escape_string($conn, trim(strip_tags($_POST["prodPrice"])));
        $regCheck = '/["]+/';
				
				// Collects Image from Global $_FILES variable
        $image_file = $_FILES['prodImage'];
				
				// If null, no new photo was added, thus use original product photo
				if ($image_file['name'] == null) {
					$image = $product['Product_Image'];
				} else {
				// If new photo was uploaded, use new photo
					$image = mysqli_real_escape_string($conn, $image_file['name']);
				}


    // Assigns a value to the quantity if none is entered (default is 0)
        if(isset($_POST["prodQuantity"]))
        {
            $inv = mysqli_real_escape_string($conn, trim(strip_tags($inv = $_POST["prodQuantity"])));
        }
        else
        {
            $inv = 0;
        }
    // Coffee must have no subcategory
        if ($cat == 1)
        {
            $subcat = 0;
        }
    // Several statements check for invalid input
        if (($cat == 2) && ($subcat == 0))
        {
            echo '<script type="text/javascript">';
            echo 'alert("Tea must have a subcategory.");';
            echo '</script>';
        }
        else if(!is_numeric($inv))
        {
            echo '<script type="text/javascript">';
            echo 'alert("Quantity must be a number.");';
            echo '</script>';
        }
        else if(!is_numeric($price))
        {
            echo '<script type="text/javascript">';
            echo 'alert("Price must be a number.  Do not include dollar sign.");';
            echo '</script>';
        }
        else if((preg_match($regCheck, $name)) || (preg_match($regCheck, $desc)))
        {
            echo '<script type="text/javascript">';
            echo 'alert("Name and description cannot contain double quotes.");';
            echo '</script>';
        }
    // If all tests pass, the input is considered to be valid and is uploaded to the database
        else
        {
            $imagePath = "../resources/img/products/" . $image;
            move_uploaded_file($image_file['tmp_name'], $imagePath);

            $sql = "UPDATE Product
                    SET Product_Name = '$name', Product_Description= '$desc', Product_Image = '$image',
                        Product_Price = '$price', Product_Inventory = '$inv', Category_ID = '$cat', Subcategory_ID = '$subcat'
                    WHERE product_ID = '$productID';";
            $result = @mysqli_query($conn, $sql);
            header('location:admin.php');
        }
	}

?>