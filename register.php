<?php session_start();
?>

<html>
	<head>
		<style>
			.error {color: #FF0000;}
			.extra {color: blue;}
		</style>
		<title> OTS
		</title>
	</head>
	<body>
	<?php
		$fnameErr = $usernameErr = $Err = $cErr = $zipErr = $phonenoErr = $cellnoErr = "";
		
		/*
		function test_input($data) 
		{
		   $data = trim($data);
		   $data = stripslashes($data);
		   $data = htmlspecialchars($data);
		   return $data;
		} */
		if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				// setting sessions variables
				$_SESSION['username'] = "";
				
				$noErr = "";
			
				$fname = ($_POST['fname']);
				$lname = ($_POST["lname"]);
				$username = ($_POST["username"]);
				$password = ($_POST["password"]);
				$cpassword = ($_POST["cpassword"]);
				$user_type = ($_POST["user_type"]);
				$street = ($_POST["street"]);
				$city = ($_POST["city"]);
				$state = ($_POST["state"]);
				$zip = ($_POST["zip"]);
				$phoneno = ($_POST["phoneno"]);
				$cellno = ($_POST["cellno"]);
				$trader = ($_POST["choose_trader"]);
				echo $trader;
				
				// Error variables
				
				
				// Form vaildation
				
				   // validation for fname, check if its empty
				   //$fname = ($_POST['fname']);
				   //if (strlen($fname) >=3 && strlen($fname) <=10) 
				   if (preg_match("/^[a-z]+$/i", $fname) )
				   {
						$fnameErr = "";
				   } 
				   else 
				   {
						$noErr = "1";
						echo $noErr;
						$fnameErr = "* Enter a valid name !";
						//echo $fnameErr;
						
				   }
				   
				   //$lname = ($_POST['fname']);
				   if (strlen($username) >=3 && strlen($username) <=10) 
				   {
						$usernameErr = "";
				   } 
				   else 
				   {
						$noErr = "1";
						echo $noErr;
						$usernameErr = "* Enter a valid username !";
				   }
				   
				   if (strlen($password) >=8 && strlen($cpassword) <=15) 
				   {
						$Err = "";
				   } 
				   else 
				   {
						$noErr = "1";
						echo $noErr;
						$Err = "* Enter a valid  !";
				   }
				   
				   if (strcmp($password, $cpassword) !== 0) 
				   {
						$noErr = "1";
						echo $noErr;
						$cErr = "*  doesn't match !";
						
				   }
				
					if (strlen($zip) == 5) 
				   {
						$zipErr = "";
				   } 
				   else 
				   {
						$noErr = "1";
						echo $noErr;
						$zipErr = "* Enter a valid zipcode !";
				   }
				   
				   if (strlen($phoneno) == 10) 
				   {
						$phonenoErr = "";
				   } 
				   else 
				   {
						$noErr = "1";
						echo $noErr;
						$phonenoErr = "* Enter a valid phone number !";
				   }
				   
				   if (strlen($cellno) == 10) 
				   {
						$cellnoErr = "";
				   } 
				   else 
				   {
						$noErr = "1";
						echo $noErr;
						$cellnoErr = "* Enter a valid phone number !";
				   }
				
				if($noErr == "" )
				{
					$_SESSION['username'] = $username;
					
					// Connect to the database
					$mysql_host = "localhost";
					$mysql_database = "chitra"; 
					$mysql_user = "root";
					$mysql_ = "";

					// Connection string
					$link = mysqli_connect($mysql_host,$mysql_user,$mysql_,$mysql_database); 
					
					// Query Execution
					$insert = mysqli_query($link, "insert into user(user_type, login_name, password) VALUES('$user_type','$username', '$password')");
					
					$select = mysqli_query($link, "select * from user where login_name='$username'");
					$array = mysqli_fetch_array($select,MYSQL_ASSOC);
					$user_id = $array['user_id'];
					
					
					$insert2 = mysqli_query($link, "insert into profile(user_id, email, first_name, last_name, street, city, state, zip_code, phone_no, cell_no) VALUES('$user_id', '$username', '$fname', '$lname', '$street', '$city', '$state', '$zip', '$phoneno', '$cellno')");
					
					$insert3 = mysqli_query($link, "insert into account_info(user_id) values ('$user_id')");
					
					$select_trader = mysqli_query($link, "select * from user where user_type='2'");
					
					if($user_type==1)
					{
						$select_trader_id = mysqli_query($link, "select user_id from user where user_type='2' and login_name='$trader'");
						$array_trader = mysqli_fetch_array($select_trader_id,MYSQL_ASSOC);
						$trader_id = $array_trader['user_id'];
												
						//$insert_level = mysqli_query($link, "insert into level(level_id, level) values ('0', 'silver')");
						$select_level = mysqli_query($link, "select * from level where level_id = '1'");
						$array_level = mysqli_fetch_array($select_level,MYSQL_ASSOC);
						$level_id = $array_level['level_id'];
						
						$insert_assoc = mysqli_query($link, "insert into associated_with(client_id, trader_id, level_id) values ('$user_id', '$trader_id', '$level_id')");
						header('Location: client.php');
					}
					else
						header('Location: trader.php');
					mysqli_close($link);
				}
			}
		
	?>	
	
		<h1> Register </h1>
		<form class="contact_form" method="post" name="contact_form" id="send" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
		
		<p> <span class = "error"> * All fields are mandatory !</p>
		<p>
            <label> First Name </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="fname" type="text" name="fname" placeholder="First Name" required/>
			<span class="error"> <?php echo $fnameErr;?></span>
        </p>
		
		<p>
            <label> Last Name </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="lname" type="text" name="lname" placeholder="Last Name" required/>
        </p>
		
		<p>
            <label> Username </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="username" type="text" name="username" placeholder="username@domain.com" required/>
			<span class="error"> <?php echo $usernameErr;?></span>
			
        </p>
		
		<p>
            <label> Password </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="password" type="password" name="password" placeholder="Password" required/>
			<span class="error"> <?php echo $Err;?></span>
			<br/> <span class="extra">( should be minimum 8 characters) </span>
        </p>
		
		<p>
            <label> Confirm Password </label> 
			<input id="cpassword" type="password" name="cpassword" placeholder="Password" required/>
			<span class="error"> <?php echo $cErr;?></span>
        </p> 
		
		<p>
			<label> User Type </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<select id="user_type" name="user_type" required>
				<option value=""></option>
				<option value="1" id="ut1"> Client </option>
				<option value="2" id="ut2"> Trader </option>
			</select>
		</p>
		
		<?php
				// Connect to the database
				$mysql_host = "localhost";
				$mysql_database = "chitra"; 
				$mysql_user = "root";
				$mysql_ = "";

				// Connection string
				$link = mysqli_connect($mysql_host,$mysql_user,$mysql_,$mysql_database); 
				$select_trader = mysqli_query($link, "select * from user where user_type='2'");
				echo "Available Traders : ";
				echo "<table border='1'>";
				while($array_trader = mysqli_fetch_array($select_trader))
				{
					
					echo "<tr>";
					echo "<td>" .$array_trader['login_name']. "</td>";
					echo "</tr>";
					
				}
				echo "</table>";
				
				
		?>
		
		<p>
			<label> Choose a trader </label> &nbsp;&nbsp;&nbsp;&nbsp;
			<input id="choose_trader" type="text" placeholder="Trader Name" name="choose_trader"/>
			<br/> <span class="extra">(Select a trader from the above list) </span>
		</p>
		
		<p> Address </p>
		<p>
			<label> Street </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="street" type="text" name="street" placeholder="2600 Waterview Parkway #1234" required/>
		</p>
		
		<p>
			<label> City </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="city" type="text" name="city" placeholder="Richardson" required/>
		</p>
		
		<p>
			<label> State </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="state" type="text" name="state" placeholder="Texas" required/>
		</p>
		
		<p>
			<label> Zipcode </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="zip" type="text" name="zip" placeholder="75080" required/>
			<span class="error"> <?php echo $zipErr;?></span>
			<br/> <span class="extra">(Enter a 5 digit code) </span>
		</p>
		
		<p>
			<label> Phone No. </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="phoneno" type="text" name="phoneno" placeholder="4627364833" required/>
			<span class="error"> <?php echo $phonenoErr;?></span>
			<br/> <span class="extra">(Enter a 10 digit number) </span>
		</p>
		
		<p>
			<label> Cell No. </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="cellno" type="text" name="cellno" placeholder="7382746378" required/>
			<span class="error"> <?php echo $cellnoErr;?></span>
			<br/> <span class="extra">(Enter a 10 digit number) </span>
		</p>
		

		<p>
            <button id="register" name="register" type="submit">Register</button>
		</p>
		
		<?php
		
			
			
			
		?>
		</form>
	</body>
</html>