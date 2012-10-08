<?php
include_once('bf-connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == POST) {
	$user = mysql_real_escape_string($_POST['bf_admin']);
	$pass = md5(mysql_real_escape_string($_POST['bf_pass']));
	
	// Update fund balance.
	$result = mysql_query("SELECT * FROM fund;");

	while($item = mysql_fetch_array( $result )) {
		if ($item['admin_user'] == $user && $item['admin_pass'] == $pass) {
			$_SESSION['is_admin'] = true;
		}
	}
} else {
	session_destroy();
}

header("Location: index.php#admin");
?>