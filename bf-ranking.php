<?php
include_once('bf-connection.php');

// Fetch all donors.
$result = mysql_query("SELECT * FROM donor;");
$date = date('Y-m-d');
$total = 0;

while($item = mysql_fetch_array( $result )) {
	$total = 0;
	$donor = $item['id'];
	
	// Select all quarterly contributions for each donor.
	$contributions = mysql_query("SELECT * FROM contribution WHERE donor=$donor AND date >= DATE_SUB('$date', INTERVAL 3 MONTH);");
	
	// Total up contributions.
	while($contribution = mysql_fetch_array( $contributions )) {
		$total += intval($contribution['amount']);
	}
	
	// Store total as attribute of donor.
	$contributions = mysql_query("UPDATE donor SET quarter_total='$total' WHERE id=$donor;");
}
?>