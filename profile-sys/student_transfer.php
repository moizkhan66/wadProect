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

        $stmt = "SELECT `grade_id`, `section_id` FROM studstatus_tb WHERE '" .$studNum."' = `stud_number`";
        $stmtExec = $db->query($stmt);
        $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
        $row2 = $stmtExec->fetch();
        $gradeId = $row2['grade_id'];
        $sectionId = $row2['section_id'];

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
    }
    if(isset($_POST['grade_transfer']))
    {
        $studNum = $_POST['stud_num'];
        $gradeLvl = $_POST['grade_lvl'];
        $section = $_POST['section'];
        
        $data1 = [
            "gradeId" => $gradeLvl,
            "sectionId" => $section,
        ];
        
        $pdo = "UPDATE `studstatus_tb` SET  `grade_id`=:gradeId, `section_id`=:sectionId where `stud_number` = '". $studNum ."'";

        $pdo = $db->prepare($pdo);
        
        $pdoExec = $pdo->execute($data1);

        if($pdoExec)
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
            <li class="active">Transfer Student</li>
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
    
        <div class="panel-heading clearfix">Transfer Student</div>
        <div class="panel-body"><span class="panel-heading">From</span>
            <div class="form-horizontal row-border" action="edit_student.php" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">Grade Level</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" readonly value="<?php echo $gradeLvl;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Section</label>
                    <div class="col-xs-5">
                        <input type="text" readonly class="form-control" value="<?php echo $section;?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body"><span class="panel-heading">To</span>
            <form class="form-horizontal row-border" action="student_transfer.php" method="post">
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
                    <input type="hidden" value="<?php echo $studNum?>" name="stud_num">
                    <button type="submit" name="grade_transfer" class="btn btn-primary center-block">Transfer Grade</button>   
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>