<?php
require_once __DIR__ . '/../config/db.php';

$userId = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| USER DATA
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| PROFILE IMAGE (LATEST ONE)
|--------------------------------------------------------------------------
*/
$stmtImg = $pdo->prepare("
    SELECT image_blob, mime_type 
    FROM user_images 
    WHERE user_id = ? 
    ORDER BY id DESC 
    LIMIT 1
");
$stmtImg->execute([$userId]);
$profile = $stmtImg->fetch(PDO::FETCH_ASSOC);
?>

<div class="bg-white rounded-3xl shadow-sm p-6 md:p-8">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center gap-6">

        <!-- AVATAR -->
        <div class="w-28 h-28 rounded-full overflow-hidden shadow-lg border-2 border-yellow-400 bg-gray-100 flex items-center justify-center">

            <?php if ($profile && !empty($profile['image_blob'])): ?>

                <img
                    src="data:<?= $profile['mime_type'] ?>;base64,<?= base64_encode($profile['image_blob']) ?>"
                    class="w-full h-full object-cover">

            <?php else: ?>

                <div class="w-full h-full flex items-center justify-center bg-yellow-500 text-black text-3xl font-bold">
                    <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                </div>

            <?php endif; ?>

        </div>

        <!-- INFO -->
        <div>
            <h2 class="text-3xl font-bold">
                <?= htmlspecialchars($user['full_name']) ?>
            </h2>

            <p class="text-gray-500 mt-1">
                <?= htmlspecialchars($user['email']) ?>
            </p>

            <div class="mt-3 text-sm text-gray-400">
                <?= htmlspecialchars($user['phone']) ?> • <?= htmlspecialchars($user['location']) ?>
            </div>
        </div>

    </div>

    <!-- FORM -->
    <div class="mt-10">

        <form id="profileForm" class="grid md:grid-cols-2 gap-6">

            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <!-- FULL NAME -->
            <div>
                <label class="text-sm font-medium">Full Name</label>
                <input type="text" name="full_name"
                    value="<?= htmlspecialchars($user['full_name']) ?>"
                    class="w-full mt-1 px-4 py-3 rounded-2xl border focus:ring-2 focus:ring-yellow-400">
            </div>

            <!-- EMAIL -->
            <div>
                <label class="text-sm font-medium">Email</label>
                <input type="email" name="email"
                    value="<?= htmlspecialchars($user['email']) ?>"
                    class="w-full mt-1 px-4 py-3 rounded-2xl border focus:ring-2 focus:ring-yellow-400">
            </div>

            <!-- PHONE -->
            <div>
                <label class="text-sm font-medium">Phone</label>
                <input type="text" name="phone"
                    value="<?= htmlspecialchars($user['phone']) ?>"
                    class="w-full mt-1 px-4 py-3 rounded-2xl border focus:ring-2 focus:ring-yellow-400">
            </div>

            <!-- LOCATION -->
            <div>
                <label class="text-sm font-medium">Location</label>
                <input type="text" name="location"
                    value="<?= htmlspecialchars($user['location']) ?>"
                    class="w-full mt-1 px-4 py-3 rounded-2xl border focus:ring-2 focus:ring-yellow-400">
            </div>

            <!-- SAVE -->
            <div class="md:col-span-2 pt-4">
                <button type="submit"
                    class="px-6 py-3 rounded-2xl bg-yellow-500 hover:bg-yellow-600 text-black font-semibold transition">

                    Save Changes

                </button>
            </div>

        </form>

    </div>
</div>

<!-- SWEETALERT -->
<script>
document.getElementById("profileForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    const res = await fetch("../services/update-profile.php", {
        method: "POST",
        body: formData
    });

    const data = await res.json();

    if (data.status === "success") {
        Swal.fire("Success", data.message, "success");
    } else {
        Swal.fire("Error", data.message, "error");
    }
});
</script>