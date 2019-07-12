<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'counselor' && $_SESSION['userType'] != 'admin')
        header("Location: index.php");
        
    $database = new Connection();
    $db = $database->openConnection();

    $sql = 'SELECT `stud_number`, `stud_lname`, `stud_fname` FROM `student_tb` ORDER BY `stud_number`';
    
 
    $students = $db->query($sql);
    $students->setFetchMode(PDO::FETCH_ASSOC);


?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Counseling Summary Report</li>
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
        <div class="panel-heading">Counseling Summary Report
            <a href="add_creport.php"><button type="button" class="btn btn-lg btn-primary pull-right">Add Report</button></a>
        </div>
        <div class="panel-body btn-margins">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Consulting Date</th>
                            <th>Consulting Status</th>
                            <th>Encoded By</th>
                            <th>Encoded On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $students->fetch()): ?>
                        <tr>
                            <?php
                                $stmt = "SELECT `studstatus_id` FROM studstatus_tb WHERE '" .$row['stud_number']."' = `stud_number`";
                                $stmtExec = $db->query($stmt);
                                $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
                                $row2 = $stmtExec->fetch();
                                $studStatusId = $row2['studstatus_id'];
                            
                                $stmt2 = "SELECT `counseling_id`, `counseling_date`, `counseling_status`, `cdate_encoded`, `user_id` from `counseling_tb` where '".$studStatusId."' = `studstatus_id`";
                                $stmtExec2 = $db->query($stmt2);
                                if($stmtExec2->rowCount() > 0){
                                    $stmtExec2->setFetchMode(PDO::FETCH_ASSOC);
                                    $row3 = $stmtExec2->fetch();
                                    $cDate = $row3['counseling_date'];
                                    $cStatus = $row3['counseling_status'];
                                    $cEncode = $row3['cdate_encoded'];
                                    $cId = $row3['counseling_id'];
                                    $users='SELECT `user_username` from `user_tb` where `user_id` = '. $row3['user_id'];
                                    $user = $db->query($users);
                                    $user->setFetchMode(PDO::FETCH_ASSOC);
                                    $user = $user->fetch();
                            

                                    echo "<td>".htmlspecialchars($row['stud_number'])."</td>";
                                    echo "<td>".htmlspecialchars($row['stud_lname'])."</td>";
                                    echo "<td>".htmlspecialchars($row['stud_fname'])."</td>";
                                    echo "<td>".htmlspecialchars($cDate)."</td>";
                                    echo "<td>".htmlspecialchars($cStatus)."</td>";
                                    echo "<td>".htmlspecialchars($user['user_username'])."</td>";
                                    echo "<td>".htmlspecialchars($cEncode)."</td>";
                                    echo "<td>";
                                    echo "<a href='creport.php?c_id=".$cId."&stud_num=".$row['stud_number']."'><button type='button' class='btn btn-sm btn-primary'>view</button>";
                                    echo "<a href='edit_creport.php?c_id=".$cId."&stud_num=".$row['stud_number']."'><button type='button' class='btn btn-sm btn-warning'>Edit</button></a>";
                                    echo "<a href='del_creport.php?c_id=".$cId."'><button type='button' class='btn btn-sm btn-danger'>Delete</button></a>";
                                    echo "</td>";
                                } 
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