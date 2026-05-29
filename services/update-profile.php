<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../config/db.php';

/*
|--------------------------------------------------------------------------
| AUTH CHECK
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access"
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| INPUTS
|--------------------------------------------------------------------------
*/
$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');
$location  = trim($_POST['location'] ?? '');

/*
|--------------------------------------------------------------------------
| VALIDATION
|--------------------------------------------------------------------------
*/
if ($full_name === '' || $email === '') {
    echo json_encode([
        "status" => "error",
        "message" => "Full name and email are required"
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email format"
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| DUPLICATE EMAIL CHECK
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
$stmt->execute([$email, $userId]);

if ($stmt->fetch()) {
    echo json_encode([
        "status" => "error",
        "message" => "Email already in use"
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| UPDATE USER
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    UPDATE users 
    SET full_name = ?,
        email = ?,
        phone = ?,
        location = ?
    WHERE id = ?
");

$ok = $stmt->execute([
    $full_name,
    $email,
    $phone,
    $location,
    $userId
]);

if ($ok) {

    echo json_encode([
        "status" => "success",
        "message" => "Profile updated successfully"
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Update failed"
    ]);
}