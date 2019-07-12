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

        $sql = 'SELECT `stud_number`, `stud_lname`, `stud_fname`, `gender`, `birthdate`, `nationality` FROM `student_tb` where `stud_number` = "' . $studNum . '"';
    
        $students = $db->query($sql);
        $students->setFetchMode(PDO::FETCH_ASSOC);
        $student = $students->fetch();

        $stmt = "SELECT `studstatus_id`, `stud_status`, `grade_id`, `section_id`, `ay_id` FROM studstatus_tb WHERE '" .$student['stud_number']."' = `stud_number`";
        $stmtExec = $db->query($stmt);
        $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
        $row2 = $stmtExec->fetch();
        $studStatusId = $row2['studstatus_id'];
        $studStatus = $row2['stud_status'];
        $gradeId = $row2['grade_id'];
        $sectionId = $row2['section_id'];
        $ayId = $row2['ay_id'];


        $stmt2 = "SELECT `grade_level` FROM grade_tb WHERE '" .$gradeId."' = `grade_id`";
        $stmtExec2 = $db->query($stmt2);
        $stmtExec2->setFetchMode(PDO::FETCH_ASSOC);
        $row3 = $stmtExec2->fetch();
        $gradeLvl = $row3['grade_level'];
        
        $stmt3 = "SELECT `section` FROM section_tb WHERE '" .$sectionId."' = `section_id`";
        $stmtExec3 = $db->query($stmt3);
        $stmtExec3->setFetchMode(PDO::FETCH_ASSOC);
        $row4 = $stmtExec3->fetch();
        $section = $row4['section'];

        $stmt4 = "SELECT `ay_name` FROM `ay_tb` WHERE `ay_id` = ". $ayId;
        $stmtExec4 = $db->query($stmt4);
        $stmtExec4->setFetchMode(PDO::FETCH_ASSOC);
        $row5 = $stmtExec4->fetch();
        $ayName = $row5['ay_name'];

    }
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Admin Add User</li>
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
        <div class="panel-heading clearfix">Student Profile</div>
        <div class="panel-body">
            <div class="form-horizontal row-border">
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Number</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_num" class="form-control" value="<?php echo $student['stud_number'];?>" readonly>
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
                    <label class="col-md-2 control-label">Grade Level</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_fname" class="form-control" value="<?php echo $gradeLvl;?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Section</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_fname" class="form-control" value="<?php echo $section;?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Birthdate</label>
                    <div class="col-xs-5">
                        <input type="date" name="bdate" class="form-control" value="<?php echo $student['birthdate'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Gender</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" value="<?php echo $student['gender'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Nationality</label>
                    <div class="col-xs-5">
                        <input type="text" name="nationality" class="form-control" value="<?php echo $student['nationality'];?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Status</label>
                    <div class="col-xs-5">
                        <input type="text" name="nationality" class="form-control" value="<?php echo $studStatus;?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <a href="edit_student.php?stud_num=<?php echo $studNum;?>"><button class="btn btn-primary center-block">Edit Student</button></a>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>