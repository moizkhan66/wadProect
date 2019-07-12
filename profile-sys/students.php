<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'staff' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");

    $database = new Connection();
    $db = $database->openConnection();

    $sql = 'SELECT `stud_number`, `stud_lname`, `stud_fname`, `user_id` FROM `student_tb` ORDER BY `stud_number`';
 
    $students = $db->query($sql);
    $students->setFetchMode(PDO::FETCH_ASSOC);
    
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Students</li>
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
        <div class="panel-heading">Students
            <a href="add_student.php"><button type="button" class="btn btn-lg btn-primary pull-right">Add Student</button></a>
        </div>
        <div class="panel-body btn-margins">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Grade</th>
                            <th>Section</th>
                            <th>Student Status</th>
                            <th>Student Encoder</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $students->fetch()): ?>
                        <tr>
                        <?php
                            $users='SELECT `user_username` from `user_tb` where `user_id` = '. $row['user_id'];
                            $user = $db->query($users);
                            $user->setFetchMode(PDO::FETCH_ASSOC);
                            $user = $user->fetch();

                            $stmt = "SELECT `studstatus_id`, `stud_status`, `grade_id`, `section_id` FROM studstatus_tb WHERE '" .$row['stud_number']."' = `stud_number`";
                            $stmtExec = $db->query($stmt);
                            $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
                            $row2 = $stmtExec->fetch();
                            $studStatusId = $row2['studstatus_id'];
                            $studStatus = $row2['stud_status'];
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

                            echo "<td>".htmlspecialchars($row['stud_number'])."</td>";
                            echo "<td>".htmlspecialchars($row['stud_lname'])."</td>";
                            echo "<td>".htmlspecialchars($row['stud_fname'])."</td>";
                            echo "<td>".htmlspecialchars($gradeLvl)."</td>";
                            echo "<td>".htmlspecialchars($section)."</td>";
                            echo "<td>".htmlspecialchars($studStatus)."</td>";
                            echo "<td>".htmlspecialchars($user['user_username'])."</td>";
                            echo "<td>";
                            echo "<a href='student.php?stud_num=".$row['stud_number']."'><button type='button' class='btn btn-sm btn-primary'>view</button></a>";
                            echo "<a href='edit_student.php?stud_num=".$row['stud_number']."'><button type='button' class='btn btn-sm btn-warning'>Edit</button>";
                            echo "<a href='student_transfer.php?stud_num=".$row['stud_number']."'><button type='button' class='btn btn-sm btn-warning'>Transfer</button>";
                            echo "<a href='del_student.php?stud_num=".$row['stud_number']."'><button type='button' class='btn btn-sm btn-danger'>Delete</button>";
                            echo "</td>";
                        ?>    
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>