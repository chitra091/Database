<?php
	session_start();
	$client_id = $_SESSION['client_id'];	
	$trader = $_SESSION['trader_id'];
?>
<html>
	<head>
		<title> OTS
		</title>
	</head>
		<body>
		<h1>Oil Trading System</h1>

		<h2>Make a Transaction: Buy</h2>
		<br><br>
	
		<form action="buy1.php" method = "post">
		<input type="button" value = "Home" onclick = "location.href='trader.php'"><br><br>
		Enter the amount of oil in barrels:<br>
		<input type="text" name="oil_request">
		<br><br>
		Select the commission
		<input type="radio" name="comm_type" value="Cash">Cash
		<input type="radio" name="comm_type" value="Oil">Oil
		<br><br>
		<input type="submit" name ="submit" value="submit">
		</form>
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
			case "Wednesday":
					$curr_price = 74.56;
					break;
			case "Wednesday":
					$curr_price = 73.88;
					break;
			case "Wednesday":
					$curr_price = 75.02;
					break;
			case "Wednesday":
					$curr_price = 74.44;
					break;
			default:
					$curr_price = 74.00;
			}
			
			
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "chitra";
			// Create connection
				$conn = mysqli_connect($servername, $username, $password, $dbname);
				
			if (isset($_POST['submit']))
			{
				
				$oil = $_POST['oil_request'];
				$comm_typ = $_POST['comm_type'];
				
				$_SESSION['oil_request1'] = $oil;
				$_SESSION['comm_type1'] = $comm_typ;
				
								
				
				// Check connection
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}
				
				$sql = "SELECT l.level, l.level_id FROM associated_with a, level l WHERE a.client_id = ". $client_id. " AND a.level_id = l.level_id";
				$result = mysqli_query($conn, $sql);
				
				while($row = mysqli_fetch_array($result,MYSQL_ASSOC)) 
				{
					$level = $row['level'];
					$level_id = $row['level_id'];
					
					if ($comm_typ == "Cash")
					{
						$sql1 = "SELECT comm_in_cash FROM level WHERE level_id = ". $level_id. " AND level = '". $level. "'";
						$result1 = mysqli_query($conn, $sql1);
						
						while($row1 = mysqli_fetch_array($result1,MYSQL_ASSOC)) 
						{
							$comm_in_cash = $row1['comm_in_cash'];
							
							$tran_fee = $oil * $curr_price;
							$total_fee = $tran_fee + $comm_in_cash;
							$total_oil = $oil;
							
							echo "Transaction fee:". $tran_fee. "<br>";
							echo "Total fee:". $total_fee. "<br>";
							echo "Total oil:". $total_oil. "<br>";
						}
					}
					else
					{
						$sql1 = "SELECT comm_in_oil FROM level WHERE level_id = ". $level_id. " AND level = '". $level. "'";
						$result1 = mysqli_query($conn, $sql1);
						
						while($row1 = mysqli_fetch_array($result1,MYSQL_ASSOC)) 
						{
							$comm_in_oil = $row1['comm_in_oil'];
							
							$tran_fee = $oil * $curr_price;
							$total_fee = $tran_fee;
							$total_oil = $oil - $comm_in_oil;
							
							echo "Transaction fee:". $tran_fee. "<br>";
							echo "Total fee:". $total_fee. "<br>";
							echo "Total oil:". $total_oil. "<br>";
						}
					}
				}
				mysqli_close($conn);
				$_SESSION['tran_fee1'] = $tran_fee;
				$_SESSION['total_fee1'] = $total_fee;
				$_SESSION['total_oil1'] = $total_oil;
				
			}
			
		?>
		
		
		<form action="" method = "post"><br>
		Confirm the transaction <br>
		<br><br>
		<input type="submit" name ="submit1" value="Confirm">
		</form>
		
		<?php
			
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "chitra";				
			
			if(isset($_POST['submit1']))
			{
			
				$client_id = $_SESSION['client_id'];
				$oil_request1 = $_SESSION['oil_request1'];
				$comm_type1 = $_SESSION['comm_type1'];
				$tran_fee1 = $_SESSION['tran_fee1'];
				$total_fee1 = $_SESSION['total_fee1'];
				$total_oil1 = $_SESSION['total_oil1'];
				$comm_amt = $total_fee1 - $tran_fee1;
				$dor = date('y/m/d');
				$tran_type = "Buy";
				
			
				
				// Create connection
				$conn = mysqli_connect($servername, $username, $password, $dbname);
				// Check connection
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}
				
				$oil_float = floatval($oil_request1);
				
				$shipped = 'No';
				//$status = 'Pending';
				
				if((is_float($oil_float)) AND ($oil_float != 0))
				{
					$sql = "INSERT INTO transaction (client_id, trans_type, trans_fee, oil_requested, comm_amt, comm_type, total_amt, total_oil, dor, shipped) VALUES ('$client_id', '$tran_type', '$tran_fee1', '$oil_request1', '$comm_amt', '$comm_type1', '$total_fee1', '$total_oil1', '$dor', '$shipped')";
					$result = mysqli_query($conn, $sql);
					
					// Populate the payment_details table
					$select_trans_id = mysqli_query($conn,"select * from transaction where client_id='$client_id' AND trans_type='buy' ORDER BY trans_id DESC LIMIT 1");
					$array_trans_id=mysqli_fetch_array($select_trans_id,MYSQL_ASSOC); 
					$trans_id = $array_trans_id['trans_id'];
					
					
					// Populate the payment_transaction table
					$insert_pay_details = mysqli_query($conn, "insert into payment_details (trans_id, client_id) values ('$trans_id', '$client_id')");
					$select_pay_id = mysqli_query($conn,"select * from payment_details where client_id='$client_id' ORDER BY payment_id DESC LIMIT 1");
					$array_pay_id=mysqli_fetch_array($select_pay_id,MYSQL_ASSOC); 
					$pay_id = $array_pay_id['payment_id'];
					
					$insert_pay_trans = mysqli_query($conn, "insert into payment_transaction (payment_id, amt_paid) values ('$pay_id','0')");
					
					if($result)
					{
						header('Location: Tran.php');
					}
					else
					{
						echo "Error during insert: ". mysqli_error($conn);
						header('Location: buy1.php');
					}
				}
				else
				{
					echo "Error during insert: ". mysqli_error($conn);
					header('Location: buy1.php');
				}
				mysqli_close($conn);
			}	
			
		?>
		
	
		
		<body>
</html>