<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'staff' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");
        
    $database = new Connection();
    $db = $database->openConnection();

    if(isset($_GET['stud_num']))
    {
        $studNum = $_GET['stud_num'];        
        
        $sql = 'DELETE FROM `student_tb` WHERE `stud_number` = "'. $studNum .'"';
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
					<li class="active">User Delete</li>
				</ol>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Student Delete</h1>
                    <?php 
                        if(isset($_GET['stud_num'])){
                            if($stmt){
                                echo "<div class='alert bg-success' role='alert'>Student Deleted</div>";                        
                            }
                        }
                    ?>

				</div>
			</div>

			
		</div>	
<?php include "templates/footer.php"; ?>