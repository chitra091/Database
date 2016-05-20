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

		<h2>Accept/Reject Transactions:</h2>
		<br><br>
	

		<form action="" name="tran" method="post"> 
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
			  
			  $query = "SELECT trans_id, client_id, trans_type, oil_requested, total_amt, total_oil, dor FROM transaction WHERE doa IS NULL AND client_id IN (SELECT client_id FROM associated_with WHERE trader_id = '$trader')";
			  $result = mysqli_query($conn, $query);
			  echo "<table border='2'>";
			  echo "<tr>". "<td>". "Select". "<td>". "tran id". "<td>". "client id". "<td>". "tran type". "<td>". "oil requested". "<td>". "total amount". "<td>". "total oil". "<td>". "date of request";
			  $temptran = array();
			  for($i=0; $i<=$count; $i++) { 
				  while($row = mysqli_fetch_array($result,MYSQL_ASSOC)){
				  $count++;

				  $trans_id = $row['trans_id'];
				  $temptran[$count - 1] = $trans_id;
				  
				  $client_id = $row['client_id'];
				  $trans_type = $row['trans_type'];
				  $oil_requested = $row['oil_requested'];
				  $total_amt = $row['total_amt'];
				  $total_oil = $row['total_oil'];
				  $dor = $row['dor'];
				  
		 ?>
		 <tr> <td> <input name="field[]" type="checkbox" value="<?php echo $temptran[$count-1]; ?>" onclick=""> <?php echo "<td>". $trans_id. "<td>". $client_id. "<td>". $trans_type. "<td>". $oil_requested. "<td>". $total_amt. "<td>". $total_oil. "<td>". $dor; 
		 ?><br>
		 <?php } }?> 
		 </td> <input type="submit" name="submit" value="Accept"> <input type="submit" name="submit" value="Reject">
		 <?php
		    $_SESSION['string']= $temptran;
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
						for($i=0; $i<=$count; $i++) 
						{
							for($j=0; $j<count($_POST['field']); $j++)
							{
								if(isset($_POST['field'][$j]))
								{
									$fvalue[$j] = ($_POST['field'][$j]);
									
									if($fvalue[$j] == $temptran[$i])
									{
										$temp[$i] = $temptran[$i];
										
										$doa = date('y/m/d');
										
										
										$sql1 = "SELECT client_id, total_amt, total_oil FROM transaction WHERE trans_id = '$temp[$i]'";
										$result1 = mysqli_query($conn, $sql1);
										while($row1 = mysqli_fetch_array($result1,MYSQL_ASSOC)){
											$client_id = $row1['client_id'];
											$total_amt = $row1['total_amt'];
											$total_oil = $row1['total_oil'];
											}
										
										$sql2 = "SELECT amount_due, oil_reserve FROM account_info WHERE user_id = '$client_id'";
										$result2 = mysqli_query($conn, $sql2);
										while($row2 = mysqli_fetch_array($result2,MYSQL_ASSOC)){
											$amount_due = $row2['amount_due'];
											$oil_reserve = $row2['oil_reserve'];
											}
										
										$totalamt = $amount_due + $total_amt;
										$totaloil = $oil_reserve + $total_oil;
														
										
										$sql4 = "SELECT doa FROM transaction WHERE client_id = '$client_id' AND doa IS NOT NULL ORDER BY doa DESC LIMIT 1";
										if($result4 = mysqli_query($conn, $sql4))
										{
										while($row4 = mysqli_fetch_row($result4)){
											$doa1 = $row4[0];
											}
										}
										else
										{
											$doa1 = null;
										}
										list($y, $m, $d) = explode("-", $doa1);
										list($y1, $m1, $d1) = explode("/", $doa);
										
										if($m < $m1)
										{
											$sql5 = "SELECT SUM(total_oil) AS oil_month FROM transaction WHERE client_id = '$client_id' AND month(doa) = '$m' ";
											if($result5 = mysqli_query($conn, $sql5))
											{
											
												while($row5 = mysqli_fetch_row($result5)) 
												{
													$oil_month = $row5[0];
													
													if($oil_month > 30)
													{
														$sql6 = "SELECT level_id FROM associated_with WHERE client_id = '$client_id'";
														if($result6 = mysqli_query($conn, $sql6))
														{
															while($row6 = mysqli_fetch_row($result6))
															{
																$level_id = $row6[0];
																
																if($level_id == 1)
																{
																	$sql7 = "UPDATE associated_with SET level_id = 2 WHERE client_id = '$client_id'";
																	$result7 = mysqli_query($conn, $sql7);
																	
																	if(!result7)
																	{
																		echo "error updating level: ". mysqli_error($conn);
																	}
																}
															}
														}
													}
												}
											}
										}
										$sql = "UPDATE transaction SET doa = '$doa' WHERE trans_id = '$temp[$i]'";
										$result = mysqli_query($conn, $sql);
									
										$sql3 = "UPDATE account_info SET amount_due = '$totalamt', oil_reserve = '$totaloil' WHERE user_id = '$client_id'";
										$result3 = mysqli_query($conn, $sql3);
									if($result AND $result3)
									{
										header('Location: AccRejTran.php');
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
					elseif($_POST['submit'] == "Reject")
					{
						for($i=0; $i<=$count; $i++) 
						{
							for($j=0; $j<count($_POST['field']); $j++)
							{
								if(isset($_POST['field'][$j]))
								{
									$fvalue[$j] = ($_POST['field'][$j]);
									
									if($fvalue[$j] == $temptran[$i])
									{
										$temp[$i] = $temptran[$i];
										$file = 'RejectTransactions.log';
										$msg = "Transaction rejected: ". $temp[$i];
										
										file_put_contents($file, $msg, FILE_APPEND | LOCK_EX);
										
										$sql8 = "DELETE FROM transaction WHERE trans_id = '$temp[$i]'";
										$result8 = mysqli_query($conn, $sql8);
										if($result8)
										{
											header('Location: AccRejTran.php');
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
				mysqli_close($conn);
		?>
		<body>
</html>