<!-- ================= FEATURED ITEMS ================= -->
<section class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-4 md:px-6">

        <!-- HEADER -->
        <div class="mb-10">
            <h2 class="text-3xl font-bold tracking-tight">
                Featured Listings
            </h2>
            <p class="text-gray-500 mt-2">
                Discover verified products from trusted sellers
            </p>
        </div>

        <!-- GRID -->
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            <?php for ($i = 1; $i <= 8; $i++): ?>

            <?php
                $badges = ["Verified", "Hot Deal", "New"];
                $badge = $badges[array_rand($badges)];
            ?>

            <!-- CARD -->
            <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 hover:-translate-y-1">

                <!-- IMAGE WRAPPER -->
                <div class="relative h-52 overflow-hidden">

                    <!-- IMAGE -->
                    <img
                        src="https://source.unsplash.com/600x500/?market,product,ghana,shopping,<?= $i ?>"
                        alt="Product"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out"
                    >

                    <!-- DARK OVERLAY ON HOVER -->
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition"></div>

                    <!-- BADGE -->
                    <div class="absolute top-3 left-3">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            <?= $badge === 'Verified' ? 'bg-green-500 text-white' : '' ?>
                            <?= $badge === 'Hot Deal' ? 'bg-red-500 text-white' : '' ?>
                            <?= $badge === 'New' ? 'bg-blue-500 text-white' : '' ?>
                        ">
                            <?= $badge ?>
                        </span>
                    </div>

                </div>

                <!-- CONTENT -->
                <div class="p-5">

                    <h3 class="font-semibold text-gray-900 group-hover:text-black transition">
                        Premium Product <?= $i ?>
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Accra, Ghana
                    </p>

                    <div class="mt-3 flex items-center justify-between">

                        <p class="text-lg font-bold text-gray-900">
                            GHS <?= rand(120, 5000) ?>
                        </p>

                        <span class="text-xs text-gray-400">
                            negotiable
                        </span>

                    </div>

                    <!-- ================= BUTTON ================= -->
                    <button class="mt-4 w-full relative overflow-hidden bg-gray-900 text-white py-3 rounded-xl text-sm font-medium transition-all duration-300 group/btn hover:bg-yellow-500 hover:text-black">

                        <!-- TEXT -->
                        <span class="relative z-10 flex items-center justify-center gap-2">

                            View Details

                            <!-- ARROW ICON -->
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1"
                                 fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 5l7 7-7 7"/>
                            </svg>

                        </span>

                        <!-- BUTTON SHINE EFFECT -->
                        <span class="absolute inset-0 bg-white/10 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></span>

                    </button>

                </div>

            </div>

            <?php endfor; ?>

        </div>

    </div>
</section>