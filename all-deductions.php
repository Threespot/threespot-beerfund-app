<?php ini_set('display_errors','Off'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Threespot Beer Fund: All Deductions</title>
	<link rel="stylesheet" href="css/beerfund.css" type="text/css"/>
	<script type="text/javascript">
	<?php
		session_start();
		include_once('bf-connection.php');
		include_once('bf-jsdata.php');
	?>
	</script>
</head>
<body>
	
<div id="page" class="admin">
	<div id="header">
		<h1>Threespot Beer Fund</h1>
		<p class="balance">$<?php echo $balance; ?></p>
	</div>
	<?php if ($_SESSION['is_admin']) { ?>
	<div class="section">
		<h2>Deductions</h2>
		<form method="post" action="bf-deduction-change.php">
			<table cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Date</th>
					<th>Amount</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = mysql_query("SELECT * FROM deduction ORDER BY date DESC;");
				
					while($item = mysql_fetch_array( $result )) {
						$id = $item['id'];
						$date = $item['date'];
						$amount = $item['amount'];
						$desc = $item['description'];
						echo "<tr><td><input type='radio' name='id' value='$id' id='r-$id'/> ";
						echo "<label for='r-$id'>$date</label></td><td>$$amount</td><td>$desc</td></tr>";
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td>Update selected contribution <em>(zero to remove)</em>:</td>
					<td><input type="text" name="amount" value="0" style="width:75px;"/></td>
					<td><input type="submit" value="Submit"/></td>
				</tr>
			</tfoot>
			</table>
		</form>
		
		<p class="footnote"><a href="index.php">Done</a></p>
	</div>
	<?php } ?>
</div>

</body>
</html>
