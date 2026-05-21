<!-- ================= CATEGORIES ================= -->
<section class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-4 md:px-6">

        <!-- HEADER -->
        <div class="mb-10">
            <h2 class="text-3xl font-bold tracking-tight">
                Browse Categories
            </h2>
            <p class="text-gray-500 mt-2">
                Explore top categories and find what you need instantly
            </p>
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            <?php
            $categories = [
                ["name"=>"Electronics","desc"=>"Phones, laptops & gadgets","slug"=>"electronics","color"=>"text-blue-500","bg"=>"bg-blue-500/10"],
                ["name"=>"Fashion","desc"=>"Clothes & footwear","slug"=>"fashion","color"=>"text-pink-500","bg"=>"bg-pink-500/10"],
                ["name"=>"Vehicles","desc"=>"Cars, bikes & more","slug"=>"vehicles","color"=>"text-red-500","bg"=>"bg-red-500/10"],
                ["name"=>"Property","desc"=>"Houses & rentals","slug"=>"property","color"=>"text-yellow-500","bg"=>"bg-yellow-500/10"],
                ["name"=>"Beauty","desc"=>"Cosmetics & care","slug"=>"beauty","color"=>"text-purple-500","bg"=>"bg-purple-500/10"],
                ["name"=>"Services","desc"=>"Skilled professionals","slug"=>"services","color"=>"text-green-500","bg"=>"bg-green-500/10"],
                ["name"=>"Food","desc"=>"Meals & groceries","slug"=>"food","color"=>"text-orange-500","bg"=>"bg-orange-500/10"],
                ["name"=>"Jobs","desc"=>"Opportunities near you","slug"=>"jobs","color"=>"text-indigo-500","bg"=>"bg-indigo-500/10"]
            ];

            foreach ($categories as $cat):
            ?>

            <!-- CARD -->
            <a href="category.php?cat=<?= $cat['slug'] ?>"
               class="group block bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">

                <!-- ICON -->
                <div class="w-12 h-12 flex items-center justify-center rounded-xl <?= $cat['bg'] ?> mb-4 group-hover:scale-110 transition">

                    <svg class="w-6 h-6 <?= $cat['color'] ?>" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                        <?php if ($cat['name'] == "Electronics") { ?>
                            <path d="M9 17h6M9 13h6M9 9h6M5 5h14v14H5z"/>
                        <?php } elseif ($cat['name'] == "Fashion") { ?>
                            <path d="M6 4l6 4 6-4v16H6V4z"/>
                        <?php } elseif ($cat['name'] == "Vehicles") { ?>
                            <path d="M3 13l2-5h14l2 5M5 13h14v6H5v-6z"/>
                        <?php } elseif ($cat['name'] == "Property") { ?>
                            <path d="M3 12l9-9 9 9v9H3v-9z"/>
                        <?php } elseif ($cat['name'] == "Beauty") { ?>
                            <path d="M12 2l3 7h7l-5.5 4 2 7-6.5-4.5L6.5 20l2-7L3 9h7z"/>
                        <?php } elseif ($cat['name'] == "Services") { ?>
                            <path d="M4 7h16M4 12h16M4 17h10"/>
                        <?php } elseif ($cat['name'] == "Food") { ?>
                            <path d="M3 3h18v6H3V3zm0 8h18v10H3V11z"/>
                        <?php } else { ?>
                            <path d="M4 6h16M4 12h16M4 18h10"/>
                        <?php } ?>

                    </svg>

                </div>

                <!-- TEXT -->
                <h3 class="font-semibold text-gray-900 group-hover:text-black transition">
                    <?= $cat['name'] ?>
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    <?= $cat['desc'] ?>
                </p>

                <!-- ARROW -->
                <div class="mt-4 text-sm text-gray-400 group-hover:text-black flex items-center gap-1 transition">
                    View listings
                    <span class="group-hover:translate-x-1 transition">→</span>
                </div>

            </a>

            <?php endforeach; ?>

        </div>

    </div>
</section>