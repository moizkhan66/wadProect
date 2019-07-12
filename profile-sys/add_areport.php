<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'staff' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");

    $database = new Connection();
    $db = $database->openConnection();

    if(isset($_POST['add_areport']))
    {
        $studNum = $_POST['stud_num'];
        $studLname = $_POST['stud_lname'];
        $studFname = $_POST['stud_fname'];    
        $aDate = $_POST['a_date'];
        $aNote = $_POST['a_note'];
        $aGiver = $_POST['a_giver'];
        
        $stmt = 'SELECT `studstatus_id` FROM studstatus_tb WHERE "'.$studNum.'" = `stud_number`';
        $stmtExec = $db->query($stmt);
        $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmtExec->fetch();
        $studStatusId = $row['studstatus_id'];
        echo "studentID=>".$studStatusId;

        $pdoQuery = "INSERT INTO `anecdotal_tb` (`anecdotal_date`, `anecdotal_note`, `anecdotal_giver`, `studstatus_id`, `user_id`) 
                    VALUES (:a_date, :a_note, :a_giver, :studstatus_id, :userId)"; 
    
        $pdoResult = $db->prepare($pdoQuery);
        
        $pdoExec = $pdoResult->execute(array(
            ':a_date' => $aDate,
            ':a_note' => $aNote,
            ':a_giver' => $aGiver,
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
            <li class="active">Add Anecdotal Summary Report</li>
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
        if(isset($_POST['add_areport'])){
            if($pdoExec)
            {
                echo "<div class='alert bg-success' role='alert'>Report Added</div>";
            }else{
                echo "<div class='alert bg-warning' role='alert'>Error Adding Report</div>";
            }
        }
        ?>
        <div class="panel-heading clearfix">Add Anecdotal Summary Report</div>
        <div class="panel-body">
            <form class="form-horizontal row-border" action="add_areport.php" method="post">
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
                    <label class="col-md-2 control-label">Anecdotal Date</label>
                    <div class="col-xs-5">
                        <input type="date" name="a_date" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Anecdotal Note</label>
                    <div class="col-xs-5">
                        <input type="text" name="a_note" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Anecdotal Giver</label>
                    <div class="col-xs-5">
                        <input type="text" name="a_giver" class="form-control">
                    </div>
                </div>
                <div class="form-group">    
                    <button type="submit" name="add_areport" class="btn btn-primary center-block">Add Report</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>