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
		
		<form action="client_buy.php" method = "post">
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
			
			if (isset($_POST['submit']))
			{
				$oil = $_POST['oil_request'];
				$comm_typ = $_POST['comm_type'];
				
				echo "Oil: ".$oil;
				echo "<br>";
				echo "Commission type: ".$comm_typ;
				echo "<br>";
				
				// Connect to the database
				$mysql_host = "localhost";
				$mysql_database = "chitra"; 
				$mysql_user = "root";
				$mysql_password = "";

				// Connection string
				$link = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database); 
				
				if (!$link) 
				{
					die("Connection failed: " . mysqli_connect_error());
				}
				
				$oil_float = floatval($oil);
					
				if((is_float($oil_float)) AND ($oil_float != 0))
				{
				
					$select = mysqli_query($link, "select * from user where login_name='$username'");
					$array = mysqli_fetch_array($select,MYSQL_ASSOC);
					$user_id = $array['user_id'];
					
					
					$tran_fee = $total_fee = $total_oil = "";
					
					
					echo "Transaction Fee: " .$tran_fee;
					echo "<br>";
					echo "Total Fee: " .$total_fee;
					echo "<br>";
					echo "Total Oil: " .$total_oil;
					echo "<br>";
					echo "Current Price: " .$curr_price;
					echo "<br>";
					echo "User ID: ".$user_id;
					echo "<br>";
					
					// Fetching level_id from associated_with
					$select_level_id = mysqli_query($link, "select * from associated_with where client_id='$user_id'");
					$array_level_id = mysqli_fetch_array($select_level_id,MYSQL_ASSOC);
					$level_id = $array_level_id['level_id'];
					echo "Level ID: " .$level_id;
					
					//Fetching comm_in_cash and comm_in_oil values from level_id
					$select_comm = mysqli_query($link, "select * from level where level_id='$level_id'");
					$array_comm = mysqli_fetch_array($select_comm,MYSQL_ASSOC);
					$comm_in_cash = $array_comm['comm_in_cash'];
					$comm_in_oil = $array_comm['comm_in_oil'];
					
					echo "<br>";
					$dor = date('y/m/d h/i/s');
					
					echo "Date: " .$dor;
					if($comm_typ == 'Cash')
					{
						
						echo "<br>";
						echo "Commission in Cash: " .$comm_in_cash;
						$comm_amt = $comm_in_cash;
						
						$tran_fee = $oil * $curr_price;
						$total_fee = $tran_fee + $comm_in_cash;
						$total_oil = $oil;
								
						echo "<br>";
						echo "Transaction fee:". $tran_fee. "<br>";
						echo "Total fee:". $total_fee. "<br>";
						echo "Total oil:". $total_oil. "<br>";
						
					
						
					}
					else
					{
						echo "<br>";
						echo "Commission in Oil: " .$comm_in_oil;
						$comm_amt = $comm_in_oil;
						
						$tran_fee = $oil * $curr_price;
						$total_fee = $tran_fee;
						$total_oil = $oil - $comm_in_oil;
								
						echo "Transaction fee:". $tran_fee. "<br>";
						echo "Total fee:". $total_fee. "<br>";
						echo "Total oil:". $total_oil. "<br>";
					}
					
					$_SESSION['client_id1'] = $user_id;
					$_SESSION['tran_fee1'] = $tran_fee;
					$_SESSION['oil_requested'] = $oil;
					$_SESSION['comm_amt1'] = $comm_amt;
					$_SESSION['comm_typ1'] = $comm_typ;
					$_SESSION['total_amt1'] = $total_fee;
					$_SESSION['total_oil1'] = $total_oil;
					$_SESSION['dor1'] = $dor;
					mysqli_close($link);
				}
				else
				{
					header('Location: client_buy.php');
				}
			}
		?>
		
		<form action="client_buy.php" method = "post"><br>
		Do you want to get the oil shipped ? <input type="checkbox" name="ship" value="shipped"> 
		<br><br>
		<input type="submit" name ="confirm" value="Confirm">
		</form>
		
		<?php
			if (isset($_POST['confirm']))
			{
				// Connect to the database
				$mysql_host = "localhost";
				$mysql_database = "chitra"; 
				$mysql_user = "root";
				$mysql_password = "";

				// Connection string
				$link = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database); 
				
				if (!$link) 
				{
					die("Connection failed: " . mysqli_connect_error());
				}
					
				$trans_type = "buy";
				//echo "Transaction Type: " .$trans_type;
				//echo "<br>";
				$client_id1 = $_SESSION['client_id1'];
				//echo "Client ID :" .$client_id1;
				//echo "<br>";
				$tran_fee1 = $_SESSION['tran_fee1'];
				//echo "Transaction Fee: " .$tran_fee1;
				//echo "<br>";
				$oil_requested = $_SESSION['oil_requested'];
				//echo "Oil requested: " .$oil_requested;
				//echo "<br>";
				$comm_amt1 = $_SESSION['comm_amt1'];
				//echo "Commission Amount: $ " .$comm_amt1;
				//echo "<br>";
				$comm_typ1 = $_SESSION['comm_typ1'];
				//echo "Commission Type: " .$comm_typ1;
				//echo "<br>";
				$total_amt1 = $_SESSION['total_amt1'];
				//echo "Total Amount: " .$total_amt1;
				//echo "<br>";
				$total_oil1 = $_SESSION['total_oil1'];
				//echo "Total Oil: " .$total_oil1;
				//echo "<br>";
				$dor1 = $_SESSION['dor1'];
				//echo "Date of request: " .$dor1;
				//echo "<br>";
				
				//$ship = $_POST['ship'];
				//echo $ship;
				
				//$status = "Pending";
				
				$result_account = mysqli_query($link,"select * from account_info where user_id='$client_id1'");
				$array_account = mysqli_fetch_array($result_account,MYSQL_ASSOC); 
				$amount_due = $array_account['amount_due'];
				$oil_reserve = $array_account['oil_reserve'];
				$oil_shipped = $array_account['oil_shipped'];
				
				
				
				if(isset($_POST['ship'])) 
				{
					$ship = "Yes";
					echo $ship;
					
					
					$insert_trans = mysqli_query($link, "insert into transaction (client_id, trans_type, trans_fee, oil_requested, comm_amt, comm_type, total_amt, total_oil, dor, shipped) values ('$client_id1', '$trans_type', '$tran_fee1', '$oil_requested', '$comm_amt1', '$comm_typ1', '$total_amt1', '$total_oil1', '$dor1', '$ship')");
					
					
					
					$amount_due = $amount_due + $total_amt1;
					
					
					
					$oil_shipped = $oil_shipped + $oil_requested;
					
					$update_account = mysqli_query($link, "update account_info set amount_due='$amount_due', oil_shipped='$oil_shipped' where user_id='$client_id1'");
									
					echo "User ID: " .$client_id1. "<br/>";
					echo "Amount Due: " .$amount_due. "<br/>";
					echo "Oil Reserve: " .$oil_reserve. "<br/>";
					echo "Oil Shipped: " .$oil_shipped. "<br/>";
					
				}
				else
				{
					$ship = "No";
					
					$amount_due = $amount_due + $total_amt1;
					$oil_reserve = $oil_reserve + $oil_requested;
					
					$insert_trans = mysqli_query($link, "insert into transaction (client_id, trans_type, trans_fee, oil_requested, comm_amt, comm_type, total_amt, total_oil, dor, shipped) values ('$client_id1', '$trans_type', '$tran_fee1', '$oil_requested', '$comm_amt1', '$comm_typ1', '$total_amt1', '$total_oil1', '$dor1', '$ship')");
					
					$update_account = mysqli_query($link, "update account_info set amount_due='$amount_due', oil_reserve='$oil_reserve', oil_shipped='$oil_shipped' where user_id='$client_id1'");
				}
				
				// Populate the payment_details table
				$select_trans_id = mysqli_query($link,"select * from transaction where client_id='$client_id1' ORDER BY trans_id DESC LIMIT 1");
				$array_trans_id=mysqli_fetch_array($select_trans_id,MYSQL_ASSOC); 
				$trans_id = $array_trans_id['trans_id'];
				
				
				// Populate the payment_transaction table
				$insert_pay_details = mysqli_query($link, "insert into payment_details (trans_id, client_id) values ('$trans_id', '$client_id1')");
				$select_pay_id = mysqli_query($link,"select * from payment_details where client_id='$client_id1' ORDER BY payment_id DESC LIMIT 1");
				$array_pay_id=mysqli_fetch_array($select_pay_id,MYSQL_ASSOC); 
				$pay_id = $array_pay_id['payment_id'];
				
				$insert_pay_trans = mysqli_query($link, "insert into payment_transaction (payment_id, amt_paid) values ('$pay_id','0')");
				
				?>

					<h2>Order Successful !<button type="button" onclick="window.location='client.php';"> Continue </button></h2>
				<?php
				
				mysqli_close($link);
			}
		?>
		
	</body>
</html>