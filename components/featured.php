<?php
require_once __DIR__ . '/../config/db.php';

/*
|--------------------------------------------------------------------------
| FETCH FEATURED ITEMS
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT 
        i.id,
        i.title,
        i.price,
        i.location,
        i.status,
        u.full_name,
        u.phone,
        u.email
    FROM items i
    LEFT JOIN users u ON u.id = i.user_id
    ORDER BY i.created_at DESC
    LIMIT 10
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

<!-- ================= FEATURED SLIDER ================= -->
<section class="py-16 bg-gradient-to-b from-white to-gray-50">

<div class="max-w-7xl mx-auto px-4 md:px-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">

        <div>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight">
                Featured Listings
            </h2>
            <p class="text-gray-500 mt-2">
                Discover top products from trusted sellers
            </p>
        </div>

        <a href="explore.php"
           class="inline-flex items-center justify-center px-6 py-3
                  bg-yellow-500 hover:bg-yellow-600
                  text-black font-semibold rounded-xl shadow-sm
                  transition hover:scale-[1.03]">

            Explore All

        </a>

    </div>

    <!-- ================= SLIDER ================= -->
    <div class="relative">

        <!-- LEFT -->
        <button onclick="scrollSlider(-1)"
            class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 z-10
                   w-11 h-11 bg-white border shadow-md rounded-full
                   items-center justify-center hover:bg-gray-100 transition
                   disabled:opacity-30">

            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>

        </button>

        <!-- RIGHT -->
        <button onclick="scrollSlider(1)"
            class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 z-10
                   w-11 h-11 bg-white border shadow-md rounded-full
                   items-center justify-center hover:bg-gray-100 transition">

            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>

        </button>

        <!-- SCROLL AREA -->
        <div id="slider"
             class="flex gap-5 overflow-x-auto scroll-smooth snap-x snap-mandatory no-scrollbar px-1">

            <?php foreach ($items as $item): ?>

            <?php $imgs = $images[$item['id']] ?? []; ?>

            <div class="min-w-[85%] sm:min-w-[45%] lg:min-w-[32%] xl:min-w-[25%]
                        snap-center bg-white border rounded-2xl overflow-hidden
                        shadow-sm hover:shadow-2xl transition-all duration-300
                        group hover:-translate-y-1">

                <!-- IMAGE -->
                <div class="h-56 bg-gray-100 overflow-hidden relative">

                    <?php if (!empty($imgs)): ?>

                        <img
                            src="data:<?= $imgs[0]['mime_type'] ?>;base64,<?= base64_encode($imgs[0]['image_blob']) ?>"
                            class="w-full h-full object-cover
                                   group-hover:scale-110 transition duration-700"
                        >

                    <?php else: ?>

                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            No Image Available
                        </div>

                    <?php endif; ?>

                    <!-- STATUS BADGE -->
                    <span class="absolute top-3 left-3 text-xs px-3 py-1 rounded-full
                                 bg-white/90 backdrop-blur shadow-sm font-medium">
                        <?= ucfirst($item['status']) ?>
                    </span>

                </div>

                <!-- CONTENT -->
                <div class="p-5">

                    <h3 class="font-semibold text-lg text-gray-900 line-clamp-1">
                        <?= htmlspecialchars($item['title']) ?>
                    </h3>

                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                        📍 <?= htmlspecialchars($item['location']) ?>
                    </p>

                    <div class="mt-3 flex items-center justify-between">
                        <p class="text-xl font-bold text-gray-900">
                            GHS <?= number_format($item['price'], 2) ?>
                        </p>
                    </div>

                    <!-- BUTTON -->
                    <a href="view-item.php?id=<?= $item['id'] ?>"
                       class="mt-4 block text-center relative overflow-hidden
                              bg-gray-900 text-white py-3 rounded-xl font-semibold
                              transition hover:bg-yellow-500 hover:text-black">

                        <span class="relative z-10">View Item</span>

                        <!-- shine effect -->
                        <span class="absolute inset-0 bg-white/10 translate-x-[-100%]
                                     group-hover:translate-x-[100%] transition duration-700"></span>

                    </a>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

</section>