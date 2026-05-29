<?php
require_once __DIR__ . '/../config/db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| VALIDATE ID
|--------------------------------------------------------------------------
*/
$itemId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($itemId <= 0) {
    echo "<div class='p-6 text-red-500'>Invalid item ID</div>";
    exit;
}

/*
|--------------------------------------------------------------------------
| FETCH ITEM + OWNER
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT 
        items.*,
        users.full_name,
        users.phone,
        users.email
    FROM items
    JOIN users ON users.id = items.user_id
    WHERE items.id = ?
    LIMIT 1
");

$stmt->execute([$itemId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "<div class='p-6 text-red-500'>Item not found</div>";
    exit;
}

/*
|--------------------------------------------------------------------------
| FETCH FIRST IMAGE (BLOB)
|--------------------------------------------------------------------------
*/
$stmtImg = $pdo->prepare("
    SELECT image_blob, mime_type
    FROM item_images
    WHERE item_id = ?
    LIMIT 1
");

$stmtImg->execute([$itemId]);
$image = $stmtImg->fetch(PDO::FETCH_ASSOC);
?>

<div class="max-w-6xl mx-auto p-4 md:p-8 animate-fadeInUp">

    <!-- BACK BUTTON -->
    <a href="index.php?page=my-items"
       class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-6">

        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 19l-7-7 7-7"/>
        </svg>

        Back to Listings
    </a>

    <!-- MAIN CARD -->
    <div class="grid md:grid-cols-2 gap-8 bg-white rounded-3xl shadow-sm border overflow-hidden">

        <!-- IMAGE -->
        <div class="bg-gray-100 h-96 md:h-full">

            <?php if ($image): ?>

                <img
                    src="data:<?= htmlspecialchars($image['mime_type']) ?>;base64,<?= base64_encode($image['image_blob']) ?>"
                    class="w-full h-full object-cover"
                >

            <?php else: ?>

                <div class="flex items-center justify-center h-full text-gray-400">
                    No image available
                </div>

            <?php endif; ?>

        </div>

        <!-- DETAILS -->
        <div class="p-6 md:p-10">

            <!-- TITLE -->
            <h1 class="text-3xl font-bold text-gray-900">
                <?= htmlspecialchars($item['title']) ?>
            </h1>

            <!-- STATUS -->
            <div class="mt-3">
                <span class="px-3 py-1 text-xs rounded-full font-semibold
                    <?= $item['status'] === 'approved'
                        ? 'bg-green-500 text-white'
                        : 'bg-yellow-500 text-black'
                    ?>">
                    <?= ucfirst($item['status']) ?>
                </span>
            </div>

            <!-- PRICE -->
            <div class="mt-6">
                <p class="text-3xl font-bold text-gray-900">
                    GHS <?= number_format($item['price'], 2) ?>
                </p>
            </div>

            <!-- DESCRIPTION -->
            <div class="mt-6 text-gray-600 leading-relaxed">
                <?= nl2br(htmlspecialchars($item['description'])) ?>
            </div>

            <!-- META -->
            <div class="mt-6 space-y-2 text-sm text-gray-600">

                <div class="flex items-center gap-2">
                    📍 <?= htmlspecialchars($item['location']) ?>
                </div>

                <div class="flex items-center gap-2">
                    🏷 <?= htmlspecialchars($item['category']) ?>
                </div>

                <div class="flex items-center gap-2">
                    📅 <?= $item['created_at'] ?>
                </div>

            </div>

            <!-- SELLER CARD -->
            <div class="mt-8 p-4 rounded-2xl bg-gray-50 border">

                <h3 class="font-semibold text-gray-900 mb-2">
                    Seller Info
                </h3>

                <p class="text-sm text-gray-700">
                    <?= htmlspecialchars($item['full_name']) ?>
                </p>

                <p class="text-sm text-gray-500">
                    <?= htmlspecialchars($item['phone']) ?>
                </p>

                <p class="text-sm text-gray-500">
                    <?= htmlspecialchars($item['email']) ?>
                </p>

            </div>

            <!-- ACTION BUTTONS -->
            <div class="mt-8 flex gap-3">

                <button
                    class="flex-1 py-3 rounded-2xl bg-yellow-500 hover:bg-yellow-600
                           text-black font-semibold transition">

                    Contact Seller

                </button>

                <button
                    class="flex-1 py-3 rounded-2xl border hover:bg-gray-100
                           font-semibold transition">

                    Save Item

                </button>

            </div>

        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeInUp {
    animation: fadeInUp .5s ease;
}
</style>