<?php
include_once('bf-connection.php');

/**
* Performs a brute-force recalculation of the fund balance.
*/

// Total all contributions.
$result = mysql_query("SELECT amount FROM contribution;");
$balance = 0;
$totalDeduction = 0;
$numDeductions = 0;
$deduction = 0;

while($item = mysql_fetch_array( $result )) {
	$balance += floatval( $item['amount'] );
}

// Remove all deductions.
$result = mysql_query("SELECT amount FROM deduction;");

while($item = mysql_fetch_array( $result )) {
	$deduction = floatval( $item['amount'] );
	$balance -= $deduction;
	$totalDeduction += $deduction;
	$numDeductions++;
}

// Set balance and average deduction.
$deduction = $totalDeduction / $numDeductions;
$result = mysql_query("UPDATE fund SET balance='$balance', average_deduction='$deduction';");
?>