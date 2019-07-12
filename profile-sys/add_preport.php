<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';
    if($_SESSION['userType'] != 'psychometrician' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");

    $database = new Connection();
    $db = $database->openConnection();

    if(isset($_POST['add_preport']))
    {
        $studNum = $_POST['stud_num'];
        $studLname = $_POST['stud_lname'];
        $studFname = $_POST['stud_fname'];    
        $tDate = $_POST['t_date'];
        $tName = $_POST['t_name'];
        $tType = $_POST['t_type'];
        
        $stmt = 'SELECT `studstatus_id` FROM studstatus_tb WHERE "'.$studNum.'" = `stud_number`';
        $stmtExec = $db->query($stmt);
        $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmtExec->fetch();
        $studStatusId = $row['studstatus_id'];

        $pdoQuery = "INSERT INTO `pshycht_tb`(`psycht_date`, `test_type`, `test_name`, `studstatus_id`, `user_id`) 
                    VALUES (:t_date, :t_type, :t_name, :studstatus_id, :userId)"; 
    
        $pdoResult = $db->prepare($pdoQuery);
        
        $pdoExec = $pdoResult->execute(array(
            ':t_date' => $tDate,
            ':t_type' => $tType,
            ':t_name' => $tName,
            ':studstatus_id' => $studStatusId,
            ':userId' => $_SESSION['userId']
        ));
}
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Add Psychological Test summary Report</li>
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

    <div class="panel panel-default">
        <?php 
            if(isset($_POST['add_preport'])){
                if($pdoExec)
                {
                    echo "<div class='alert bg-success' role='alert'>Report Added</div>";
                }else{
                    echo "<div class='alert bg-warning' role='alert'>Error Adding Report</div>";
                }
            }
        ?>
        <div class="panel-heading clearfix">Add Psychological Test summary Report</div>
        <div class="panel-body">
            <form class="form-horizontal row-border" action="add_preport.php" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Number</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_num" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Last Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_lname" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student First Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_fname" class="form-control">
                    </div>
                </div>
                <div class="form-group">    
                    <label class="col-md-2 control-label">Test Date</label>
                    <div class="col-xs-5">
                        <input type="date" name="t_date" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Test Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="t_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Test Type</label>
                    <div class="col-xs-5">
                        <input type="text" name="t_type" class="form-control">
                    </div>
                </div>
                <div class="form-group">    
                    <button type="submit" name="add_preport" class="btn btn-primary center-block">Add Report</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>