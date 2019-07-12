<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';
    
    $database = new Connection();
    $db = $database->openConnection();

    $stmt = 'SELECT  `user_name`, `user_email`, `license_id`, `license_ed`, 
    `user_status`, `user_contact` FROM `user_tb` WHERE `user_id` = ' . $_SESSION['userId'];
    $stmtExec = $db->query($stmt);
    $stmtExec->setFetchMode(PDO::FETCH_ASSOC);
    $row = $stmtExec->fetch();

    if(isset($_POST['update_user']))
    {

        $userName = $_POST['user_name'];
        $userUsername = $_POST['user_username'];
        $userEmail = $_POST['user_email'];
        $licNumber = $_POST['lic_number'];
        $licDate = $_POST['lic_date'];
        $userStatus = $_POST['user_status'];
        $userPhone = $_POST['user_num'];
        
        $data = [
            "userName" => $userName,
            "userEmail" => $userEmail,
            "userUsername" => $userUsername,
            "licId" => $licNumber,
            "licEd" => $licDate,
            "userStatus" => $userStatus,
            "userNum" => $userPhone
        ];
        
        $pdoQuery = "UPDATE `user_tb` SET `user_name`=:userName,`user_email`=:userEmail,`user_username`=:userUsername,
        `license_id`=:licId,`license_ed`=:licEd,`user_status`=:userStatus,`user_contact`=:userNum WHERE `user_id` = ". $_SESSION['userId'];
        
        $pdoResult = $db->prepare($pdoQuery);
        
        $pdoExec = $pdoResult->execute($data);
}
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Admin Edit User</li>
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
            if(isset($_POST['update_user'])){
                if($pdoExec)
                {
                    echo "<div class='alert bg-success' role='alert'>User updated</div>";
                    header("Location: user_profile.php");
                }else{
                    echo "<div class='alert bg-warning' role='alert'>Error Updating User</div>";
                }
            }
        ?>
        <div class="panel-heading clearfix">Edit User</div>
        <div class="panel-body">
            <form class="form-horizontal row-border" action="user_profile.php" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">User UserName</label>
                    <div class="col-xs-5">
                        <input type="text" name="user_username" class="form-control" value="<?php echo $_SESSION['userUsername'];?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User Real Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="user_name" class="form-control" value="<?php echo $row['user_name'];?>">
                    </div>
                </div>
                <div class="form-group">    
                    <label class="col-md-2 control-label">User Email</label>
                    <div class="col-xs-5">
                        <input type="email" name="user_email" class="form-control" value="<?php echo $row['user_email'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">License Number</label>
                    <div class="col-xs-5">
                        <input type="text" name="lic_number" class="form-control" value="<?php echo $row['license_id'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">License Effectivity Date</label>
                    <div class="col-xs-5">
                        <input type="text" name="lic_date" class="form-control" value="<?php echo $row['license_ed'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User Phone Number</label>
                    <div class="col-xs-5">
                        <input type="number" name="user_num" class="form-control"  value="<?php echo $row['user_contact'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User Status</label>
                    <div class="col-xs-5">
                        <input type="text" name="user_status" class="form-control" value="<?php echo $row['user_status'];?>">
                    </div>
                </div>
                <div class="form-group">    
                    <button type="submit" name="update_user" class="btn btn-primary center-block">Update User</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>