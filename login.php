<?php session_start();
?>

<html>
	<head>
		<title> OTS
		</title>
	</head>
	<body>
		<h1><center> Oil Transaction System </center></h1>
		<form name="login-form" action="" method="post">
			<center>
			<h1>Login Form</h1>
			<div>
				<input type="text" placeholder="Email" name="username" id="username" />
			</div>
			<br/>
			<div>
				<input type="password" placeholder="password" name="password" id="" />
			</div>
			<br/>
			<div>
				<input type="submit" value="Sign in" name="submit" />
				<input type="submit" value="New User? Sign up" name="register" />
			</div>
			</center>
		</form>
		
		<?php
			if (isset($_POST['submit']))
			{
				// setting sessions variables
				$_SESSION['username'] = "";
				
				
				$un=$_POST["username"];
				$pswd=$_POST["password"];
				
				// Connect to the database
				$mysql_host = "localhost";
				$mysql_database = "chitra"; 
				$mysql_user = "root";
				$mysql_password = "";

				// Connection string
				$link = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database); 
				
				// Query Execution
				$result = mysqli_query($link,"select * from user where login_name='$un' and password='$pswd'");
				$array=mysqli_fetch_array($result,MYSQL_ASSOC);
				
				if($array!="")
				{
					$un = $array['login_name'];
					$un = mysqli_real_escape_string($link,$un);
					$ut = $array['user_type'];
					$trader = $array['user_id'];
					$_SESSION['username'] = $un;
					$_SESSION['trader_id'] = $trader;
					//$_SESSION['user_type']=$ut;
					if($ut==1)
						header('Location: client.php');
					else if($ut==2)
						header('Location: trader.php');
					else if($ut==3)
						header('Location: manager.php');
					
				}
				else
				{
					echo "<script>alert('Invalid User')</script>";
				}
				mysqli_close($link);
			}
			
			if (isset($_POST['register']))
			{
				header('Location: register.php');
			}
		?>
	</body>
</html>