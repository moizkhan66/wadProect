<?php include "templates/header.php"; ?>
<?php 
    include_once 'config/connection.php';

    if($_SESSION['userType'] != 'admin')
        header("Location: index.php");
        
    $database = new Connection();
    $db = $database->openConnection();

    $sql = 'SELECT `user_id`, `user_name`, `user_type`, `user_status` FROM `user_tb` ORDER BY `user_id`';
 
    $users = $db->query($sql);
    $users->setFetchMode(PDO::FETCH_ASSOC);
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Admin Users</li>
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
        <div class="panel-heading">Users
            <a href="admin_addUser.php"><button type="button" class="btn btn-lg btn-primary pull-right">Add User</button></a>
        </div>
        <div class="panel-body btn-margins">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>User Type</th>
                            <th>User Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $users->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['user_id']) ?></td>
                            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_status']); ?></td>
                            <td>
                                <a href="admin_user.php?user=<?php echo htmlspecialchars($row['user_id']) ?>"><button type="button" class="btn btn-sm btn-primary">view</button></a>
                                <a href="admin_editUser.php?user=<?php echo htmlspecialchars($row['user_id']) ?>"><button type="button" class="btn btn-sm btn-warning">Edit</button></a>
                                <a href="admin_delUser.php?user=<?php echo htmlspecialchars($row['user_id']) ?>"><button type="button" class="btn btn-sm btn-danger">Delete</button></a>
                            </td>
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