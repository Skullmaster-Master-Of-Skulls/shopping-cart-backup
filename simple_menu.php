<?php

	echo "<div class='nav'>";
		echo "<a href='index.php'>";
		echo "<img id='Logo' src='../resources/img/Lotus.png'><span id='IrohTitle'><h2>Iroh's Tea House</h2></span>";
		echo "</a>";
		echo "<div id='navbuttons'>";
		if (isset($_SESSION['logged_in'])) {
			echo "<a class='Navbutton' id='USERNAME'>Welcome back, " . $_SESSION['username'] . "</a>";
			echo "<a class='Navbutton' id='Homebutton' href='logout.php'>Log out</a>";
		} else {
			echo "<a class='Navbutton' id='Homebutton' href='index.php'>HOME</a>";
		}
		echo "</div>";
	echo "</div>";

?>