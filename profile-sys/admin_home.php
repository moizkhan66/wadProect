<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'admin')
        header("Location: index.php");
        
    $database = new Connection();
    $db = $database->openConnection();

    $sql = "SELECT count(*) FROM `user_tb`"; 
    $result = $db->prepare($sql); 
    $result->execute(); 
    $userNum = $result->fetchColumn();

    $sql = "SELECT COUNT(DISTINCT `user_id`) FROM `counseling_tb`"; 
    $result = $db->prepare($sql); 
    $result->execute(); 
    $counselNum = $result->fetchColumn();

    $sql = "SELECT COUNT(DISTINCT `user_id`) FROM `pshycht_tb`"; 
    $result = $db->prepare($sql); 
    $result->execute(); 
    $psyNum = $result->fetchColumn();

    $sql = "SELECT COUNT(DISTINCT `user_id`) FROM `anecdotal_tb`"; 
    $result = $db->prepare($sql); 
    $result->execute(); 
    $aNotes = $result->fetchColumn();        
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Admin Dashboard</li>
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
        <div class="panel-body btn-margins">
            <div class="col-md-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Total Number of Students: </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql1 = "select grade_id, count(distinct studstatus_id) from studstatus_tb a where exists (select * from student_tb
                        where grade_id = a.grade_id ) group by grade_id";
                        $result1 = $db->prepare($sql1); 
                        $result1->execute(); 
                        while($row1=$result1->fetch()) {
                            $counts[] = $row1; 
                        }

                        $grades='SELECT `grade_id`, `grade_level` FROM `grade_tb` ORDER BY `grade_id`';
                        $grades = $db->query($grades);
                        $grades->setFetchMode(PDO::FETCH_ASSOC);
                        while($row=$grades->fetch()) {
                            $res[] = $row; 
                        }
                        $check = false;
                        foreach($res as $record){
                            foreach($counts as $count){
                                if($record['grade_id'] == $count['grade_id']){
                                    echo "<tr>";
                                    echo "<td> ".$count['count(distinct studstatus_id)']." Number of students in Grade ".$record['grade_level']."</td>";
                                    echo "</tr>";
                                    $check = true;
                                }
                            }
                            if($check == false)
                            {
                                echo "<tr>";
                                echo "<td> 0 Number of students in Grade ".$record['grade_level']."</td>";
                                echo "</tr>";
                            }
                            $check = false;
                        }
                    
                            
                    ?>        
                    </tbody>
                </table>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-xs-12 col-md-4 col-lg-4 no-padding center-block">
                        <div class="panel panel-teal panel-widget border-right">
                            <div class="row no-padding"><em class="fa fa-xl fa-users color-blue"></em>
                                <div class="large"><?php echo $userNum;?></div>
                                <div class="text-muted">Users</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4 no-padding">
                        <div class="panel panel-blue panel-widget border-right">
                            <div class="row no-padding"><em class="fa fa-xl fa-comments color-orange"></em>
                                <div class="large"><?php echo $counselNum;?></div>
                                <div class="text-muted">of consulted Students for the Current A.Y.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4 no-padding">
                        <div class="panel panel-blue panel-widget border-right">
                            <div class="row no-padding"><em class="fa fa-xl fa-comments color-orange"></em>
                                <div class="large"><?php echo $counselNum;?></div>
                                <div class="text-muted">of consulted Students for the Current A.Y.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4 col-lg-4 no-padding">
                        <div class="panel panel-orange panel-widget border-right">
                            <div class="row no-padding"><em class="fa fa-xl fa-user-md color-teal"></em>
                                <div class="large"><?php echo $psyNum;?></div>
                                <div class="text-muted">of psychologival Tests taken for the Current A.Y.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4 no-padding">
                        <div class="panel panel-red panel-widget ">
                            <div class="row no-padding"><em class="fa fa-xl fa-user-md color-red"></em>
                                <div class="large"><?php echo $psyNum;?></div>
                                <div class="text-muted">of psychologival Tests taken for the Current A.Y.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4 no-padding">
                        <div class="panel panel-red panel-widget ">
                            <div class="row no-padding"><em class="fa fa-xl fa-sticky-note"></em>
                                <div class="large"><?php echo $aNotes;?></div>
                                <div class="text-muted">of Anecdotal Notes Received for the Current A.Y.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Calendar
                            </div>
                            <div class="panel-body">
                                <div id="calendar"></div>
                            </div>
                        </div>

                    
                </div>
            </div>
        </div>

    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>