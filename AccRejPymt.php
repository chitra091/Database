<?php
	session_start();
	$trader = $_SESSION['trader_id'];
?>

<html>
	<head>
		<title> OTS
		</title>
	</head>
		<body>
		<h1>Oil Trading System</h1>

		<h2>Accept/Reject Payments:</h2>
		<br><br>
	

		<form action="" name="pay" method="post"> 
		<input type="button" value = "Home" onclick = "location.href='trader.php'"><br><br>
		  <br />
		  <?php
		  
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "chitra";
			
			// Create connection
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			// Check connection
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());}
			
			  $count=0;
			  
			  $query = "SELECT payment_id, trans_id, client_id, dop FROM payment_details WHERE doa IS NULL AND client_id IN (SELECT client_id FROM associated_with WHERE trader_id = '$trader')";
			  $result = mysqli_query($conn, $query);
			  echo "<table border='2'>";
			  echo "<tr>". "<td>". "Select". "<td>". "payment id". "<td>". "tran id". "<td>". "client id". "<td>". "date of payment";
			  $temptran = array();
			  for($i=0; $i<=$count; $i++) { 
				  while($row = mysqli_fetch_array($result,MYSQL_ASSOC)){
				  $count++;

				  $payment_id = $row['payment_id'];
				  $temptran[$count - 1] = $payment_id;
				  
				  $trans_id = $row['trans_id'];
				  $client_id = $row['client_id'];
				  $dop = $row['dop'];
				  		
		 ?>
		 <tr> <td> <input name="field[]" type="checkbox" value="<?php echo $temptran[$count-1]; ?>" onclick=""> <?php echo "<td>". $payment_id. "<td>". $trans_id. "<td>". $client_id. "<td>". $dop; 
		 ?><br>
		 <?php } }?> 
		 </td> <input type="submit" name="submit" value="Accept"> <input type="submit" name="submit" value="Reject">
		 <?php
		    $_SESSION['string'] = $temptran;
		 ?>	
		 </form>
		
		<?php
			
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "chitra";
			
			$temptran = $_SESSION['string'];
			$count = count($temptran);
			
			// Create connection
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			// Check connection
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
				if (isset($_POST['submit']))
				{
					if ($_POST['submit'] == "Accept")
					{
						for($i=0; $i<$count; $i++) 
						{
							for($j=0; $j<count($_POST['field']); $j++)
							{
								if(isset($_POST['field'][$j]))
								{
									$fvalue[$j] = ($_POST['field'][$j]);
									print_r($fvalue);
									if($fvalue[$j] == $temptran[$i])
									{
										$temp[$i] = $temptran[$i];
										
										$doa = date('y/m/d');
										$sql = "UPDATE payment_details SET doa = '$doa' WHERE payment_id = '$temp[$i]'";
										$result = mysqli_query($conn, $sql);
										
										$sql1 = "SELECT pd.client_id, pt.amt_paid FROM payment_details pd, payment_transaction pt WHERE pd.payment_id = '$temp[$i]' AND pd.payment_id = pt.payment_id";
										$result1 = mysqli_query($conn, $sql1);
										while($row1 = mysqli_fetch_array($result1,MYSQL_ASSOC)){
											$client_id = $row1['client_id'];
											$amt_paid = $row1['amt_paid'];
											}
										
										$sql2 = "SELECT amount_due FROM account_info WHERE user_id = '$client_id'";
										if($result2 = mysqli_query($conn, $sql2))
										{
											while($row2 = mysqli_fetch_row($result1)){
												$amount_due = $row2[0];
												}
											
											$totalamt = $amount_due - $total_amt;
											
											$sql3 = "UPDATE account_info SET amount_due = '$totalamt' WHERE user_id = '$client_id'";
											$result3 = mysqli_query($conn, $sql3);
											
											if($result AND $result3)
											{
												header('Location: AccRejPymt.php');
											}
											else
											{
												echo "Error updating record: ". mysqli_error($conn);
											}
										}
									}
								}	
							}
						}	
					}
				}
				mysqli_close($conn);
		?>
		<body>
</html>