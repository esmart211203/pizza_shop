<?php
include_once('../Models/user_db.php');
$user_db = new User_Db();
$user_id = $_GET['id'] ? $_GET['id'] : '';
$user_db->deleteUserById($user_id);

header("Location: ../Views/user_management.php?msg=success");
exit();
?>