<?php
session_start();
include_once('../Models/user_db.php');
$user_db = new User_Db();
$user_email = $_SESSION['user'];
$full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$user_db->checkout($user_email,$full_name,$address,$phone);
//sendmail
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 2;
    $mail->isSMTP(); // Sử dụng SMTP để gửi mail
    $mail->Host = 'smtp.gmail.com'; // Server SMTP của gmail
    $mail->SMTPAuth = true; // Bật xác thực SMTP
    $mail->Username = 'esmart211203@gmail.com'; // Tài khoản email
    $mail->Password = 'ditwqsddnaejpjka'; // Mật khẩu ứng dụng ở bước 1 hoặc mật khẩu email
    $mail->SMTPSecure = 'ssl'; // Mã hóa SSL
    $mail->Port = 465; // Cổng kết nối SMTP là 465
    
    //Recipients
    $mail->setFrom('esmart211203@gmail.com', 'Jonsey Pizza'); // Địa chỉ email và tên người gửi
    $mail->addAddress($user_email, 'Jonsey Pizza'); // Địa chỉ mail và tên người nhận
    
    //Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Order Success'; // Tiêu đề
    $mail->Body = 'Your order has been placed successfully'; // Nội dung
    
    $mail->send();
   // echo 'Message has been sent';
    } catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;}
header("Location: ../Views/my_cart.php");
exit();