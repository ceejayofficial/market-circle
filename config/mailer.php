<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function sendOTPEmail($email, $otp)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        //  IMPORTANT: USE REAL CREDENTIALS
        $mail->Username = 'ekumkofi@gmail.com';
        $mail->Password = 'ystqgcwycvrqhgub';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('ekumkofi@gmail.com', 'MarketCircle');
        $mail->addAddress($email);

        $mail->Subject = "Your Verification Code";
        $mail->Body = "Your OTP code is: $otp";

        return $mail->send();

    } catch (Exception $e) {
        return false;
    }
}