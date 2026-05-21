<?php
$cat = $_GET['cat'] ?? 'all';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

/* dummy data */
$allProducts = [];
for ($i = 1; $i <= 100; $i++) {
    $allProducts[] = [
        "title" => "Product $i",
        "price" => rand(100, 5000),
        "location" => "Accra, Ghana"
    ];
}

$totalPages = ceil(count($allProducts) / $limit);
$products = array_slice($allProducts, $offset, $limit);
?>

<?php include './components/head.php'; ?>
<?php include './components/preloader.php'; ?>
<?php include './components/navbar.php'; ?>

<body class="bg-white">

<!-- HEADER -->
<div class="max-w-7xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold">
        <?= ucfirst($cat) ?> Listings
    </h1>

    <p class="text-gray-500 mt-2">
        Browse all <?= $cat ?> products
    </p>

    <!-- GRID (YOUR STYLE KEPT) -->
    <div class="grid md:grid-cols-4 gap-6 mt-10">

        <?php foreach ($products as $i => $p): ?>

        <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition overflow-hidden">

            <div class="h-40 bg-gray-200 animate-pulse"></div>

            <div class="p-4">
                <h3 class="font-semibold"><?= $p['title'] ?></h3>
                <p class="text-gray-500 text-sm"><?= $p['location'] ?></p>
                <p class="font-bold mt-2">GHS <?= $p['price'] ?></p>
            </div>

        </div>

        <?php endforeach; ?>

    </div>
<!-- PAGINATION -->
<div class="mt-10 flex justify-center px-4">

    <!-- SCROLL WRAPPER (KEY FIX) -->
    <div class="w-full md:w-auto overflow-x-auto">

        <div class="flex items-center gap-2 min-w-max bg-white p-2 rounded-xl border shadow-sm">

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                <a href="?cat=<?= $cat ?>&page=<?= $i ?>"
                   class="flex-shrink-0 px-4 py-2 rounded-lg border transition whitespace-nowrap
                   <?= $i == $page ? 'bg-yellow-500 text-black' : 'hover:bg-gray-100 text-gray-700' ?>">
                    <?= $i ?>
                </a>

            <?php endfor; ?>

        </div>

    </div>

</div>

</div>

<?php include './components/cta.php'; ?>
<?php include './components/footer.php'; ?>
<?php include './components/floating-back.php'; ?>



</body>