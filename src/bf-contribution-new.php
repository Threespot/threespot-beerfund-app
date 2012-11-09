<?php
include_once('bf-connection.php');

/**
* Posts a new contribution to the database.
*/

if ($_SERVER['REQUEST_METHOD'] == POST) {
	$donor_type = $_POST['donor'];
	$donor = intval(mysql_real_escape_string($_POST['donor_id']));
	$amount = floatval(mysql_real_escape_string($_POST['amount']));
	$date = date('Y-m-d');
	$last = 0;
	$total = 0;
	
	if ($donor_type == 'new') {
		// Create new donor...
		$first = mysql_real_escape_string($_POST['first_name']);
		$last = mysql_real_escape_string($_POST['last_name']);
		$result = mysql_query("INSERT INTO donor (first_name, last_name) VALUES ('$first', '$last');");
		$donor = mysql_insert_id();
	}
	
	// Insert new contribution.
	$result = mysql_query("INSERT INTO contribution (donor, amount, date) VALUES ('$donor', '$amount', '$date');");
	$last = mysql_insert_id();
	$result = mysql_query("UPDATE donor SET last_contribution='$last' WHERE id=$donor;");
	
	// Update fund balance.
	$result = mysql_query("SELECT balance FROM fund;");
	$balance = 0;

	while($item = mysql_fetch_array( $result )) {
		$balance = floatval($item['balance']);
	}

	$balance += $amount;
	$result = mysql_query("UPDATE fund SET balance='$balance';");

	// Update quarterly ranks.
	include_once('bf-ranking.php');
}
header("Location: index.php");
?>