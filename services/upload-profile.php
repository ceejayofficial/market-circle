<?php
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$userId = $_SESSION['user_id'];

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
    echo json_encode(["status" => "error", "message" => "No image uploaded"]);
    exit;
}

/*
|-------------------------------------------------
| VALIDATION (SIZE + TYPE)
|-------------------------------------------------
*/
$maxSize = 500 * 1024; // 500KB

if ($_FILES['image']['size'] > $maxSize) {
    echo json_encode(["status" => "error", "message" => "Image must be under 500KB"]);
    exit;
}

$allowed = ['image/jpeg', 'image/png', 'image/webp'];
$mime = mime_content_type($_FILES['image']['tmp_name']);

if (!in_array($mime, $allowed)) {
    echo json_encode(["status" => "error", "message" => "Invalid image type"]);
    exit;
}

$imageData = file_get_contents($_FILES['image']['tmp_name']);

try {

    /*
    |-----------------------------------------
    | DELETE OLD IMAGE (ONE PROFILE IMAGE)
    |-----------------------------------------
    */
    $pdo->prepare("DELETE FROM user_images WHERE user_id = ?")
        ->execute([$userId]);

    /*
    |-----------------------------------------
    | INSERT NEW IMAGE
    |-----------------------------------------
    */
    $stmt = $pdo->prepare("
        INSERT INTO user_images (user_id, image_blob, mime_type)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([$userId, $imageData, $mime]);

    echo json_encode([
        "status" => "success",
        "message" => "Profile image updated"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => "Upload failed"
    ]);
}