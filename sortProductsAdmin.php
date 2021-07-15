	<?php
	
		/* Written by Hudson T. */
	
		/*
		
		Categories:
		1. Coffee
		2. Tea
		
		Subcategories:
		1. Herbal
		2. Black
		3. Green
		4. Oolong
		5. White
		6. Iced
		
		*/
		
		$concat = false;        // Used to know if Concatenation of Category necessary in query
		$subConcat = false;     // Used to know if Concatenation of Subcategory necessary in query
		$teaSelected = false;
		$coffeeSelected = false;
		$subcategoryUsed = false;
		$sql = "";
	
		// If no POST is received on page load (OR) POST is recieved, but empty except
		// for submit button (no checkboxes were checked), then display ALL products
	
		// count($_POST) checks if name="submitted" is the only item in $_POST
		
		if(!isset($_POST['submitted']) || count($_POST) == 1) {
			
			$sql = "SELECT * FROM product;";
			
		} else {
			
		// Else, build a custom SQL query to match selected checkboxes
		
			// Determine if Tea, Coffee (or their a subcategory of them) has been selected
		
			if (isset($_POST['tea'])) {
				$teaSelected = true;
				//echo "Tea selected <br>";
			}
			
			if (isset($_POST['coffee'])) {
				$coffeeSelected = true;
				//echo "Coffee selected <br>";
			}
			
			// Start the SQL Query to be built upon
			$sql = "SELECT * FROM product";
			
			// Build upon the query depending on which boxes were checked
			
			if ($teaSelected) {
				$sql .= " WHERE ((category_id = 2";
				$concat = true;
				$teaSelected = true;
				$sql .= ")";
			}
			
			// Determine whether Subcategories were used, if so, add "AND"
			
			if ($teaSelected) {
				if (in_array('herbal', $_POST['tea']) ||
						in_array('black', $_POST['tea']) ||
						in_array('green', $_POST['tea']) ||
						in_array('oolong', $_POST['tea']) ||
						in_array('white', $_POST['tea']) ||
						in_array('iced', $_POST['tea'])) {
						
						$sql .= " AND (";
						$subcategoryUsed = true;
				}
			}
			
			// Add subquery conditions
			if($teaSelected) {
				if (in_array('herbal', $_POST['tea'])) {
					$sql .= "subcategory_id = 1";
					$subConcat = true;
				}
				
				if (in_array('black', $_POST['tea'])) {
					if ($subConcat) {
						$sql .= " OR subcategory_id = 2";
					} else {
						$sql .= "subcategory_id = 2";
						$subConcat = true;
					}
				}
				
				if (in_array('green', $_POST['tea'])) {
					if ($subConcat) {
						$sql .= " OR subcategory_id = 3";
					} else {
						$sql .= "subcategory_id = 3";
						$subConcat = true;
					}
				}
				
				if (in_array('oolong', $_POST['tea'])) {
					if ($subConcat) {
						$sql .= " OR subcategory_id = 4";
					} else {
						$sql .= "subcategory_id = 4";
						$subConcat = true;
					}
				}
				
				if (in_array('white', $_POST['tea'])) {
					if ($subConcat) {
						$sql .= " OR subcategory_id = 5";
					} else {
						$sql .= "subcategory_id = 5";
						$subConcat = true;
					}
				}
				
				if (in_array('iced', $_POST['tea'])) {
					if ($subConcat) {
						$sql .= " OR subcategory_id = 6";
					} else {
						$sql .= "subcategory_id = 6";
						$subConcat = true;
					}
				}
			}
			
			// Add necessary closing brackets
			if ($subcategoryUsed) {
				$sql .= "))";
			} elseif ($teaSelected) {
				$sql .= ")";
			}
			
			// Add coffee query (if required)
			if ($coffeeSelected) {
				if ($concat) {
					$sql .= " OR (category_id = 1)";
				} else {
					$sql .= " WHERE (category_id = 1)";
					$concat = true;
				}
			}
			
			/*
			NOTE: No subquery work for coffee has been done at this point.
			Will add later if necessary.
			
			if ($coffeeSelected) {
				// TO DO: Add Coffee Subcategories (if necessary)
			}
			
			if ($coffeeSelected) {
				// TO DO: ADD IN_ARRAY CHECK IF COFFEE SUBCATEGORIES USED (if necessary)
			}
			*/
			
			// Close Query
			$sql .= ";";
			
		}
		
		// Debug - outputs SQL statement
		// var_dump($sql);
		// echo "<br>";
		
		// Run SQL query. $conn is database connection. $sql is sql statement.
		$result = @mysqli_query($conn, $sql);

	?>