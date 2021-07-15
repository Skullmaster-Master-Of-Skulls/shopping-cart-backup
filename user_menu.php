<?php

	if (isset($_SESSION['logged_in'])) {
		echo "<div class='nav'>";
		echo "<a href='index.php'>";
		echo "<img id='Logo' src='../resources/img/Lotus.png'><span id='IrohTitle'><h2>Iroh's Tea House</h2></span>";
		echo "</a>";
			echo "<div id='navbuttons'>";
				echo "<a class='Navbutton' id='Homebutton' href='index.php'>HOME</a>";
				echo "<a class='Navbutton' id='Cartbutton' href='Cart.php'>CART</a>";
				echo "<a class='Navbutton' id='OrderHistorybutton' href='OrderHistory.php'>ORDER HISTORY</a>";
				echo "<a class='Navbutton' id='USERNAME'>Welcome back, " . $_SESSION['username'] . "</a>";
				echo "<a href='logout.php' class='Navbutton' id='Logoutbutton'>LOG OUT</a>";
			echo "</div>";
		echo "</div>";
	} else {
		echo "<div class='nav'>";
		echo "<a href='index.php'>";
		echo "<img id='Logo' src='../resources/img/Lotus.png'><span id='IrohTitle'><h2>Iroh's Tea House</h2></span>";
		echo "</a>";
			echo "<div id='navbuttons'>";
				echo "<a class='Navbutton' id='Loginbutton'>LOGIN</a>";
			echo "</div>";
		echo "</div>";
	}

?>