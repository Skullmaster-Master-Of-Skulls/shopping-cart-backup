<?php

if (isset($_GET['login-failed'])) {
	echo "<div id='login-failed'>";
	echo "<p>Username or Password were incorrect, please try again.</p>";
	echo "</div>";
}

?>