<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'admin')
        header("Location: index.php");
        
    $database = new Connection();
    $db = $database->openConnection();

    if(isset($_GET['user']))
    {
        $user_id = $_GET['user'];        

        $sql = 'SELECT `user_name`, `user_email`, `user_username`, `license_id`, `license_ed`, `user_status`, `user_contact` 
                FROM `user_tb` WHERE `user_id` = ' . $user_id;

        $users = $db->query($sql);
        $users->setFetchMode(PDO::FETCH_ASSOC);
        $row = $users->fetch();
    }
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Admin User Profile</li>
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
        <div class="panel-heading clearfix">User Profile</div>
        <div class="panel-body">
            <div class="form-horizontal row-border">
                <div class="form-group">
                    <label class="col-md-2 control-label">User Name</label>
                    <div class="col-xs-5">
                        <input readonly type="text" name="user_name" value="<?php echo $row['user_name'];?>"
                            class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User Email</label>
                    <div class="col-xs-5">
                        <input readonly type="email" name="user_email" class="form-control"
                            value="<?php echo $row['user_email'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User Contact</label>
                    <div class="col-xs-5">
                        <input readonly type="number" name="user_contact" class="form-control"
                            value="<?php echo $row['user_contact'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">License Number</label>
                    <div class="col-xs-5">
                        <input readonly type="text" name="lic_number" class="form-control"
                            value="<?php echo $row['license_id'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">License Effectivity Date</label>
                    <div class="col-xs-5">
                        <input readonly type="text" name="lic_date" class="form-control"
                            value="<?php echo $row['license_ed'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User Status</label>
                    <div class="col-xs-5">
                        <input readonly type="text" name="user_status" class="form-control"
                            value="<?php echo $row['user_status'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">User UserName</label>
                    <div class="col-xs-5">
                        <input readonly type="text" name="user_username" class="form-control"
                            value="<?php echo $row['user_username'];?>">
                    </div>
                </div>


                <div class="form-group">
                    <a href="admin_editUser.php?user=<?php echo $user_id;?>"><button
                            class="btn btn-primary center-block">Edit User</button></a>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<?php include "templates/footer.php"; ?>