<?php
require_once __DIR__ . '/config/db.php';

session_start();

$itemId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($itemId <= 0) {
    die("<div style='padding:20px;color:red;'>Invalid item ID</div>");
}

/*
|--------------------------------------------------------------------------
| FETCH ITEM
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT 
        i.*,
        u.full_name,
        u.email,
        u.phone,
        u.location
    FROM items i
    LEFT JOIN users u ON u.id = i.user_id
    WHERE i.id = ?
    LIMIT 1
");

$stmt->execute([$itemId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("<div style='padding:20px;color:red;'>Item not found</div>");
}

/*
|--------------------------------------------------------------------------
| FETCH IMAGES
|--------------------------------------------------------------------------
*/
$stmtImg = $pdo->prepare("
    SELECT image_blob, mime_type
    FROM item_images
    WHERE item_id = ?
");

$stmtImg->execute([$itemId]);
$images = $stmtImg->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($item['title']) ?> - MarketCircle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-6xl mx-auto p-4 md:p-10">

    <a href="index.php"
       class="text-sm text-gray-600 hover:text-black">
        ← Back to Home
    </a>

    <div class="grid md:grid-cols-2 gap-8 mt-6">

        <!-- ================= IMAGES ================= -->
        <div class="bg-white rounded-3xl border shadow-sm overflow-hidden">

            <div id="slider"
                 class="flex overflow-x-auto scroll-smooth snap-x snap-mandatory">

                <?php if (count($images) > 0): ?>

                    <?php foreach ($images as $img): ?>

                        <img
                            src="data:<?= $img['mime_type'] ?>;base64,<?= base64_encode($img['image_blob']) ?>"
                            class="w-full h-[420px] object-cover flex-shrink-0 snap-center"
                        >

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="w-full h-[420px] flex items-center justify-center text-gray-400">
                        No Images Available
                    </div>

                <?php endif; ?>

            </div>

        </div>

        <!-- ================= DETAILS ================= -->
        <div class="bg-white rounded-3xl border shadow-sm p-6">

            <h1 class="text-3xl font-bold text-gray-900">
                <?= htmlspecialchars($item['title']) ?>
            </h1>

            <p class="text-gray-500 mt-2">
                <?= htmlspecialchars($item['location']) ?>
            </p>

            <div class="text-3xl font-bold text-yellow-600 mt-4">
                GHS <?= number_format($item['price'], 2) ?>
            </div>

            <span class="inline-block mt-3 px-3 py-1 bg-gray-100 rounded-full text-sm">
                <?= ucfirst($item['status']) ?>
            </span>

            <!-- DESCRIPTION -->
            <div class="mt-6">
                <h3 class="font-semibold">Description</h3>
                <p class="text-gray-600 mt-2">
                    <?= nl2br(htmlspecialchars($item['description'])) ?>
                </p>
            </div>

            <!-- SELLER -->
            <div class="mt-6 border-t pt-6 text-sm text-gray-700 space-y-1">

                <p><b>Seller:</b> <?= htmlspecialchars($item['full_name']) ?></p>
                <p><b>Phone:</b> <?= htmlspecialchars($item['phone']) ?></p>
                <p><b>Email:</b> <?= htmlspecialchars($item['email']) ?></p>

            </div>

            <!-- CONTACT -->
            <div class="mt-6 flex gap-3">

                <a href="tel:<?= $item['phone'] ?>"
                   class="flex-1 text-center bg-green-500 text-white py-3 rounded-xl font-semibold">

                    Call

                </a>

                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $item['phone']) ?>"
                   target="_blank"
                   class="flex-1 text-center bg-yellow-500 text-black py-3 rounded-xl font-semibold">

                    WhatsApp

                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>