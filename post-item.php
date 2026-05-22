<?php
session_start();

/*
|--------------------------------------------------------------------------
| AUTH CHECK (IMPORTANT)
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=post-item");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include './components/head.php'; ?>

<body class="bg-white text-gray-800">

<?php include './components/navbar.php'; ?>

<!-- ================= PAGE WRAPPER ================= -->
<div class="max-w-5xl mx-auto px-4 py-12">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight">
            Post an Item
        </h1>

        <p class="text-gray-500 mt-2">
            List your product and reach thousands of buyers in Ghana
        </p>
    </div>

    <!-- ALERT (optional session message) -->
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="mb-6 bg-red-50 text-red-600 px-4 py-3 rounded-xl border border-red-200">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- ================= FORM ================= -->
    <form id="postForm" action="./services/post-item-handler.php"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white p-6 md:p-10 rounded-2xl shadow-sm space-y-6">

        <!-- TITLE -->
        <div>
            <label class="text-sm font-medium">Item Title</label>
            <input type="text" name="title" required
                   class="mt-2 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
        </div>

        <!-- CATEGORY -->
        <div>
            <label class="text-sm font-medium">Category</label>
            <select name="category" required
                    class="mt-2 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
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

        <!-- PRICE + LOCATION -->
        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="text-sm font-medium">Price (GHS)</label>
                <input type="number" name="price" required
                       class="mt-2 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
            </div>

            <div>
                <label class="text-sm font-medium">Location</label>
                <input type="text" name="location" required
                       class="mt-2 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
            </div>

        </div>

        <!-- DESCRIPTION -->
        <div>
            <label class="text-sm font-medium">Description</label>
            <textarea name="description" rows="5"
                      class="mt-2 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none"></textarea>
        </div>

        <!-- IMAGE UPLOAD -->
        <div>
            <label class="text-sm font-medium">Product Images</label>

            <input type="file" name="images[]" multiple accept="image/*"
                   class="mt-2 w-full px-4 py-3 border rounded-xl bg-white">
        </div>

        <!-- USER INFO (AUTO) -->
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

        <!-- SUBMIT -->
        <button type="submit"
                class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 rounded-xl transition shadow-sm">
            Post Item
        </button>

    </form>

</div>

<?php include './components/footer.php'; ?>

<script src="./assets/js/post-item.js"></script>

</body>
</html>