<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);

$user = $stmt->fetch();

if (!$user) {
    $_SESSION['error'] = "Invalid email or password";
    header("Location:. ../login.php");
    exit;
}

if (!password_verify($password, $user['password'])) {
    $_SESSION['error'] = "Invalid email or password";
    header("Location: ../login.php");
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'];

header("Location: ../dashboard/index.php");
exit;