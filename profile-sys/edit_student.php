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

        $stmt4 = "SELECT `ay_name`, `ay_start_date`, `ay_end_date` FROM `ay_tb` WHERE `ay_id` = ". $ayId;
        $stmtExec4 = $db->query($stmt4);
        $stmtExec4->setFetchMode(PDO::FETCH_ASSOC);
        $row5 = $stmtExec4->fetch();
        $ayName = $row5['ay_name'];
        $ayStart = $row5['ay_start_date'];
        $ayEnd = $row5['ay_end_date'];

    }
    if(isset($_POST['edit_stud']))
    {
        $studNum = $_POST['stud_num'];
        $studLname = $_POST['stud_lname'];
        $studFname = $_POST['stud_fname'];    
        $ay = $_POST['ay'];
        $ayId = $_POST['ay_id'];
        $ay_start = $_POST['ay_start'];
        $ay_end = $_POST['ay_end'];
        $gradeLvl = $_POST['grade_lvl'];
        $section = $_POST['section'];
        $bdate = $_POST['bdate'];
        $gender = $_POST['gender'];
        $nationality = $_POST['nationality'];
        $studStatus = $_POST['stud_status'];

        $data1 = [
            "studNumber" => $studNum, 
            "studLname" => $studLname,
            "studFname" => $studFname, 
            "bdate" => $bdate,
            "gnder" => $gender, 
            "nat" => $nationality
        ];

        $data2= [
            "ay_name" => $ay,
            "ay_start" => $ay_start,
            "ay_end" => $ay_end
        ];

        $data3 = [
            "stud_num" => $studNum,
            "gradeId" => $gradeLvl,
            "sectionId" => $section,
            "ayId" => $ayId,
            "studStatus" => $studStatus
        ];
        
        $pdoQuery = "UPDATE `student_tb` SET `stud_number`=:studNumber, `stud_lname`=:studLname, `stud_fname`=:studFname, 
        `birthdate`=:bdate, `gender`=:gnder, `nationality`=:nat where `stud_number` = '" . $studNum ."'";
        $pdoQ2 = "UPDATE `ay_tb` SET `ay_name`=:ay_name, `ay_start_date`=:ay_start, `ay_end_date`=:ay_end where `ay_id` = ". $ayId;
        $pdoQ3 = "UPDATE `studstatus_tb` SET `stud_number`=:stud_num, `grade_id`=:gradeId, `section_id`=:sectionId, `ay_id`=:ayId, `stud_status` =:studStatus where `stud_number` = '". $studNum ."'";

        $pdoR1 = $db->prepare($pdoQuery);
        $pdoExec = $pdoR1->execute($data1);

        $pdoR2 = $db->prepare($pdoQ2);
        $pdoExec2 = $pdoR2->execute($data2);
        $ay_id = $db->lastInsertId();

        $pdoR3 = $db->prepare($pdoQ3);
        
        $pdoExec3 = $pdoR3->execute($data3);

        if($pdoExec && $pdoExec2 && $pdoExec3)
        {
            header("Location: student.php?stud_num=" . $studNum);
        }
    }
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Edit Student Profile</li>
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
        <div class="panel-heading clearfix">Edit Student Profile</div>
        <div class="panel-body">
            <form class="form-horizontal row-border" action="edit_student.php" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Number</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_num" class="form-control" value="<?php echo $student['stud_number'];?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Last Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_lname" class="form-control" value="<?php echo $student['stud_lname'];?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student First Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_fname" class="form-control" value="<?php echo $student['stud_fname'];?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Academic Year</label>
                    <div class="col-xs-5">
                        <input type="date" name="ay" class="form-control" value="<?php echo $ayName;?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Academic Year Start</label>
                    <div class="col-xs-5">
                        <input type="date" name="ay_start" class="form-control" value="<?php echo $ayStart;?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Academic Year End</label>
                    <div class="col-xs-5">
                        <input type="date" name="ay_end" class="form-control" value="<?php echo $ayEnd;?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Grade Level</label>
                    <div class="col-xs-5">
                    <?php
                            $sql = 'SELECT `grade_id`, `grade_level` FROM `grade_tb` ORDER BY `grade_id`';
 
                            $grades = $db->query($sql);
                            $grades->setFetchMode(PDO::FETCH_ASSOC);
                        ?>
                        <select name="grade_lvl" class="form-control" value="<?php echo $gradeLvl;?>">
                        <?php while ($row = $grades->fetch()): ?>
                            <option value="<?php echo htmlspecialchars($row['grade_id']) ?>"><?php echo htmlspecialchars($row['grade_level']) ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Section</label>
                    <div class="col-xs-5">
                    <?php
                            $sql = 'SELECT `section_id`, `section` FROM `section_tb` ORDER BY `section_id`';
 
                            $sections = $db->query($sql);
                            $sections->setFetchMode(PDO::FETCH_ASSOC);
                        ?>
                        <select name="section" class="form-control" value="<?php echo $section;?>">
                        <?php while ($row = $sections->fetch()): ?>
                            <option value="<?php echo htmlspecialchars($row['section_id']) ?>"><?php echo htmlspecialchars($row['section']) ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Birthdate</label>
                    <div class="col-xs-5">
                        <input type="date" name="bdate" class="form-control" value="<?php echo $student['birthdate'];?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Gender</label>
                    <div class="col-xs-5">
                        <input type="text" name="gender" class="form-control" value="<?php echo $student['gender'];?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Nationality</label>
                    <div class="col-xs-5">
                        <input type="text" name="nationality" class="form-control" value="<?php echo $student['nationality'];?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Status</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_status" class="form-control" value="<?php echo $studStatus;?>">
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="ay_id" value="<?php echo $ayId;?>">
                    <button type="submit" name="edit_stud" class="btn btn-primary center-block">Edit Student</button>   
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>