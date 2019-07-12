<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'counselor' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");

    $database = new Connection();
    $db = $database->openConnection();

    if(isset($_GET['c_id']) && isset($_GET['stud_num']))
    {
        $cId = $_GET['c_id'];
        $studNum = $_GET['stud_num'];
        
        $sql = 'SELECT `term`, `counseling_date`, `counseling_concern`, `action_plan`, `counseling_status`, 
        `user_id`, `cdate_encoded`, `studstatus_id` FROM `counseling_tb` WHERE `counseling_id` = ' . $cId;
        
        $cReport = $db->query($sql);
        $cReport->setFetchMode(PDO::FETCH_ASSOC);
        $row = $cReport->fetch();

        $sql2 = 'SELECT `stud_lname`, `stud_fname` FROM `student_tb` WHERE `stud_number` = "' .$studNum.'"';
    
        $students = $db->query($sql2);
        $students->setFetchMode(PDO::FETCH_ASSOC);
        $student = $students->fetch();
    }

    if(isset($_POST['edit_creport']))
    {
        $cId = $_POST['c_id'];
        $studNum = $_POST['stud_num'];
        $studLname = $_POST['stud_lname'];
        $studFname = $_POST['stud_fname'];    
        $cDate = $_POST['c_date'];
        $cConcern = $_POST['c_concern'];
        $term = $_POST['term'];
        $actionPlan = $_POST['action_plan'];
        $cStatus = $_POST['c_status'];

        $stmt = 'SELECT `studstatus_id` FROM studstatus_tb WHERE "'.$studNum.'" = `stud_number`';
        $stmtExec = $db->query($stmt);
        $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmtExec->fetch();
        $studStatusId = $row['studstatus_id'];

        $data1 = [
            'c_date' => $cDate,
            'c_concern' => $cConcern,
            'actionPlan' => $actionPlan,
            'c_status' => $cStatus,
            'studStatus_id' => $studStatusId,
            'term' => $term
        ];

        $pdoQuery = "UPDATE `counseling_tb` SET `counseling_date`=:c_date, `counseling_concern`=:c_concern, `action_plan`=:actionPlan, `counseling_status`=:c_status, 
        `studstatus_id`=:studStatus_id, `term`=:term where `counseling_id` = " .$cId; 
    
        $pdoResult = $db->prepare($pdoQuery);
        
        $pdoExec = $pdoResult->execute($data1);
    }
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Add Counseling Report</li>
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
            if(isset($_POST['edit_creport'])){
                if($pdoExec)
                {
                    header("Location: creport.php?c_id=".$cId."&stud_num=" . $studNum);
                }
            }
        ?>
        <div class="panel-heading clearfix">Edit Counseling Report</div>
        <div class="panel-body">
            <form class="form-horizontal row-border" action="edit_creport.php" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Number</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_num" class="form-control" value="<?php echo $studNum; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Last Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_lname" class="form-control" value="<?php echo $student['stud_lname']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student First Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_fname" class="form-control" value="<?php echo $student['stud_fname']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group">    
                    <label class="col-md-2 control-label">Counseling Date</label>
                    <div class="col-xs-5">
                        <input type="date" name="c_date" class="form-control" value="<?php echo $row['counseling_date']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Counseling Concern</label>
                    <div class="col-xs-5">
                        <input type="text" name="c_concern" class="form-control" value="<?php echo $row['counseling_concern']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Action Plane</label>
                    <div class="col-xs-5">
                        <input type="text" name="action_plan" class="form-control" value="<?php echo $row['action_plan']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Counseling Status</label>
                    <div class="col-xs-5">
                        <select name="c_status" class="form-control" value="<?php echo $row['counseling_status']; ?>">
                        For Follow u
                            <option value="For Follow Up">For Follow Up</option>
                            <option value="Case Closed">Case Closed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="c_id" value="<?php echo $cId;?>">    
                    <button type="submit" name="edit_creport" class="btn btn-primary center-block">Edit Report</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>