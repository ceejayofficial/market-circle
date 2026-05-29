<?php
require_once __DIR__ . '/../config/db.php';

/*
|--------------------------------------------------------------------------
| FETCH ITEMS
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT 
        i.id,
        i.title,
        i.price,
        i.location,
        i.status,
        i.created_at,
        u.full_name,
        u.phone,
        u.email
    FROM items i
    LEFT JOIN users u ON u.id = i.user_id
    ORDER BY i.created_at DESC
    LIMIT 30
");

$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| FETCH IMAGES
|--------------------------------------------------------------------------
*/
$stmtImg = $pdo->prepare("
    SELECT item_id, image_blob, mime_type
    FROM item_images
");

$stmtImg->execute();
$imagesRaw = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

$images = [];

foreach ($imagesRaw as $img) {
    $images[$img['item_id']][] = $img;
}
?>

<!-- ================= EXPLORE PAGE ================= -->
<section class="py-16 bg-gray-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 md:px-6">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">

            <div>
                <h1 class="text-4xl font-bold tracking-tight">
                    Explore Marketplace
                </h1>
                <p class="text-gray-500 mt-2">
                    Discover products from verified sellers across Ghana
                </p>
            </div>

            <!-- BACK BUTTON -->
            <a href="index.php"
               class="px-5 py-3 bg-gray-900 hover:bg-yellow-500 hover:text-black text-white rounded-xl font-semibold transition">

                Back Home

            </a>

        </div>

        <!-- ================= GRID ================= -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <?php foreach ($items as $item): ?>

            <?php $imgs = $images[$item['id']] ?? []; ?>

            <div class="bg-white rounded-2xl border shadow-sm hover:shadow-xl transition group overflow-hidden">

                <!-- IMAGE -->
                <div class="h-56 bg-gray-100 overflow-hidden relative">

                    <?php if (!empty($imgs)): ?>

                        <img
                            src="data:<?= $imgs[0]['mime_type'] ?>;base64,<?= base64_encode($imgs[0]['image_blob']) ?>"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                        >

                    <?php else: ?>

                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            No Image
                        </div>

                    <?php endif; ?>

                    <!-- STATUS -->
                    <span class="absolute top-3 left-3 text-xs px-3 py-1 rounded-full bg-white shadow">
                        <?= ucfirst($item['status']) ?>
                    </span>

                </div>

                <!-- CONTENT -->
                <div class="p-5">

                    <h3 class="font-semibold text-lg text-gray-900">
                        <?= htmlspecialchars($item['title']) ?>
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        <?= htmlspecialchars($item['location']) ?>
                    </p>

                    <div class="mt-3 flex justify-between items-center">
                        <p class="text-xl font-bold text-gray-900">
                            GHS <?= number_format($item['price'], 2) ?>
                        </p>
                    </div>

                    <!-- ACTION -->
                    <a href="view-item.php?id=<?= $item['id'] ?>"
                       class="mt-4 block text-center bg-gray-900 hover:bg-yellow-500
                              hover:text-black text-white py-3 rounded-xl font-semibold transition">

                        View Item

                    </a>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

    </div>
</section>