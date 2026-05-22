<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<div class="max-w-5xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Post New Item
        </h1>

        <p class="text-gray-500 mt-2">
            Add a product to your marketplace. All listings are reviewed for quality.
        </p>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">

        <form action="../services/post-item-handler.php"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">

            <!-- ITEM TITLE -->
            <div>
                <label class="text-sm font-medium text-gray-700">Item Title</label>

                <input type="text"
                       name="title"
                       required
                       class="w-full mt-2 px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-yellow-400 outline-none"
                       placeholder="e.g. iPhone 14 Pro Max 256GB">
            </div>

            <!-- CATEGORY + PRICE -->
            <div class="grid md:grid-cols-2 gap-5">

                <!-- CATEGORY -->
                <div>
                    <label class="text-sm font-medium text-gray-700">Category</label>

                    <select name="category"
                            required
                            class="w-full mt-2 px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-yellow-400 outline-none">

                        <option value="">Select category</option>
                        <option>Electronics</option>
                        <option>Fashion</option>
                        <option>Vehicles</option>
                        <option>Property</option>
                        <option>Beauty</option>
                        <option>Services</option>
                        <option>Food</option>
                        <option>Jobs</option>

                    </select>
                </div>

                <!-- PRICE -->
                <div>
                    <label class="text-sm font-medium text-gray-700">Price (GHS)</label>

                    <input type="number"
                           name="price"
                           required
                           class="w-full mt-2 px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-yellow-400 outline-none"
                           placeholder="0.00">
                </div>

            </div>

            <!-- DESCRIPTION -->
            <div>
                <label class="text-sm font-medium text-gray-700">Description</label>

                <textarea name="description"
                          rows="5"
                          required
                          class="w-full mt-2 px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-yellow-400 outline-none"
                          placeholder="Describe your item clearly..."></textarea>
            </div>

            <!-- LOCATION -->
            <div>
                <label class="text-sm font-medium text-gray-700">Location</label>

                <input type="text"
                       name="location"
                       required
                       class="w-full mt-2 px-4 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-yellow-400 outline-none"
                       placeholder="Accra, Ghana">
            </div>

            <!-- IMAGE UPLOAD -->
            <div>
                <label class="text-sm font-medium text-gray-700">
                    Upload Images
                </label>

                <div class="mt-3 border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-yellow-400 transition">

                    <input type="file"
                           name="images[]"
                           multiple
                           accept="image/*"
                           class="w-full">

                    <p class="text-sm text-gray-500 mt-3">
                        Upload clear images (Max 500KB per image)
                    </p>

                </div>
            </div>

            <!-- SUBMIT -->
            <div class="pt-4">

                <button type="submit"
                        class="w-full py-4 rounded-2xl bg-yellow-500 hover:bg-yellow-600 text-black font-semibold transition shadow-sm group">

                    <span class="flex items-center justify-center gap-2">

                        Publish Item

                        <!-- ARROW SVG -->
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition"
                             fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 5l7 7-7 7"/>
                        </svg>

                    </span>

                </button>

            </div>

        </form>

    </div>

</div>