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
		<h1> Client </h1>
		<a href="logout.php" align="right"> Logout </a>
		<h2> Hello, <?php echo $username;?></h2>
		
		<?php
				switch (date('l'))
			{
			case "Monday":
					$curr_price = 74.61;
					break;
			case "Tuesday":
					$curr_price = 74.34;
					break;
			case "Wednesday":
					$curr_price = 73.93;
					break;
			case "Thursday":
					$curr_price = 74.56;
					break;
			case "Friday":
					$curr_price = 73.88;
					break;
			case "Saturday":
					$curr_price = 75.02;
					break;
			case "Sunday":
					$curr_price = 74.44;
					break;
			default:
					$curr_price = 74.00;
			}
				
				// Connect to the database
				$mysql_host = "localhost";
				$mysql_database = "chitra"; 
				$mysql_user = "root";
				$mysql_password = "";

				// Connection string
				$link = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database); 
				
				define("OIL_RATE", "30");
				echo "<h2>Current Oil Rate: $" .$curr_price. "</h2>";
				
				echo "<h3><u>Account Information: </u></h3>";
				echo "<br/>";
				
				// Query Execution
				$result_user = mysqli_query($link,"select * from user where login_name='$username'");
				$array_user=mysqli_fetch_array($result_user,MYSQL_ASSOC); 
				$user_id = $array_user['user_id'];
				
				$result_account = mysqli_query($link,"select * from account_info where user_id='$user_id'");
				$array_account = mysqli_fetch_array($result_account,MYSQL_ASSOC); 
				$amount_due = $array_account['amount_due'];
				$oil_reserve = $array_account['oil_reserve'];
				$oil_shipped = $array_account['oil_shipped'];
								
				echo "User ID: " .$user_id. "<br/>";
				echo "Amount Due: " .$amount_due. "<br/>";
				echo "Oil Reserve: " .$oil_reserve. "<br/>";
				echo "Oil Shipped: " .$oil_shipped. "<br/>";
				
				
		?>
		<p>
			<form method="post">
				<h3>What do you want to do?
				<ul>
					<li><input type="submit" value="Buy" name="buy" /></li>
					<li><input type="submit" value="Sell" name="sell" /></li>
					<li><input type="submit" value="Pay Amount Due" name="pay"></li></h3>
				</ul>
		</p>
		
		<?php
			if(isset($_POST['buy']))
				header('Location: client_buy.php');
			else if(isset($_POST['sell']))
				header('Location: client_sell.php');
			else if(isset($_POST['pay']))
				header('Location: pay.php');
		?>
		
	</body>
</html>