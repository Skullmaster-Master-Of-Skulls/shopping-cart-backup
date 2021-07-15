<?php

if (isset($_GET['please-login'])) {
	
	// Display Please Login Message
	
	echo "<div id='please-login'>";
	echo "<p>Please Login before Shopping</p>";
	echo "</div>";
	
	// Dropdown Login Section
	
	echo '<script>
					
			$("#Loginmenu").animate({
					"top":"+=75px",
					"opacity":1
			},500,"linear");
			
					
			</script>';
}

?>