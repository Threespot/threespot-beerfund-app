<?php
include_once('bf-connection.php');

/**
* Changes an existing deduction within the database.
*/

if ($_SERVER['REQUEST_METHOD'] == POST) {
	$id = intval(mysql_real_escape_string($_POST['id']));
	$amount = floatval(mysql_real_escape_string($_POST['amount']));
	
	if ($id != "") {
		if ($amount > 0) {
			$result = mysql_query("UPDATE deduction SET amount='$amount' WHERE id=$id;");
		} else {
			$result = mysql_query("DELETE FROM deduction WHERE id=$id;");
		}
	}

	// Recalculate fund balance.
	include_once('bf-balance.php');
}
header("Location: all-deductions.php");
?>