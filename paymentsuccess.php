<?php if (isset($_SESSION['receipt']) && isset($_GET['payment-successful'])): ?>

	<div id="payment-success-overlay" href="index.php">
		<button id="overlaybutton" href="index.php"></button>
		<div id="paymentsuccess">
				<p><h4> Payment successful</h4></p>
				<p> Thank you for shopping with Iroh's Tea House</p>
				<button id="receiptbutton"><a href="<?php echo "../resources/stripe/receipts/" . $_SESSION['receipt']; ?>" download>Download order confirmation file</a></button>
		</div>
	</div>

<?php endif; ?>
