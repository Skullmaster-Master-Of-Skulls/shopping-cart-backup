<?php
	// Runs on form submission
	if(isset($_POST['submitted-add-product']))
	{
        $name = mysqli_real_escape_string($conn, trim(strip_tags($_POST["prodName"])));
        $desc = mysqli_real_escape_string($conn, trim(strip_tags($_POST["prodDesc"])));
        $cat = mysqli_real_escape_string($conn, trim(strip_tags($_POST["prodCat"])));
        $subcat = mysqli_real_escape_string($conn, trim(strip_tags($_POST["prodSubcat"])));
        $price = mysqli_real_escape_string($conn, trim(strip_tags($_POST["prodPrice"])));
        $regCheck = '/["]+/';
				
        $image_file = $_FILES['prodImage'];
        $image = mysqli_real_escape_string($conn, $image_file['name']);

        $sql = "SELECT product_name
                FROM irohsteahouse.product
                WHERE LOWER(product_name) = LOWER('$name')";
        $result = @mysqli_query($conn, $sql);


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
						header('refresh:0');
        }
        else if(mysqli_num_rows($result) > 0)
        {
            echo '<script type="text/javascript">';
            echo 'alert("Item already exists in database.");';
            echo '</script>';
						header('refresh:0');
        }
        else if(!is_numeric($inv))
        {
            echo '<script type="text/javascript">';
            echo 'alert("Quantity must be a number.");';
            echo '</script>';
						header('refresh:0');
        }
        else if(!is_numeric($price))
        {
            echo '<script type="text/javascript">';
            echo 'alert("Price must be a number.  Do not include dollar sign.");';
            echo '</script>';
						header('refresh:0');
        }
        else if((preg_match($regCheck, $name)) || (preg_match($regCheck, $desc)))
        {
            echo '<script type="text/javascript">';
            echo 'alert("Name and description cannot contain double quotes.");';
            echo '</script>';
						header('refresh:0');
        }
    // If all tests pass, the input is considered to be valid and is uploaded to the database
        else
        {
            $imagePath = "../resources/img/products/" . $image;
            move_uploaded_file($image_file['tmp_name'], $imagePath);
					
            $sql = "INSERT INTO Product (Product_Name, Product_Description, Product_Image, Product_Price,
                        Product_Inventory, Category_ID, Subcategory_ID, IS_Active)
                    VALUES ('$name', '$desc', '$image', $price, $inv, $cat, $subcat, 1);";
            $result = @mysqli_query($conn, $sql);
            header('location:admin.php');
        }
	}

?>