<?php include "templates/header.php"; ?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
			<li class="active">Dashboard</li>
		</ol>
	</div>
	<div class="row">
        <div class="col-lg-6">
            <h4>Current Academic Year: 2018-2019</h4>
            <h4>Current Term: 3rd Term</h4>
        </div>
        <div class="col-lg-6">
            <h4 class="pull-right">Current Date And Time : <?php echo date("M,d,Y h:i:s A");?></h4>
        </div>
    </div>

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Dashboard</h1>
			<div class="alert bg-primary" role="alert"><em class="fa fa-lg fa-user">&nbsp;</em> WELCOME TO THE <?php echo strtoupper($_SESSION['userType']) ?> DASHBOARD USER <?php echo strtoupper($_SESSION['userUsername']) ?>
			<?php echo $_SESSION['userType'];?>
			</div>
		</div>
	</div>

</div>
<?php include "templates/footer.php"; ?>