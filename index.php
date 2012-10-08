<?php ini_set('display_errors','Off'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Threespot Beer Fund</title>
	<link rel="stylesheet" href="css/beerfund.css" type="text/css"/>
	<script type="text/javascript">
	<?php
		session_start();
		include_once('bf-jsdata.php');
	?>
	</script>
</head>
<body>
	
<div id="page">
	<div id="header">
		<h1>Threespot Beer Fund</h1>
		<p class="balance" id="fund-balance">$<?php echo $balance; ?></p>
		<div class="about">
			<p><span class="titlecase">F</span>riday afternoon is beer o'clock at Threespot, or at least, it is when everyone pitches in. If you enjoy having a cold one at the end of a long work week, then please do your part by contributing to the Friday beer fund on a regular basis.</p>

			<p>Suggested contribution is $20, and your name will push to the top of the list where you'll be free from suspicion as a beer mootcher. Give contributions to the Chief Beer Officer (CBO), Chris Davis.</p>
		</div>
		<div id="pint">
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="fund-meter"></svg>
			<img src="images/pint.png" alt=""/>
			<ul>
				<li><span>4 Weeks+</span></li>
				<li><span>3 Weeks</span></li>
				<li><span>2 Weeks</span></li>
				<li><span>1 Week</span></li>
				<li><span>Thirsty</span></li>
			</ul>
		</div>
	</div>
	
	<div class="section">
		<h2>Beer Drinkers</h2>
		<table id="contributors" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th data-bind="click:sortName, css:{sortField:(sortField() === 'name'), asc:sortAsc}">Beer Funder</th>
				<th data-bind="click:sortRating, css:{sortField:(sortField() === 'rating'), asc:sortAsc}">Contributor Rating *</th>
				<th data-bind="click:sortLast, css:{sortField:(sortField() === 'last'), asc:sortAsc}">Latest Contribution</th>
			</tr>
		</thead>
		<tbody data-bind="foreach:donorList">
			<tr>
				<td data-bind="text:name"></td>
				<td><div class="rating" data-bind="style:{width: $root.formatRank(total)+'px'}"></div></td>
				<td data-bind="text: $root.formatDate( lastDate ) +' - '+ $root.formatAmount( lastAmount )"></td>
			</tr>
		</tbody>	
		</table>
		<p class="ranking footnote">* Contributor rating is based on <strong>TOTAL</strong> contributions over the past three months.</p>
	</div>
	
	<?php if ($_SESSION['is_admin']) { ?>
	<div class="section" id="admin">
		<a href="bf-login.php" class="logout">Admin Logout</a>
		
		<form id="contribution" class="mini" action="bf-contribution-new.php" method="post">
			<h2>Contributions</h2>
			<p class="donor-type">
				<input type="radio" name="donor" value="existing" id="donor-existing" data-bind="checked:donorType"/>
				<label for="donor-existing">Existing donor</label>
				<input type="radio" name="donor" value="new" id="donor-new" data-bind="checked:donorType"/>
				<label for="donor-new">New donor</label>
			</p>
			<div data-bind="visible: isExisting">
				<p>
					<label>Contributor</label>
					<select data-bind="options:donorList, optionsText:'name', value:donor">
						<option>Name</option>
					</select>
					<input type="hidden" name="donor_id" data-bind="value:donorId"/>
				</p>
			</div>
			<div data-bind="visible: !isExisting()">
				<p>
					<label>First Name</label>
					<input type="text" name="first_name" data-bind="value:donorFirst"/>
				</p>
				<p>
					<label>Last Name</label>
					<input type="text" name="last_name" data-bind="value:donorLast"/>
				</p>
			</div>
			<!--p>
				<label>Preference</label>
				<input type="text" name="preference" data-bind="value:amount"/>
			</p-->
			<p>
				<label>Amount</label>
				<input type="text" name="amount" data-bind="value:amount"/>
			</p>
			<p data-bind="visible:errors, text:errors">Invalid submission. All fields are required.</p>
			<p>
				<label>&nbsp;</label>
				<button data-bind="click:submit">Add Contribution</button>
			</p>
		</form>
		
		<table cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>Recent Contributions</th>
				<th>Amount</th>
				<th>Donor</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$result = mysql_query("SELECT date, amount, first_name, last_name FROM contribution LEFT JOIN donor ON contribution.donor=donor.id ORDER BY date DESC LIMIT 0, 5;");
				
				while($item = mysql_fetch_array( $result )) {
					$date = $item['date'];
					$amount = $item['amount'];
					$fname = $item['first_name'];
					$lname = $item['last_name'];
					echo "<tr><td>$date</td><td>$$amount</td><td>$fname $lname</td></tr>";
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" class="right"><a href="all-contributions.php">Manage all contributions</a></td>
			</tr>
		</tfoot>	
		</table>
		
		<form id="deduction" class="mini" action="bf-deduction-new.php" method="post">
			<h2>Deductions</h2>
			<p>
				<label>Purchase Price</label>
				<input type="text" name="amount" value="0"/>
			</p>
			<p>
				<label>Description</label>
				<input type="text" name="description" value=""/>
			</p>
			<p>
				<label>&nbsp;</label>
				<input type="submit" value="Log Purchase"/>
			</p>
		</form>
	
		<table cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>Recent Deductions</th>
				<th>Amount</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$result = mysql_query("SELECT * FROM deduction ORDER BY date DESC LIMIT 0, 5;");
			
				while($item = mysql_fetch_array( $result )) {
					$date = $item['date'];
					$amount = $item['amount'];
					$desc = $item['description'];
					echo "<tr><td>$date</td><td>$$amount</td><td>$desc</td></tr>";
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" class="right"><a href="all-deductions.php">Manage all deductions</a></td>
			</tr>
		</tfoot>
		</table>
	</div>
	<?php } ?>
	
	<p class="footnote">Please Contribute Responsibly.</p>
</div>

<script src="js/lib/require.js" data-main="js/main"></script>
</body>
</html>
