<?php
	session_start();
	$_SESSION['username'];
	$trader = $_SESSION['trader_id'];
	$_SESSION['trader_id'] = $trader;
?>

<html>
	<head>
		<title> OTS
		</title>
	</head>
	<body>
		<h1> Trader </h1>
		<h2> Hello, <?php echo $_SESSION['username'];?></h2>
		
		<a href="logout.php"> Logout </a>
		<br><br>
		<input type="button" value = "Make a transaction" onclick = "location.href='Tran.php'">
		<br>
		<br>
		<input type="button" value = "Accept/Reject Transactions" onclick = "location.href='AccRejTran.php'">
		<br>
		<br>
		<input type="button" value = "Accept/Reject Payments" onclick = "location.href='AccRejPymt.php'">
		<br>
		<br>
		<input type="button" value = "Search Client" onclick = "location.href='SrchClnt.php'">
	</body>
</html>