<?php
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = array();
}
unset($_SESSION['user']);

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    $_SESSION['is_admin'] = false;
}
header("Location: ../Views/login.php");
exit();
?>