<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';
    if($_SESSION['userType'] != 'psychometrician' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");

    $database = new Connection();
    $db = $database->openConnection();

    if(isset($_GET['p_id']) && isset($_GET['stud_num']))
    {
        $pId = $_GET['p_id'];
        $studNum = $_GET['stud_num'];
        
        $sql = 'SELECT `psycht_date`, `test_type`, `test_name`, `pdate_encoded`, 
                `user_id`, `studstatus_id` FROM `pshycht_tb` WHERE psycht_id = '.$pId;

        $pReport = $db->query($sql);
        $pReport->setFetchMode(PDO::FETCH_ASSOC);
        $row = $pReport->fetch();

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

    if(isset($_POST['edit_preport']))
    {
        $studNum = $_POST['stud_num'];    
        $tDate = $_POST['t_date'];
        $tName = $_POST['t_name'];
        $tType = $_POST['t_type'];
        $pId = $_POST['p_id'];

        $stmt = 'SELECT `studstatus_id` FROM studstatus_tb WHERE "'.$studNum.'" = `stud_number`';
        $stmtExec = $db->query($stmt);
        $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmtExec->fetch();
        $studStatusId = $row['studstatus_id'];

        $data1 = [
            't_date' => $tDate,
            't_type' => $tType,
            't_name' => $tName,
            'studstatus_id' => $studStatusId
        ];

        $pdoQuery = "UPDATE `pshycht_tb` SET `psycht_date`=:t_date, `test_type`=:t_type, `test_name`=:t_name, `studstatus_id`=:studstatus_id"; 

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
            <li class="active">Edit Psychological Test summary Report</li>
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
            if(isset($_POST['edit_preport'])){
                if($pdoExec)
                {
                    header("Location: preport.php?p_id=".$pId."&stud_num=" . $studNum);
                }
            }
        ?>
        <div class="panel-heading clearfix">Edit Psychological Test summary Report</div>
        <div class="panel-body">
            <form class="form-horizontal row-border" action="edit_preport.php" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Number</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_num" class="form-control" value="<?php echo $studNum;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Last Name</label>
                    <div class="col-xs-5">
                        <input readonly type="text" name="stud_lname" class="form-control" value="<?php echo $student['stud_lname'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student First Name</label>
                    <div class="col-xs-5">
                        <input readonly type="text" name="stud_fname" class="form-control" value="<?php echo $student['stud_fname'];?>">
                    </div>
                </div>
                <div class="form-group">    
                    <label class="col-md-2 control-label">Test Date</label>
                    <div class="col-xs-5">
                        <input type="date" name="t_date" class="form-control" value="<?php echo $row['psycht_date'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Test Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="t_name" class="form-control" value="<?php echo $row['test_name'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Test Type</label>
                    <div class="col-xs-5">
                        <input type="text" name="t_type" class="form-control" value="<?php echo $row['test_type'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="p_id" value="<?php echo $pId;?>">    
                    <button type="submit" name="edit_preport" class="btn btn-primary center-block">Edit Report</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>