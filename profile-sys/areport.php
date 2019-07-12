<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';
    if($_SESSION['userType'] != 'staff' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");

    $database = new Connection();
    $db = $database->openConnection();
    
    if(isset($_GET['a_id']) && isset($_GET['stud_num']))
    {
        $aId = $_GET['a_id'];
        $studNum = $_GET['stud_num'];
        
        $sql = 'SELECT `anecdotal_date`, `anecdotal_note`, `anecdotal_giver`, 
        `giver_rltn`, `user_id`, `adate_encoded`, `studstatus_id` FROM `anecdotal_tb` WHERE anecdotal_id = '.$aId;

        $aReport = $db->query($sql);
        $aReport->setFetchMode(PDO::FETCH_ASSOC);
        $row = $aReport->fetch();

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
            <li class="active">Psychological Report</li>
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
        <div class="panel-heading clearfix">Psychological Repot</div>
        <div class="panel-body">
            <div class="form-horizontal row-border">
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Number</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_ num" class="form-control" value="<?php echo $studNum;?>" readonly>
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
                    <label class="col-md-2 control-label">Anecdotal Date</label>
                    <div class="col-xs-5">
                        <input type="date" class="form-control" value="<?php echo $row['anecdotal_date'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Anecdotal Note</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" value="<?php echo $row['anecdotal_note'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Anecdotal Giver</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" value="<?php echo $row['anecdotal_giver'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Date Encoded</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" value="<?php echo $row['adate_encoded'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Encoded By</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" value="<?php echo $user['user_username'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <a href="gen_areport.php?a_id=<?php echo $aId;?>&stud_num=<?php echo $studNum;?>"><button class="btn btn-primary center-block">Generate Report</button></a>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>