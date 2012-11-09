<?php
include_once('bf-connection.php');

/**
* Posts a new deduction to the database.
*/

if ($_SERVER['REQUEST_METHOD'] == POST) {
	$desc = mysql_real_escape_string($_POST['description']);
	$amount = floatval(mysql_real_escape_string($_POST['amount']));
	$date = date('Y-m-d');
	
	if ($amount > 0) {
		// Insert new contribution.
		$result = mysql_query("INSERT INTO deduction (amount, date, description) VALUES ('$amount', '$date', '$desc');");
		
		// Update fund balance & average deduction.
		include_once('bf-balance.php');
	}
}
header("Location: index.php");
?>