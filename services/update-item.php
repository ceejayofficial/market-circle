<?php
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$userId = $_SESSION['user_id'];

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Invalid item ID"]);
    exit;
}

try {

    $pdo->beginTransaction();

    /*
    |------------------------------------------
    | UPDATE ITEM
    |------------------------------------------
    */
    $stmt = $pdo->prepare("
        UPDATE items 
        SET title = ?, price = ?, category = ?, location = ?, description = ?
        WHERE id = ? AND user_id = ?
    ");

    $stmt->execute([
        $_POST['title'],
        $_POST['price'],
        $_POST['category'],
        $_POST['location'],
        $_POST['description'],
        $id,
        $userId
    ]);

    /*
    |------------------------------------------
    | UPDATE IMAGE (IF UPLOADED)
    |------------------------------------------
    */
    if (!empty($_FILES['image']['tmp_name'])) {

        $image = file_get_contents($_FILES['image']['tmp_name']);
        $mime = $_FILES['image']['type'];

        // check if image exists
        $check = $pdo->prepare("SELECT id FROM item_images WHERE item_id = ?");
        $check->execute([$id]);
        $exists = $check->fetchColumn();

        if ($exists) {

            $updateImg = $pdo->prepare("
                UPDATE item_images 
                SET image_blob = ?, mime_type = ?
                WHERE item_id = ?
            ");

            $updateImg->execute([$image, $mime, $id]);

        } else {

            $insertImg = $pdo->prepare("
                INSERT INTO item_images (item_id, image_blob, mime_type)
                VALUES (?, ?, ?)
            ");

            $insertImg->execute([$id, $image, $mime]);
        }
    }

    $pdo->commit();

    echo json_encode([
        "status" => "success",
        "message" => "Item updated successfully"
    ]);

} catch (Exception $e) {

    $pdo->rollBack();

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}