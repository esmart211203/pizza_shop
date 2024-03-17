<?php

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
    $mail->setFrom('esmart211203@gmail.com', 'Mailer'); // Địa chỉ email và tên người gửi
    $mail->addAddress('21211tt2122@mail.tdc.edu.vn', 'Xuan Trong'); // Địa chỉ mail và tên người nhận
    
    //Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Here is the subject'; // Tiêu đề
    $mail->Body = 'This is the HTML message body in bold!'; // Nội dung
    
    $mail->send();
    echo 'Message has been sent';
    } catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;}