<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'staff' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");

    $database = new Connection();
    $db = $database->openConnection();

    if(isset($_GET['a_id']))
    {
        $apId = $_GET['a_id'];        
        
        $sql = 'DELETE FROM `anecdotal_tb` WHERE `anecdotal_id` = "'. $aId .'"';
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="#">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Report Delete</li>
				</ol>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Report Delete</h1>
                    <?php 
                        if(isset($_GET['a_id'])){
                            if($stmt){
                                echo "<div class='alert bg-success' role='alert'>Report Deleted</div>";                        
                            }
                        }
                    ?>

				</div>
			</div>

			
		</div>	
<?php include "templates/footer.php"; ?>