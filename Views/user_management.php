<?php
session_start();
require_once('header.php');

if ($_SESSION['is_admin'] === true) {
    require_once('../Models/user_db.php');
    $user_db = new User_Db();
    $all_user = $user_db->getAllUser();
?>
    <div class="container">
        <h1 class="text-center">User management</h1>
        <?php
        if (isset($_GET['msg']) && $_GET['msg'] == "success") {
            echo "<div class='alert alert-danger alert-dismissible'>
            Successfully deleted user
                </div>";
        }
        ?>
        <table class="table table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_user as $key => $value) { ?>
                    <tr>
                        <th scope="row"><?php echo ++$key ?></th>
                        <td><?php echo $value->email ?></td>
                        <td><?php echo $value->status ?></td>
                        <td>
                            <?php
                            if ($value->role == 1) {
                                echo 'admin';
                            } else {
                                echo 'customer';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="../Controllers/delete_user.php?id=<?php echo $value->id ?>" class="btn btn-danger">Del</a>
                            <?php if ($value->status == 'active') {
                                echo '<a href="../Controllers/block_user.php?id=' . $value->id . '" class="btn btn-danger">Block</a>';
                            } else {
                                echo '<a href="../Controllers/unblock_user.php?id=' . $value->id . '" class="btn btn-info">UnBlock</a>';
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo 'Không thể truy cập';
}

require_once('footer.php');
?>