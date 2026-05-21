<?php

require_once __DIR__ . '/../config/mailer.php';

function generateOTP()
{
    return rand(100000, 999999);
}

function storeOTP($userData, $otp)
{
    $_SESSION['otp'] = $otp;
    $_SESSION['pending_user'] = $userData;
}

function sendOTP($email, $otp)
{
    return sendOTPEmail($email, $otp);
}