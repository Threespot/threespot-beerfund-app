<?php
include_once('bf-connection.php');

/**
* Pulls all data used by the JavaScript application from the database, and outputs it as JSON.
* Donors and fund balance are printed into the document.
*/

// Get all donors.
$result = mysql_query("SELECT donor.id AS id, first_name, last_name, quarter_total, amount, date FROM donor LEFT JOIN contribution ON donor.last_contribution=contribution.id ORDER BY first_name, last_name");
$donors = array();
$donor;

// Format and print all donor records as JSON array.
while($item = mysql_fetch_array( $result )) {
	$donor = array();
	$donor['id'] = $item['id'];
	$donor['name'] = $item['first_name'] .' '. $item['last_name'];
	$donor['total'] = $item['quarter_total'];
	$donor['lastAmount'] = $item['amount'];
	$donor['lastDate'] = $item['date'];
	$donors[] = $donor;
}
echo 'window.donorList='. json_encode($donors) .';';

// Get and print account balance.
$result = mysql_query("SELECT balance, average_deduction FROM fund;");

while($item = mysql_fetch_array( $result )) {
	$balance = $item['balance'];
	$deduction = $item['average_deduction'];
}
echo 'window.fundBalance='. $balance .';';
echo 'window.averageDeduction='. $deduction .';';
?>