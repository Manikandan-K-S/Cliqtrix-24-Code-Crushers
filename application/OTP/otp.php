<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendMail($to,$otp){
$mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2;                     
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';     
        $mail->SMTPAuth   = true;
        $mail->Username   = 'virtushop.verify@gmail.com';    
        $mail->Password   = 'qlsahcdsjxwiobkk'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port       = 587;                   

        $mail->setFrom('virtushop.verify@gmail.com', 'virtushop'); 
        $mail->addAddress($to); 

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body    = "This is your OTP to verify your mail : <b>$otp</b> <br><br>Thankyou for reaching us.<br>regards,<br>VirtuShop Team";
        $mail->AltBody = "This is your OTP to verify your mail : $otp . Thank you for reaching us.";

        $mail->send();
        
        return true;

    } catch (Exception $e) {

        return false;
    }
}


?>


