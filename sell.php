<?php
	session_start();
	$trader = $_SESSION['trader_id'];
	$client_id = $_SESSION['client_id'];
?>

<html>
	<head>
		<title> OTS
		</title>
	</head>
		<body>
		<h1>Oil Trading System</h1>

		<h2>Make a Transaction: Sell</h2>
		<br><br>
	
		
			<form action="sell.php" method ="post">
				<input type="button" value = "Home" onclick = "location.href='trader.php'"><br><br>
				Enter the oil in barrels:
				<input type="text" name="oil">
				<input type="submit" name="submit" value="Submit">
			</form>
		<?php
				
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "chitra";
			
			// Create connection
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			// Check connection
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			
					
			if(isset($_POST['submit']))
			{
				$sql = "SELECT oil_reserve FROM account_info WHERE user_id = ". $client_id;
				
				if($result = mysqli_query($conn, $sql))
				{
					while($row = mysqli_fetch_row($result)) 
					{
						$oil_reserve = $row[0];
						$oil_sell = $_POST['oil'];
							
						if($oil_sell > $oil_reserve)
						{
							echo "Cannot process transaction as total oil available is: ". $oil_reserve;
						}
						else
						{
							$oil_float = floatval($oil_sell);
							$dor = date('y/m/d');
							$tran_type ="sell";
							if((is_float($oil_float)) AND ($oil_float != 0))
							{
								$sql2 = "INSERT INTO transaction (client_id, trans_type, trans_fee, oil_requested, comm_amt, comm_type, total_amt, total_oil, dor) VALUES ('$client_id', '$tran_type', 0, '$oil_sell', 0, ' ', 0, '$oil_sell', '$dor')";
								$result2 = mysqli_query($conn, $sql2);
								
								
								$oil_reserve = $oil_reserve - $oil_sell;
								$sql1 = "UPDATE account_info SET oil_reserve = '$oil_reserve' WHERE user_id = ". $client_id;
								$result1 = mysqli_query($conn, $sql1);
								
								if(!$result1)
								{
									echo "Error updating table: ". mysqli_error($conn);
								}
							}
							else
							{
								echo "Invalid value entered";
							}
						}
					}
					mysqli_free_result($result);
				}
				mysqli_close($conn);
				$_SESSION['client_info'] = $client_id;
			}
		?>
		
		
		<body>
</html>