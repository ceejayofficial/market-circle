<?php
$id = $_GET['id'] ?? 1;

/* dummy product */
$product = [
    "title" => "Premium Product $id",
    "price" => rand(120, 5000),
    "location" => "Accra, Ghana",
    "desc" => "High quality product available from verified seller. Limited stock available. Grab it before it's gone!",
    "seller" => "Ceejay Verified Store",
    "phone" => "0550000000"
];
?>

<!DOCTYPE html>
<html lang="en">

<?php include './components/head.php'; ?>

<body class="bg-gray-50 text-gray-800">

<?php include './components/navbar.php'; ?>

<!-- ================= PRODUCT SECTION ================= -->
<section class="max-w-7xl mx-auto px-4 md:px-6 py-10">

    <div class="grid lg:grid-cols-2 gap-10">

        <!-- ================= IMAGE GALLERY ================= -->
        <div class="space-y-4">

            <div class="rounded-2xl overflow-hidden shadow-md bg-white group">
                <img
                    src="https://source.unsplash.com/900x700/?ghana,market,product,<?= $id ?>"
                    class="w-full h-[320px] md:h-[450px] object-cover group-hover:scale-105 transition duration-700"
                >
            </div>

            <div class="grid grid-cols-4 gap-3">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <img
                        src="https://source.unsplash.com/300x300/?market,product,<?= $i ?>"
                        class="h-20 md:h-24 w-full object-cover rounded-xl cursor-pointer hover:scale-105 transition"
                    >
                <?php endfor; ?>
            </div>

        </div>

        <!-- ================= DETAILS ================= -->
        <div class="space-y-6">

            <!-- TITLE + LOCATION -->
            <div>
                <h1 class="text-2xl md:text-3xl font-bold">
                    <?= $product['title'] ?>
                </h1>

                <p class="text-gray-500 mt-2 flex items-center gap-2">

                    <!-- LOCATION SVG -->
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>

                    <?= $product['location'] ?>
                </p>
            </div>

            <!-- PRICE -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border">
                <p class="text-gray-500 text-sm">Price</p>
                <h2 class="text-3xl font-bold text-yellow-500">
                    GHS <?= $product['price'] ?>
                </h2>
            </div>

            <!-- DESCRIPTION -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border">
                <h3 class="font-semibold mb-2">Description</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    <?= $product['desc'] ?>
                </p>
            </div>

            <!-- SELLER -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">Seller</p>
                    <h3 class="font-semibold flex items-center gap-2">

                        <!-- VERIFIED SVG -->
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5 13l4 4L19 7"/>
                        </svg>

                        <?= $product['seller'] ?>
                    </h3>

                    <span class="text-xs text-green-600 font-medium">
                        Verified Seller
                    </span>
                </div>

                <!-- AVATAR -->
                <div class="w-12 h-12 rounded-full bg-gray-200"></div>

            </div>

            <!-- ACTION BUTTONS -->
            <div class="space-y-3">

                <!-- WHATSAPP -->
                <a href="https://wa.me/<?= $product['phone'] ?>"
                   class="flex items-center justify-center gap-2 bg-green-500 text-white py-3 rounded-xl font-semibold hover:bg-green-600 transition shadow-md hover:shadow-xl">

                    <!-- WHATSAPP SVG -->
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.52 3.48A11.86 11.86 0 0012.06 0C5.5 0 .15 5.35.15 11.92c0 2.09.55 4.14 1.6 5.94L0 24l6.29-1.65a11.9 11.9 0 005.77 1.47h.01c6.56 0 11.9-5.35 11.9-11.92 0-3.18-1.24-6.16-3.45-8.42z"/>
                    </svg>

                    Chat on WhatsApp
                </a>

                <!-- CALL -->
                <a href="tel:<?= $product['phone'] ?>"
                   class="flex items-center justify-center gap-2 bg-gray-900 text-white py-3 rounded-xl font-semibold hover:bg-black transition">

                    <!-- PHONE SVG -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 5h2l3 7-3 7H3a1 1 0 01-1-1V6a1 1 0 011-1z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13 5h8a1 1 0 011 1v12a1 1 0 01-1 1h-8"/>
                    </svg>

                    Call Seller
                </a>

                <!-- BACK -->
                <a href="javascript:history.back()"
                   class="flex items-center justify-center gap-2 bg-yellow-500 text-black py-3 rounded-xl font-semibold hover:bg-yellow-600 transition">

                    <!-- ARROW SVG -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 19l-7-7 7-7"/>
                    </svg>

                    Back to Listings
                </a>

            </div>

        </div>

    </div>

</section>

<!-- ================= RELATED ================= -->
<section class="max-w-7xl mx-auto px-4 md:px-6 py-10">

    <h2 class="text-xl font-bold mb-6">Related Products</h2>

    <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">

        <?php for ($i = 1; $i <= 4; $i++): ?>

        <a href="product.php?id=<?= $i ?>"
           class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition group">

            <img
                src="https://source.unsplash.com/500x400/?ghana,market,product,<?= $i ?>"
                class="w-full h-40 object-cover group-hover:scale-110 transition duration-700"
            >

            <div class="p-4">
                <h3 class="font-semibold">Related Product <?= $i ?></h3>
                <p class="text-yellow-500 font-bold mt-1">
                    GHS <?= rand(100, 4000) ?>
                </p>
            </div>

        </a>

        <?php endfor; ?>

    </div>

</section>

<?php include './components/footer.php'; ?>

</body>
</html>