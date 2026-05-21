<!-- ================= FEATURED LISTINGS ================= -->
<section class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-4 md:px-6">

        <!-- HEADER -->
        <div class="mb-10">
            <h2 class="text-3xl font-bold tracking-tight">
                Featured Listings
            </h2>
            <p class="text-gray-500 mt-2">
                Discover verified products from trusted sellers across Ghana
            </p>
        </div>

        <!-- ================= WRAPPER ================= -->
        <div class="relative">

            <!-- LEFT ARROW -->
            <button id="leftBtn"
                onclick="scrollCarousel(-1)"
                class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 z-10 w-11 h-11 items-center justify-center bg-white border shadow-md rounded-full hover:bg-gray-100 transition disabled:opacity-30 disabled:cursor-not-allowed">

                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>

            </button>

            <!-- RIGHT ARROW -->
            <button id="rightBtn"
                onclick="scrollCarousel(1)"
                class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 z-10 w-11 h-11 items-center justify-center bg-white border shadow-md rounded-full hover:bg-gray-100 transition disabled:opacity-30 disabled:cursor-not-allowed">

                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>

            </button>

            <!-- CAROUSEL -->
            <div id="carousel"
                class="flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory px-1 no-scrollbar">

                <?php for ($i = 1; $i <= 12; $i++): ?>

                <?php
                    $badges = ["Verified", "Hot Deal", "New"];
                    $badge = $badges[array_rand($badges)];
                ?>

                <!-- CARD -->
                <a href="product.php?id=<?= $i ?>"
                   class="min-w-[85%] sm:min-w-[45%] lg:min-w-[30%] xl:min-w-[24%] snap-center bg-white rounded-2xl overflow-hidden border shadow-sm hover:shadow-xl transition group hover:-translate-y-1">

                    <!-- IMAGE -->
                    <div class="relative h-52 overflow-hidden">

                        <img
                            src="https://source.unsplash.com/600x500/?ghana,market,product,<?= $i ?>"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                        >

                        <!-- BADGE -->
                        <div class="absolute top-3 left-3">
                            <span class="text-xs font-semibold px-3 py-1 rounded-full text-white
                                <?= $badge === 'Verified' ? 'bg-green-500' : '' ?>
                                <?= $badge === 'Hot Deal' ? 'bg-red-500' : '' ?>
                                <?= $badge === 'New' ? 'bg-blue-500' : '' ?>">
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

                        <!-- 🔥 CATCHY BUTTON -->
                        <button class="mt-4 w-full relative overflow-hidden bg-gradient-to-r from-yellow-400 to-yellow-500 text-black py-3 rounded-xl text-sm font-semibold shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 group/btn">

                            <span class="relative z-10 flex items-center justify-center gap-2">
                                View

                                <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1"
                                     fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>

                            <span class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></span>

                        </button>

                    </div>

                </a>

                <?php endfor; ?>

            </div>

        </div>

    </div>
</section>

<script>
const carousel = document.getElementById("carousel");
const leftBtn = document.getElementById("leftBtn");
const rightBtn = document.getElementById("rightBtn");

function updateButtons() {
    const maxScroll = carousel.scrollWidth - carousel.clientWidth;

    leftBtn.disabled = carousel.scrollLeft <= 0;
    rightBtn.disabled = carousel.scrollLeft >= maxScroll - 5;
}

function scrollCarousel(direction) {
    carousel.scrollBy({
        left: direction * 350,
        behavior: "smooth"
    });

    setTimeout(updateButtons, 300);
}

carousel.addEventListener("scroll", updateButtons);
window.addEventListener("load", updateButtons);
</script>

<style>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    scrollbar-width: none;
    -ms-overflow-style: none;
}
</style>