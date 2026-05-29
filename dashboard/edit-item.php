<?php
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$itemId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($itemId <= 0) {
    echo "<div class='p-6 text-red-500'>Invalid item ID</div>";
    exit;
}

/*
|--------------------------------------------------------------------------
| FETCH ITEM (SECURE OWNERSHIP CHECK)
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT * FROM items
    WHERE id = ? AND user_id = ?
    LIMIT 1
");

$stmt->execute([$itemId, $userId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "<div class='p-6 text-red-500'>Item not found or unauthorized</div>";
    exit;
}

/*
|--------------------------------------------------------------------------
| FETCH ALL IMAGES
|--------------------------------------------------------------------------
*/
$stmtImg = $pdo->prepare("
    SELECT id, image_blob, mime_type
    FROM item_images
    WHERE item_id = ?
");

$stmtImg->execute([$itemId]);
$images = $stmtImg->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="max-w-6xl mx-auto p-4 md:p-8 animate-fadeInUp">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Item</h1>
        <p class="text-gray-500 mt-2">Update your listing and manage images</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 bg-white rounded-3xl border shadow-sm overflow-hidden">

        <!-- ================= IMAGE GALLERY ================= -->
        <div class="p-4 md:p-6 bg-gray-50">

            <h3 class="font-semibold mb-4 text-gray-700">Images</h3>

            <!-- MAIN IMAGE -->
            <?php if (count($images) > 0): ?>

                <div class="rounded-2xl overflow-hidden mb-4 border bg-white">

                    <img id="mainImage"
                         src="data:<?= $images[0]['mime_type'] ?>;base64,<?= base64_encode($images[0]['image_blob']) ?>"
                         class="w-full h-80 object-cover transition">

                </div>

            <?php else: ?>

                <div class="h-80 flex items-center justify-center bg-white border rounded-2xl text-gray-400">
                    No Images Available
                </div>

            <?php endif; ?>

            <!-- THUMBNAILS -->
            <div class="grid grid-cols-4 gap-2">

                <?php foreach ($images as $img): ?>

                    <img
                        onclick="changeMain(this)"
                        src="data:<?= $img['mime_type'] ?>;base64,<?= base64_encode($img['image_blob']) ?>"
                        class="h-20 w-full object-cover rounded-xl border cursor-pointer hover:scale-105 transition">

                <?php endforeach; ?>

            </div>

            <!-- ADD NEW IMAGE -->
            <div class="mt-6">

                <label class="text-sm font-medium text-gray-600">Upload New Image</label>

                <input type="file"
                       name="image"
                       accept="image/*"
                       form="editItemForm"
                       class="w-full mt-2 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400">

                <p class="text-xs text-gray-400 mt-2">
                    Uploading a new image will replace the main one
                </p>

            </div>

        </div>

        <!-- ================= FORM ================= -->
        <form id="editItemForm"
              action="../services/update-item.php"
              method="POST"
              enctype="multipart/form-data"
              class="p-6 md:p-10 space-y-5">

            <input type="hidden" name="id" value="<?= $item['id'] ?>">

            <!-- TITLE -->
            <div>
                <label class="text-sm font-medium">Title</label>
                <input type="text" name="title"
                       value="<?= htmlspecialchars($item['title']) ?>"
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400">
            </div>

            <!-- PRICE -->
            <div>
                <label class="text-sm font-medium">Price</label>
                <input type="number" name="price"
                       value="<?= $item['price'] ?>"
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400">
            </div>

            <!-- CATEGORY -->
            <div>
                <label class="text-sm font-medium">Category</label>
                <input type="text" name="category"
                       value="<?= htmlspecialchars($item['category']) ?>"
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400">
            </div>

            <!-- LOCATION -->
            <div>
                <label class="text-sm font-medium">Location</label>
                <input type="text" name="location"
                       value="<?= htmlspecialchars($item['location']) ?>"
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400">
            </div>

            <!-- DESCRIPTION -->
            <div>
                <label class="text-sm font-medium">Description</label>
                <textarea name="description"
                          rows="4"
                          class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400"><?= htmlspecialchars($item['description']) ?></textarea>
            </div>

            <!-- BUTTONS -->
            <div class="flex gap-3 pt-4">

                <button type="submit"
                        class="flex-1 py-3 rounded-2xl bg-yellow-500 hover:bg-yellow-600
                               font-semibold text-black transition">

                    Update Item

                </button>

                <a href="index.php?page=my-items"
                   class="flex-1 py-3 rounded-2xl border text-center hover:bg-gray-100 transition">

                    Cancel

                </a>

            </div>

        </form>
    </div>
</div>

<!-- ================= JS ================= -->
<script>
function changeMain(el) {
    document.getElementById("mainImage").src = el.src;
}

document.getElementById("editItemForm").addEventListener("submit", async function (e) {

    e.preventDefault();

    const formData = new FormData(this);

    const res = await fetch(this.action, {
        method: "POST",
        body: formData
    });

    const data = await res.json();

    if (data.status === "success") {

        Swal.fire({
            icon: "success",
            title: "Updated",
            text: data.message,
            confirmButtonColor: "#eab308"
        }).then(() => {
            window.location.href = "index.php?page=my-items";
        });

    } else {

        Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message
        });

    }
});
</script>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeInUp {
    animation: fadeInUp .5s ease;
}
</style>