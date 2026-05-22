<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/mailer.php';

/*
|--------------------------------------------------------------------------
| GENERATE OTP
|--------------------------------------------------------------------------
*/
function generateOTP()
{
    return rand(100000, 999999);
}

/*
|--------------------------------------------------------------------------
| STORE OTP IN DATABASE
|--------------------------------------------------------------------------
*/
function storeOTP($email, $otp)
{
    global $pdo;

    // OTP expires in 5 minutes
    $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

    /*
    |--------------------------------------------------------------------------
    | DELETE OLD OTPs FOR SAME EMAIL
    |--------------------------------------------------------------------------
    */
    $delete = $pdo->prepare("
        DELETE FROM user_otps
        WHERE email = ?
    ");

    $delete->execute([$email]);

    /*
    |--------------------------------------------------------------------------
    | INSERT NEW OTP
    |--------------------------------------------------------------------------
    */
    $stmt = $pdo->prepare("
        INSERT INTO user_otps (email, otp, expires_at)
        VALUES (?, ?, ?)
    ");

    return $stmt->execute([
        $email,
        $otp,
        $expires
    ]);
}

/*
|--------------------------------------------------------------------------
| SEND OTP EMAIL
|--------------------------------------------------------------------------
*/
function sendOTP($email, $otp)
{
    return sendOTPEmail($email, $otp);
}