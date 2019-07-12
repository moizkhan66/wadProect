<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'admin')
        header("Location: index.php");
    $database = new Connection();
    $db = $database->openConnection();

    if(isset($_POST['add_user']))
    {

        $userName = $_POST['user_name'];
        $userUsername = $_POST['user_username'];
        $userPass = $_POST['user_pass'];    
        $hash = password_hash($userPass, PASSWORD_BCRYPT);
        $userType= $_POST['user_type'];
        $userEmail = $_POST['user_email'];
        $licNumber = $_POST['lic_number'];
        $licDate = $_POST['lic_date'];
        $userPhone = $_POST['user_num'];
        
        $pdoQuery = "INSERT INTO `user_tb`(`user_name`, `user_email`, `user_username`, `user_password`, `license_id`, `license_ed`, `user_type`, `user_contact`) 
                    VALUES (:userName, :userEmail, :userUsername, :userPass, :licNumber, :licDate, :userType, :user_num)"; 
    
        $pdoResult = $db->prepare($pdoQuery);
        
        $pdoExec = $pdoResult->execute(array(
            ":userName" => $userName,
            ":userEmail" => $userEmail,
            ":userUsername" => $userUsername,
            ":userPass" => $hash,
            ":licNumber" => $licNumber,
            ":licDate" => $licDate,
            ":userType" => $userType,
            ":user_num" => $userPhone
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
            if(isset($_POST['add_user'])){
                if($pdoExec)
                {
                    echo "<div class='alert bg-success' role='alert'>User Added</div>";
                }else{
                    echo "<div class='alert bg-warning' role='alert'>Error Adding User</div>";
                }
            }
        ?>
        <div class="panel-heading clearfix">Add User</div>
        <div class="panel-body">
            <form class="form-horizontal row-border" action="admin_addUser.php" method="post">
                <div class="form-group">
                    <label class="col-md-2 control-label">User Type</label>
                    <div class="col-xs-5">
                        <select name="user_type" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="counselor">Counselor</option>
                            <option value="psychometrician">Psychometrician</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User UserName</label>
                    <div class="col-xs-5">
                        <input type="text" name="user_username" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User Password</label>
                    <div class="col-xs-5">
                        <input type="password" name="user_pass" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User Real Name</label>
                    <div class="col-xs-5">
                        <input type="text" name="user_name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">    
                    <label class="col-md-2 control-label">User Email</label>
                    <div class="col-xs-5">
                        <input type="email" name="user_email" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">License Number</label>
                    <div class="col-xs-5">
                        <input type="text" name="lic_number" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">License Effectivity Date</label>
                    <div class="col-xs-5">
                        <input type="text" name="lic_date" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User Phone Number</label>
                    <div class="col-xs-5">
                        <input type="number" name="user_num" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">    
                    <button type="submit" name="add_user" class="btn btn-primary center-block">Add User</button>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>