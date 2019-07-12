<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';
    
    $database = new Connection();
    $db = $database->openConnection();

    if(isset($_POST['change_pass']))
    {

        $newPass = $_POST['new_pass'];
        $repPass = $_POST['rep_pass'];
        
        $pdoExec = -1;
        if($newPass == $repPass){
            $hash = password_hash($newPass, PASSWORD_BCRYPT);
            $data = [
                "userPass" => $hash
            ];
            
            $pdoQuery = "UPDATE `user_tb` SET `user_password`=:userPass WHERE `user_id` = ". $_SESSION['userId'];
            
            $pdoResult = $db->prepare($pdoQuery);
            
            $pdoExec = $pdoResult->execute($data);
        }
        
}
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">User Change Password</li>
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
            if(isset($_POST['change_pass'])){
                if($pdoExec)
                {
                    echo "<div class='alert bg-success' role='alert'>Password updated</div>";
                }else{
                    echo "<div class='alert bg-warning' role='alert'>Error Updating Password</div>";
                }
            }
        ?>
        <div class="panel-heading clearfix">Change Password</div>
        <div class="panel-body">
            <form class="form-horizontal row-border" action="password.php" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">New Password</label>
                    <div class="col-xs-5">
                        <input type="text" name="new_pass" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Repeat Password</label>
                    <div class="col-xs-5">
                        <input type="text" name="rep_pass" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">    
                    <button type="submit" name="change_pass" class="btn btn-primary center-block">Update Password</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>