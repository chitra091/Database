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
		<h1> Client Sell </h1>
		<a href="logout.php" align="right"> Logout </a>
		<h2> Hello, <?php echo $username;?></h2>
		
		<?php
				// Connect to the database
				$mysql_host = "localhost";
				$mysql_database = "chitra"; 
				$mysql_user = "root";
				$mysql_password = "";

				// Connection string
				$link = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database); 
				
				define("OIL_RATE", "30");
				echo "<h2>Current Oil Rate: $" .OIL_RATE. "</h2>";
				
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
		
		<form action="client_sell.php" method="post">
			<p>
				<h3>
					
					Enter no. of barrels to be sold: <input type="text" name="amount" id="amount" />
					<input type="submit" value="Sell Oil" name="sell" />
				</h3>
			</p>
		</form>
		
		<?php
			if(isset($_POST['sell']))
			{
				$oil = $_POST['amount'];
				$trans_type = "sell";
				$dor = date('y/m/d');
				
				$oil_float = floatval($oil);
				if((is_float($oil_float)) AND ($oil_float != 0))
				{
				
					//echo $oil;
					if($oil<=$oil_reserve)
					{
						//echo "Oil can be sold";
						$oil_reserve = $oil_reserve - $oil;
						//echo $oil_reserve;
						$insert_oil_reserve = mysqli_query($link, "update account_info set oil_reserve='$oil_reserve' where user_id='$user_id'");
						
						$insert_trans = mysqli_query($link, "insert into transaction (client_id, trans_type, oil_requested,total_oil, dor, doa) values ('$user_id', '$trans_type', '$oil', '$oil', '$dor', '$dor')");
						
						echo "Order Successful !";
						?>
						<button type="button" onclick="window.location='client.php';"> Continue </button>
						<?php
					}
					else
					{
						echo "You don't have enough oil reserve !";
						?>
						<button type="button" onclick="window.location='client_buy.php';"> Buy some more </button>
						<?php
					}
				}
				else
				{
					header('Location: client_sell.php');
				}
				
			}
		?>
	</body>
</html>