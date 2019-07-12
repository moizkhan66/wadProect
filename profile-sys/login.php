<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Lumino - Login</title>
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css/styles.css" rel="stylesheet">
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>
	<?php  
		include_once 'config/connection.php';

   		$database = new Connection();
		
		$db = $database->openConnection();
		session_start();  
	
		if(isset($_POST['login']))   // it checks whether the user clicked login button or not 
		{
			$userUsername = $_POST['uname'];
			$userPassHash = $_POST['password'];

			$stmt = 'SELECT `user_id`, `user_password`, `user_type` FROM `user_tb` WHERE `user_username` = "' . $userUsername. '"';
			$stmtExec = $db->query($stmt);
			$stmtExec->setFetchMode(PDO::FETCH_ASSOC);
			$row = $stmtExec->fetch();
			$userId = $row['user_id'];
			$userPassword = $row['user_password'];
			$userType = $row['user_type']; 

			if(password_verify($userPassHash, $userPassword))
			{                                      
				$_SESSION['userId']=$userId;
				$_SESSION['userType']=$userType;
				$_SESSION['userUsername']=$userUsername;
				if($_SESSION['userType'] == 'admin')
					header("Location: admin_home.php");
				if($_SESSION['userType'] == 'counselor')
					header("Location: creports.php");
				if($_SESSION['userType'] == 'psychometrician')
					header("Location: preports.php");
				if($_SESSION['userType'] == 'staff')
					header("Location: students.php");
			}
			else
			{
				echo "invalid UserName or Password";        
			}
		}
		
	?>
			<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="panel-heading">Log in</div>
					<div class="panel-body">
						<form role="form" action="login.php" method="post">
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="Username" name="uname" type="text" autofocus="" required>
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" name="password" type="password" value="" required>
								</div>
								<div class="text-center">
									<button type="submit" name="login" class="btn btn-lg btn-primary">Login</button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->	
	
		<script src="assets/js/jquery-1.11.1.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
	</body>

</html>
