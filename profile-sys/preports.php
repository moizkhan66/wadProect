<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';
    if($_SESSION['userType'] != 'psychometrician' && $_SESSION['userType'] != 'admin')
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
            <li class="active">Pscychological Tests Summary Report</li>
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
        <div class="panel-heading">Pscychological Tests Summary Report
            <a href="add_preport.php"><button type="button" class="btn btn-lg btn-primary pull-right">Add Report</button></a>
        </div>
        <div class="panel-body btn-margins">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Test Date</th>
                            <th>Test Type</th>
                            <th>Test Name</th>
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
                            
                                $stmt2 = "SELECT `psycht_id`,`psycht_date`, `test_type`, `test_name`, `pdate_encoded` from `pshycht_tb` where '".$studStatusId."' = `studstatus_id`";
                                $stmtExec2 = $db->query($stmt2);
                                if($stmtExec2->rowCount() > 0){
                                    $stmtExec2->setFetchMode(PDO::FETCH_ASSOC);
                                    $row3 = $stmtExec2->fetch();
                                    $pDate = $row3['psycht_date'];
                                    $tType = $row3['test_type'];
                                    $tName = $row3['test_name'];
                                    $pDateE = $row3['pdate_encoded'];
                                    $pId = $row3['psycht_id'];

                                    echo "<td>".htmlspecialchars($row['stud_number'])."</td>";
                                    echo "<td>".htmlspecialchars($row['stud_lname'])."</td>";
                                    echo "<td>".htmlspecialchars($row['stud_fname'])."</td>";
                                    echo "<td>".htmlspecialchars($pDate)."</td>";
                                    echo "<td>".htmlspecialchars($tType)."</td>";
                                    echo "<td>".htmlspecialchars($tName)."</td>";
                                    echo "<td>".htmlspecialchars($pDateE)."</td>";
                                    echo "<td>";
                                    echo "<a href='preport.php?p_id=".$pId."&stud_num=".$row['stud_number']."'><button type='button' class='btn btn-sm btn-primary'>view</button></a>";
                                    echo "<a href='edit_preport.php?p_id=".$pId."&stud_num=".$row['stud_number']."'><button type='button' class='btn btn-sm btn-warning'>Edit</button></a>";
                                    echo "<a href='del_preport.php?p_id=".$pId."'><button type='button' class='btn btn-sm btn-danger'>Delete</button></a>";
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