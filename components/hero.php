<!-- ================= HERO SECTION ================= -->
<section class="relative overflow-hidden text-white min-h-screen flex items-center">

    <!-- ================= BACKGROUND IMAGE ================= -->
    <div class="absolute inset-0">

        <!-- Background Image -->
        <img src="./assets/img/african-market-woman.jpg"
             alt="African Market Woman"
             class="w-full h-full object-cover">

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/65"></div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-black/70"></div>

    </div>

    <!-- ================= CONTENT ================= -->
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-16 lg:py-24 grid xl:grid-cols-2 gap-14 items-center relative z-10">

        <!-- Left Content -->
        <?php include "./components/hero/left.php"; ?>

        <!-- Right Content -->
        <?php include "./components/hero/right.php"; ?>

    </div>

</section>

<script src="./assets/js/hero.js"></script>