<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'staff' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");
        
    $database = new Connection();
    $db = $database->openConnection();

    if(isset($_POST['add_stud']))
    {
        $studNum = $_POST['stud_num'];
        $studLname = $_POST['stud_lname'];
        $studFname = $_POST['stud_fname'];    
        $ay = $_POST['ay'];
        $gradeLvl = $_POST['grade_lvl'];
        $section = $_POST['section'];
        $bdate = $_POST['bdate'];
        $gender = $_POST['gender'];
        $nationality = $_POST['nationality'];
        
        $pdoQuery = "INSERT INTO `student_tb`(`stud_number`, `stud_lname`, `stud_fname`, `birthdate`, `gender`, `nationality`, `user_id`) 
        VALUES (:stud_number, :stud_lname, :stud_fname, :birtdate, :gender, :nationality, :userId)";
        $pdoQ2 = "INSERT INTO `ay_tb` (`ay_name`) VALUES (:ay_name)";
        $pdoQ3 = "INSERT INTO `studstatus_tb` (`stud_number`, `grade_id`, `section_id`, `ay_id`)
        VALUES (:stud_num, :grade_id, :section_id, :ay_id)";

        $pdoR1 = $db->prepare($pdoQuery);
        $pdoExec = $pdoR1->execute(array(
            ":stud_number" => $studNum, 
            ":stud_lname" => $studLname,
            ":stud_fname" => $studFname, 
            ":birtdate" => $bdate,
            ":gender" => $gender, 
            ":nationality" => $nationality,
            ':userId' => $_SESSION['userId']
        ));

        $pdoR2 = $db->prepare($pdoQ2);
        $pdoExec2 = $pdoR2->execute(array(
            ":ay_name" => $ay
        ));
        $ay_id = $db->lastInsertId();

        $pdoR3 = $db->prepare($pdoQ3);
        
        $pdoExec3 = $pdoR3->execute(array(
            ":stud_num" => $studNum,
            ":grade_id" => $gradeLvl,
            ":section_id" => $section,
            ":ay_id" => $ay_id
        ));
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
        <?php 
            if(isset($_POST['add_stud'])){
                if($pdoExec && $pdoExec2 && $pdoExec3)
                {
                    echo "<div class='alert bg-success' role='alert'>Student Added</div>";
                }else{
                    echo "<div class='alert bg-warning' role='alert'>Error Adding Student</div>";
                }
            }
        ?>
        <div class="panel-heading clearfix">Add Student</div>
        <div class="panel-body">
            <form class="form-horizontal row-border" action="add_student.php" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Number</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_num" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student Last Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_lname" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Student First Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="stud_fname" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Academic Year</label>
                    <div class="col-xs-5">
                        <input type="date" name="ay" class="form-control" required>
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
                        <select name="grade_lvl" class="form-control">
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
                        <select name="section" class="form-control">
                        <?php while ($row = $sections->fetch()): ?>
                            <option value="<?php echo htmlspecialchars($row['section_id']) ?>"><?php echo htmlspecialchars($row['section']) ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Birthdate</label>
                    <div class="col-xs-5">
                        <input type="date" name="bdate" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Gender</label>
                    <div class="col-xs-5">
                        <select name="gender" class="form-control">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Nationality</label>
                    <div class="col-xs-5">
                        <input type="text" name="nationality" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" name="add_stud" class="btn btn-primary center-block">Add Student</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>