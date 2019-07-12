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

        $users='SELECT `user_username` from `user_tb` where `user_id` = '. $row['user_id'];
        $user = $db->query($users);
        $user->setFetchMode(PDO::FETCH_ASSOC);
        $user = $user->fetch();

        $stmt = "SELECT `ay_id` FROM studstatus_tb WHERE '" .$studNum."' = `stud_number`";
        $stmtExec = $db->query($stmt);
        $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
        $row2 = $stmtExec->fetch();
        $ayId = $row2['ay_id'];


        $sql2 = 'SELECT `stud_lname`, `stud_fname` FROM `student_tb` WHERE `stud_number` = "' .$studNum.'"';
    
        $students = $db->query($sql2);
        $students->setFetchMode(PDO::FETCH_ASSOC);
        $student = $students->fetch();

        $stmt2 = "SELECT `ay_name` FROM `ay_tb` WHERE `ay_id` = ". $ayId;
        $stmtExec2 = $db->query($stmt2);
        $stmtExec2->setFetchMode(PDO::FETCH_ASSOC);
        $row3 = $stmtExec2->fetch();
        $ayName = $row3['ay_name'];
        
    }
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Admin Counseling Report</li>
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
        <div class="panel-heading clearfix">Counseling Repot</div>
        <div class="panel-body">
            <div class="form-horizontal row-border">
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Number</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" value="<?php echo $studNum;?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Last Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_lname" class="form-control" value="<?php echo $student['stud_lname'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student First Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_fname" class="form-control" value="<?php echo $student['stud_fname'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Academic Year</label>
                    <div class="col-xs-5">
                        <input type="date" name="ay" class="form-control" value="<?php echo $ayName;?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Academic Term</label>
                    <div class="col-xs-5">
                        <input type="date" name="ay_start" class="form-control" value="<?php #echo $ayStart;?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Counseling Date</label>
                    <div class="col-xs-5">
                        <input type="date" class="form-control" value="<?php echo $row['counseling_date'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Counseling Concern</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" value="<?php echo $row['counseling_concern'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Action Plan</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" value="<?php echo $row['action_plan'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Counseling Status</label>
                    <div class="col-xs-5">
                        <input type="date" class="form-control" value="<?php echo $row['counseling_status'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Date Encoded</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" value="<?php echo $row['cdate_encoded'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Encoded By</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" value="<?php echo $user['user_username'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <a href="gen_creport.php?c_id=<?php echo $cId;?>&stud_num=<?php echo $studNum;?>"><button class="btn btn-primary center-block">Generate Report</button></a>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>