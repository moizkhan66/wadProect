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

    if(isset($_POST['edit_areport']))
    {
        $studNum = $_POST['stud_num'];    
        $aDate = $_POST['a_date'];
        $aNote = $_POST['a_note'];
        $aGiver = $_POST['a_giver'];
        $aId = $_POST['a_id'];

        $stmt = 'SELECT `studstatus_id` FROM studstatus_tb WHERE "'.$studNum.'" = `stud_number`';
        $stmtExec = $db->query($stmt);
        $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmtExec->fetch();
        $studStatusId = $row['studstatus_id'];
        echo "studentID=>".$studStatusId;

        $data1 = [
            'a_date' => $aDate,
            'a_note' => $aNote,
            'a_giver' => $aGiver,
            'studstatus_id' => $studStatusId
        ];

        $pdoQuery = "UPDATE `anecdotal_tb` SET `anecdotal_date`=:a_date, `anecdotal_note`=:a_note, `anecdotal_giver`=:a_giver, 
        `studstatus_id`=:studstatus_id WHERE `anecdotal_id` = ". $aId; 
    
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
            <li class="active">Edit Anecdotal Summary Report</li>
        </ol>
    </div>

    <<div class="row">
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
        if(isset($_POST['edit_areport'])){
            if($pdoExec)
            {
                header("Location: areport.php?a_id=".$aId."&stud_num=" . $studNum);
            }
        }
        ?>
        <div class="panel-heading clearfix">Edit Anecdotal Summary Report</div>
        <div class="panel-body">
            <form class="form-horizontal row-border" action="edit_areport.php" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Number</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_num" class="form-control" value="<?php echo $studNum;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Last Name</label>
                    <div class="col-xs-5">
                        <input readonly type="text" class="form-control" value="<?php echo $student['stud_lname'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student First Name</label>
                    <div class="col-xs-5">
                        <input readonly type="text" class="form-control" value="<?php echo $student['stud_fname'];?>">
                    </div>
                </div>
                <div class="form-group">    
                    <label class="col-md-2 control-label">Anecdotal Date</label>
                    <div class="col-xs-5">
                        <input type="date" name="a_date" class="form-control" value="<?php echo $row['anecdotal_date'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Anecdotal Note</label>
                    <div class="col-xs-5">
                        <input type="text" name="a_note" class="form-control" value="<?php echo $row['anecdotal_note'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Anecdotal Giver</label>
                    <div class="col-xs-5">
                        <input type="text" name="a_giver" class="form-control" value="<?php echo $row['anecdotal_giver'];?>">
                    </div>
                </div>
                <div class="form-group">  
                    <input type="hidden" value="<?php echo $aId;?>" name="a_id">  
                    <button type="submit" name="edit_areport" class="btn btn-primary center-block">Edit Report</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>