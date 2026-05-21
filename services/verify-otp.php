<?php
session_start();

require_once __DIR__ . '/../config/db.php';

/*
|--------------------------------------------------------------------------
| CHECK OTP INPUT
|--------------------------------------------------------------------------
*/
$enteredOtp = $_POST['otp'] ?? '';

if (empty($enteredOtp)) {
    $_SESSION['error'] = "OTP is required";
    header("Location: ../verify.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| CHECK SESSION OTP
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['otp']) || !isset($_SESSION['pending_user'])) {
    $_SESSION['error'] = "OTP expired. Please register again.";
    header("Location: ../signup.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| INVALID OTP
|--------------------------------------------------------------------------
*/
if ($enteredOtp != $_SESSION['otp']) {
    $_SESSION['error'] = "Invalid verification code";
    header("Location: ../verify.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| GET USER DATA
|--------------------------------------------------------------------------
*/
$user = $_SESSION['pending_user'];

/*
|--------------------------------------------------------------------------
| CHECK EXISTING USER
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$user['email']]);

if ($stmt->rowCount() > 0) {
    $_SESSION['error'] = "Account already exists";
    header("Location: ./signup.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| INSERT USER
|--------------------------------------------------------------------------
*/
try {

    $stmt = $pdo->prepare("
        INSERT INTO users 
        (full_name, email, phone, gender, location, gps_address, ghana_card, password)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $user['full_name'],
        $user['email'],
        $user['phone'],
        $user['gender'],
        $user['location'],
        $user['gps_address'],
        $user['ghana_card'],
        $user['password']
    ]);

    unset($_SESSION['otp']);
    unset($_SESSION['pending_user']);

    $_SESSION['success'] = "Account verified successfully";
    header("Location: ../login.php");
    exit;

} catch (Exception $e) {

    $_SESSION['error'] = "Something went wrong. Try again.";
    header("Location: ../verify.php");
    exit;
}