<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SBOPS - Dashboard</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/datepicker3.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">

    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
</head>

<body>
	<?php 
		session_start();
		if(empty($_SESSION['userId'])){
			header("Location: login.php");
		}
	?>
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><span>Basic Education Profiling System</span></a>
            </div>
        </div><!-- /.container-fluid -->
    </nav>

    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
			<div class="profile-sidebar">
				<div class="profile-userpic">
					<img src="assets/images/profile-pic-1.jpg" width="50" class="img-responsive" alt="">
				</div>
				<div class="profile-usertitle">
					<div class="profile-usertitle-name"><?php echo strtoupper($_SESSION['userUsername']);?></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="divider"></div>
			<ul class="nav menu">
				<li class="active"><a href="admin_home.php"><em class="fa fa-home">&nbsp;</em> Home</a></li>
				<li><a href="admin_users.php"><em class="fa fa-user">&nbsp;</em> Users</a></li>
				<li><a href="students.php"><em class="fa fa-users">&nbsp;</em> Students</a></li>
				<li><a  href="creports.php"><em class="fa fa-comments">&nbsp;</em> Counseling Reports</a></li>
				<li><a  href="preports.php"><em class="fa fa-user-md">&nbsp;</em> Phsyclogical Reports</a></li>
				<li><a  href="areports.php"><em class="fa fa-table">&nbsp;</em> Anecdotal Reports</a></li>
				<li><a href="user_profile.php"><em class="fa fa-clone">&nbsp;</em> Profile</a></li>
				<li><a href="password.php"><em class="fa fa-clone">&nbsp;</em> Change Password</a></li>
				<li><a href="logout.php"><em class="fa fa-star-o">&nbsp;</em> Logout</a></li>
			</ul> 
		</div>