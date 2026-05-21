<!-- ================= PRELOADER ================= -->
<div id="preloader"
     class="fixed inset-0 bg-white z-[9999] flex items-center justify-center transition-all duration-500">

    <div class="flex flex-col items-center">

        <!-- Spinner -->
        <div class="relative w-20 h-20">

            <!-- Outer Ring -->
            <div class="absolute inset-0 border-4 border-yellow-500/20 rounded-full"></div>

            <!-- Animated Ring -->
            <div class="absolute inset-0 border-4 border-transparent border-t-yellow-500 border-r-yellow-500 rounded-full animate-spin"></div>

            <!-- Inner Circle -->
            <div class="absolute inset-3 bg-black rounded-full flex items-center justify-center shadow-lg">

                <span class="text-white font-bold text-sm tracking-wide">
                    MC
                </span>

            </div>

        </div>

        <!-- Loading Text -->
        <p class="mt-5 text-sm text-gray-500 font-medium tracking-wide">
            Loading Marketplace...
        </p>

    </div>
</div>

<script src="./assets/js/preloader.js"></script>