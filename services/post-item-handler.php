<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Please login first"
    ]);
    exit;
}

$title = trim($_POST['title'] ?? '');
$price = trim($_POST['price'] ?? '');
$category = trim($_POST['category'] ?? '');
$description = trim($_POST['description'] ?? '');
$location = trim($_POST['location'] ?? '');

if (!$title || !$price || !$category || !$description) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required"
    ]);
    exit;
}

if (!is_numeric($price) || $price <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid price"
    ]);
    exit;
}

try {

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO items (user_id, title, price, category, description, location)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        $title,
        $price,
        $category,
        $description,
        $location
    ]);

    $itemId = $pdo->lastInsertId();

    /*
    |-----------------------------
    | IMAGE VALIDATION (500KB)
    |-----------------------------
    */
    $allowed = ['image/jpeg','image/png','image/webp'];
    $maxSize = 500 * 1024;

    if (!empty($_FILES['images']['name'][0])) {

        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {

            $tmp = $_FILES['images']['tmp_name'][$i];
            $size = $_FILES['images']['size'][$i];
            $type = mime_content_type($tmp);

            if (!in_array($type, $allowed)) {
                throw new Exception("Invalid image type");
            }

            if ($size > $maxSize) {
                throw new Exception("Each image must be under 500KB");
            }

            $blob = file_get_contents($tmp);

            $img = $pdo->prepare("
                INSERT INTO item_images (item_id, image_blob, mime_type)
                VALUES (?, ?, ?)
            ");

            $img->bindParam(1, $itemId);
            $img->bindParam(2, $blob, PDO::PARAM_LOB);
            $img->bindParam(3, $type);
            $img->execute();
        }
    }

    $pdo->commit();

    echo json_encode([
        "status" => "success",
        "message" => "Item posted successfully"
    ]);

} catch (Exception $e) {

    $pdo->rollBack();

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}