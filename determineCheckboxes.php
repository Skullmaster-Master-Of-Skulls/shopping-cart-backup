	<?php
	
		// Written by Hudson T.
		// Determines which checkboxes should be checked after sorting has occured
	
		$teaChecked = false;
		$herbalChecked = false;
		$blackChecked = false;
		$greenChecked = false;
		$oolongChecked = false;
		$whiteChecked = false;
		$icedChecked = false;
		$coffeeChecked = false;
		
		// Check for whether tea / coffee checkbox should be checked
		
		if (isset($_POST['tea'])) {
			$teaChecked = true;
		}
		
		if (isset($_POST['coffee'])) {
			$coffeeChecked = true;
		}
		
		// Check for tea subcategories
		
		if ($teaChecked) {
			if (in_array('herbal', $_POST['tea'])) {
				$herbalChecked = true;
			}
			
			if (in_array('black', $_POST['tea'])) {
				$blackChecked = true;
			}
			
			if (in_array('green', $_POST['tea'])) {
				$greenChecked = true;
			}
			
			if (in_array('oolong', $_POST['tea'])) {
				$oolongChecked = true;
			}
			
			if (in_array('white', $_POST['tea'])) {
				$whiteChecked = true;
			}
			
			if (in_array('iced', $_POST['tea'])) {
				$icedChecked = true;
			}
			
			if (isset($_POST['coffee'])) {
				$coffeeChecked = true;
			}
		}
		
		// In the HTML, these booleans are used to add a checked="checked" attribute to relevant checkboxes.
		// Therefore, this code should appear before the checkbox section!
	
	?>