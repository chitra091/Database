<?php
	session_start();
	$username = $_SESSION['username'];
?>

<html>
	<head>
		<title> OTS
		</title>
	</head>
	<body>
		<h1> Manager </h1>
		
		<p>
			<form method="post">
				<h3>What do you want to do?
				<ul>
					<li><input type="submit" value="View all trasactions" name="transaction" /></li><br>
					<li><input type="submit" value="View all clients" name="clients" /></li><br>
					<li><input type="submit" value="View all traders" name="traders"></li><br>
					<li><input type="submit" value="View gold level clients" name="gold"></li><br>
					<li><input type="submit" value="View silver level clients" name="silver"></li><br>
					<li><input type="submit" value="View monthly transactions" name="monthly"></li><br>
					
					<a href="logout.php" align="right"> Logout </a>
				</ul>
		</p>
		
		<?php
			if(isset($_POST['transaction']))
				header('Location: view_transactions.php');
			else if(isset($_POST['clients']))
				header('Location: view_clients.php');
			else if(isset($_POST['traders']))
				header('Location: view_traders.php');
			else if(isset($_POST['gold']))
				header('Location: view_gold.php');
			else if(isset($_POST['silver']))
				header('Location: view_silver.php');
			else if(isset($_POST['monthly']))
				header('Location: view_monthly.php');
			else if(isset($_POST['shipped']))
				header('Location: view_shipped.php');
			
		?>
		
	</body>
</html>