<!DOCTYPE html>
<html lang="en">
<head>
	<title>Threespot Beer Fund</title>
	<link rel="stylesheet" href="css/beerfund.css" type="text/css"/>
	<script type="text/javascript">
	<?php include_once('bf-jsdata.php'); ?>
	</script>
</head>
<body>
	
<div id="page" class="admin">
	<div id="header">
		<h1>Threespot Beer Fund</h1>
		<p class="balance">$<?php echo $balance; ?></p>
	</div>
	<div class="section">
		<form id="login" class="mini" action="bf-login.php" method="post">
			<h2>Beermeister Login</h2>
			<p>
				<label>User:</label>
				<input type="text" name="bf_admin" value=""/>
			</p>
			<p>
				<label>Password:</label>
				<input type="password" name="bf_pass" value=""/>
			</p>
			<p>
				<label>&nbsp;</label>
				<input type="submit" value="Login"/>
			</p>
		</form>
	</div>
</div>

</body>
</html>