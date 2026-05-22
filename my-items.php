<?php
session_start();
require_once __DIR__ . '/config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| FETCH ITEMS
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT * FROM items 
    WHERE user_id = ?
    ORDER BY id DESC
");

$stmt->execute([$_SESSION['user_id']]);
$items = $stmt->fetchAll();
?>

<?php include './components/head.php'; ?>
<?php include './components/navbar.php'; ?>

<body class="bg-gradient-to-b from-gray-50 to-white text-gray-800">

<div class="max-w-7xl mx-auto px-4 md:px-6 py-10">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                My Listings
            </h1>
            <p class="text-gray-500 mt-1">
                Manage, edit and track your posted items
            </p>
        </div>

        <a href="post-item.php"
           class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-black font-semibold shadow-sm transition">
            + Post Item
        </a>

    </div>

    <!-- GRID -->
    <div class="mt-10">

        <?php if (count($items) === 0): ?>

            <div class="text-center py-20 bg-white rounded-2xl border shadow-sm">

                <h3 class="text-xl font-semibold">No items yet</h3>
                <p class="text-gray-500 mt-2">Start selling by posting your first item</p>

            </div>

        <?php else: ?>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                <?php foreach ($items as $item): ?>

                    <?php
                    /*
                    |--------------------------------------------------------------------------
                    | FETCH FIRST IMAGE (BLOB)
                    |--------------------------------------------------------------------------
                    */
                    $imgStmt = $pdo->prepare("
                        SELECT image_blob, mime_type 
                        FROM item_images 
                        WHERE item_id = ? 
                        LIMIT 1
                    ");
                    $imgStmt->execute([$item['id']]);
                    $img = $imgStmt->fetch();

                    $imgSrc = null;

                    if ($img) {
                        $imgSrc = "data:" . $img['mime_type'] . ";base64," . base64_encode($img['image_blob']);
                    }
                    ?>

                    <!-- CARD -->
                    <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 hover:-translate-y-1">

                        <!-- IMAGE -->
                        <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 relative overflow-hidden">

                            <?php if ($imgSrc): ?>
                                <img src="<?= $imgSrc ?>"
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                     alt="item">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159M15.75 12l2.227-2.227a2.25 2.25 0 013.182 0L21.75 12"/>
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <!-- PRICE TAG -->
                            <div class="absolute top-3 left-3">
                                <span class="bg-black/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur">
                                    GHS <?= number_format($item['price']) ?>
                                </span>
                            </div>

                        </div>

                        <!-- CONTENT -->
                        <div class="p-5">

                            <h3 class="font-semibold text-gray-900 truncate group-hover:text-yellow-600 transition">
                                <?= htmlspecialchars($item['title']) ?>
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                <?= htmlspecialchars($item['location']) ?>
                            </p>

                            <!-- ACTIONS -->
                            <div class="mt-5 flex gap-2">

                                <!-- VIEW BUTTON -->
                                <a href="product.php?id=<?= $item['id'] ?>"
                                   class="flex-1 text-center py-2.5 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-yellow-500 hover:text-black transition-all duration-300 shadow-sm">
                                    View
                                </a>

                                <!-- EDIT BUTTON -->
                                <a href="edit-item.php?id=<?= $item['id'] ?>"
                                   class="flex-1 text-center py-2.5 rounded-xl bg-yellow-500 text-black text-sm font-medium hover:bg-yellow-600 transition shadow-sm">
                                    Edit
                                </a>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php include './components/footer.php'; ?>

</body>
</html>