<?php
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/otp-service.php';

/*
|--------------------------------------------------------------------------
| INPUTS
|--------------------------------------------------------------------------
*/
$user = [
    "full_name" => $_POST['full_name'],
    "email" => $_POST['email'],
    "phone" => $_POST['phone'],
    "gender" => $_POST['gender'],
    "location" => $_POST['location'],
    "gps_address" => $_POST['gps_address'],
    "ghana_card" => $_POST['ghana_card'],
    "password" => password_hash($_POST['password'], PASSWORD_BCRYPT)
];

/*
|--------------------------------------------------------------------------
| CHECK DUPLICATE EMAIL OR PHONE
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
$stmt->execute([$user['email'], $user['phone']]);

if ($stmt->rowCount() > 0) {

    $_SESSION['error'] = "Email or phone number already exists";
    header("Location: ../signup.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| GENERATE OTP
|--------------------------------------------------------------------------
*/
$otp = generateOTP();
storeOTP($user, $otp);

/*
|--------------------------------------------------------------------------
| SEND OTP
|--------------------------------------------------------------------------
*/
if (sendOTP($user['email'], $otp)) {

    // store temp user for verification
    $_SESSION['pending_user'] = $user;
    $_SESSION['otp'] = $otp;

    header("Location: ./verify-otp.php");
    exit;

} else {

    $_SESSION['error'] = "Email failed to send OTP";
    header("Location: ../signup.php");
    exit;
}