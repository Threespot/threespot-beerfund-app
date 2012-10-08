<?php
include_once('bf-connection.php');

/**
* Changes an existing contribution within the database.
*/

if ($_SERVER['REQUEST_METHOD'] == POST) {
	$id = intval(mysql_real_escape_string($_POST['id']));
	$amount = floatval(mysql_real_escape_string($_POST['amount']));
	
	if ($id != "") {
		if ($amount > 0) {
			$result = mysql_query("UPDATE contribution SET amount='$amount' WHERE id=$id;");
		} else {
			$result = mysql_query("DELETE FROM contribution WHERE id=$id;");
		}
	}

	// Update balance and quarterly contributions.
	include_once('bf-balance.php');
	include_once('bf-ranking.php');
}
header("Location: all-contributions.php");
?>