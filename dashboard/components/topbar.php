<?php
require_once __DIR__ . '/../../config/db.php';


$userId = $_SESSION['user_id'] ?? null;

/*
|-------------------------------------------------
| DEFAULT PROFILE
|-------------------------------------------------
*/
$profileImg = null;
$profileMime = null;

if ($userId) {

    try {

        $stmt = $pdo->prepare("
            SELECT image_blob, mime_type 
            FROM user_images 
            WHERE user_id = ? 
            LIMIT 1
        ");

        $stmt->execute([$userId]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($profile) {
            $profileImg = $profile['image_blob'];
            $profileMime = $profile['mime_type'];
        }

    } catch (Exception $e) {
        // silently fail (do not break UI)
        $profileImg = null;
    }
}
?>

<header class="bg-white border-b sticky top-0 z-30 shadow-sm">

    <div class="h-20 flex items-center justify-between px-4 md:px-6">

        <!-- ================= LEFT ================= -->
        <div class="flex items-center gap-3">

            <!-- HAMBURGER -->
            <button id="openSidebar"
                    class="lg:hidden flex flex-col gap-1 w-10 h-10 justify-center items-center">

                <span class="w-6 h-0.5 bg-black"></span>
                <span class="w-6 h-0.5 bg-black"></span>
                <span class="w-6 h-0.5 bg-black"></span>

            </button>

            <div>
                <h1 class="text-xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-sm text-gray-500">Manage your marketplace</p>
            </div>

        </div>

        <!-- ================= RIGHT ================= -->
        <div class="flex items-center gap-4">

            <!-- PROFILE UPLOAD -->
            <label class="relative cursor-pointer group">

                <input type="file"
                       id="profileUpload"
                       class="hidden"
                       accept="image/*">

                <!-- AVATAR -->
                <?php if ($profileImg): ?>

                    <img
                        src="data:<?= htmlspecialchars($profileMime) ?>;base64,<?= base64_encode($profileImg) ?>"
                        class="w-11 h-11 rounded-full object-cover border-2 border-yellow-500
                               shadow-sm group-hover:scale-110 transition duration-300"
                    >

                <?php else: ?>

                    <div class="w-11 h-11 rounded-full bg-gray-100 flex items-center justify-center
                                border group-hover:bg-gray-200 transition">

                        <svg class="w-5 h-5 text-gray-500"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M5.121 17.804A4 4 0 019 16h6a4 4 0 013.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

                        </svg>

                    </div>

                <?php endif; ?>

                <!-- HOVER LABEL -->
                <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-xs text-gray-500
                             opacity-0 group-hover:opacity-100 transition">
                    Upload Photo
                </span>

            </label>

        </div>

    </div>

</header>

<script>
document.getElementById("profileUpload").addEventListener("change", async function () {

    const formData = new FormData();
    formData.append("image", this.files[0]);

    const res = await fetch("../services/upload-profile.php", {
        method: "POST",
        body: formData
    });

    const data = await res.json();

    if (data.status === "success") {

        Swal.fire({
            icon: "success",
            title: "Updated",
            text: data.message
        }).then(() => location.reload());

    } else {

        Swal.fire({
            icon: "error",
            title: "Failed",
            text: data.message
        });

    }
});
</script>