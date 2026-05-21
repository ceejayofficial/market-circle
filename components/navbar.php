<!-- ================= NAVBAR ================= -->


<head>
    <link rel="stylesheet" href="./assets/css/navbar.css">
</head>
<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b shadow-sm">

    <div class="max-w-7xl mx-auto flex items-center justify-between px-4 md:px-6 h-16">

        <!-- ================= LOGO ================= -->
        <div class="text-2xl font-bold tracking-tight select-none">
            Market<span class="text-yellow-500">Circle</span>
        </div>

        <!-- ================= DESKTOP MENU (≥1212px ONLY) ================= -->
        <nav class="desktop-menu flex items-center space-x-8 text-sm font-medium">

            <a href="index.php" class="nav-link">Home</a>
            <a href="#explore.php" class="nav-link">Explore</a>
            <a href="#categories" class="nav-link">Categories</a>
            <a href="#how-it-works" class="nav-link">How It Works</a>
            <a href="#verified-sellers.php" class="nav-link">Verified Sellers</a>

        </nav>

        <!-- ================= ACTIONS (≥1212px ONLY) ================= -->
        <div class="desktop-actions flex items-center space-x-3">

            <input type="text"
                   placeholder="Search items..."
                   class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">

            <a href="#" class="text-sm hover:text-yellow-500 transition">Login</a>

            <a href="#"
               class="px-4 py-2 rounded-lg text-sm bg-gray-900 text-white hover:bg-black transition">
                Register
            </a>

            <a href="#"
               class="px-4 py-2 rounded-lg text-sm font-semibold bg-yellow-500 text-black hover:bg-yellow-600 transition shadow-sm">
                Post Item
            </a>

        </div>

        <!-- ================= HAMBURGER (<1212px ONLY) ================= -->
        <button id="menuBtn" class="hamburger flex flex-col justify-center items-center space-y-1.5 w-10 h-10">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>
</header>

<!-- ================= FULL SCREEN MENU ================= -->
<div id="mobileMenu"
     class="fixed inset-0 bg-white z-50 flex flex-col opacity-0 pointer-events-none scale-95 transition-all duration-300">

    <!-- TOP BAR -->
    <div class="flex items-center justify-between px-6 py-5 border-b">
        <div class="text-xl font-bold">
            Market<span class="text-yellow-500">Circle</span>
        </div>

        <button id="closeMenu" class="text-3xl leading-none">
            ✕
        </button>
    </div>

    <!-- LINKS -->
    <div class="flex flex-col space-y-6 px-6 py-10 text-lg font-medium">

        <a href="index.php" class="hover:text-yellow-500 transition">Home</a>
        <a href="#explore.php" class="hover:text-yellow-500 transition">Explore</a>
        <a href="#categories" class="hover:text-yellow-500 transition">Categories</a>
        <a href="#how-it-works" class="hover:text-yellow-500 transition">How It Works</a>
        <a href="#verified-sellers.php" class="hover:text-yellow-500 transition">Verified Sellers</a>

    </div>

    <!-- SEARCH -->
    <div class="px-6">
        <input type="text"
               placeholder="Search items..."
               class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400">
    </div>

    <!-- ACTION BUTTONS -->
    <div class="px-6 mt-8 space-y-4">

        <a href="#" class="block text-center py-3 border rounded-xl hover:bg-gray-100 transition">
            Login
        </a>

        <a href="#" class="block text-center py-3 bg-gray-900 text-white rounded-xl hover:bg-black transition">
            Register
        </a>

        <a href="#" class="block text-center py-3 bg-yellow-500 text-black rounded-xl font-semibold hover:bg-yellow-600 transition">
            Post Item
        </a>

    </div>
</div>

<script src="./assets/js/navbar.js"></script>
