<?php
session_start();

require_once __DIR__ . '/../config/db.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

/*
|--------------------------------------------------------------------------
| VALIDATION
|--------------------------------------------------------------------------
*/
if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Email and password are required";
    header("Location: ../login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| FETCH USER
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| INVALID USER
|--------------------------------------------------------------------------
*/
if (!$user) {
    $_SESSION['error'] = "Invalid email or password";
    header("Location: ../login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| VERIFY PASSWORD
|--------------------------------------------------------------------------
*/
if (!password_verify($password, $user['password'])) {
    $_SESSION['error'] = "Invalid email or password";
    header("Location: ../login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| SECURITY: REGENERATE SESSION
|--------------------------------------------------------------------------
*/
session_regenerate_id(true);

/*
|--------------------------------------------------------------------------
| STORE SESSION
|--------------------------------------------------------------------------
*/
$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'] ?? 'user';
$_SESSION['user_name'] = $user['full_name'];
$_SESSION['user_email'] = $user['email'];

/*
|--------------------------------------------------------------------------
| SUCCESS REDIRECT
|--------------------------------------------------------------------------
*/
header("Location: ../dashboard/index.php");
exit;