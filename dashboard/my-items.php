<?php
require_once __DIR__ . '/../config/db.php';

/*
|--------------------------------------------------------------------------
| SECURITY CHECK
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['user_id'])) {

    header("Location: ../login.php");
    exit;
}

$userId = (int) $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| VERIFY USER EXISTS
|--------------------------------------------------------------------------
*/
$userStmt = $pdo->prepare("
    SELECT id, full_name
    FROM users
    WHERE id = ?
    LIMIT 1
");

$userStmt->execute([$userId]);

$loggedInUser = $userStmt->fetch(PDO::FETCH_ASSOC);

if (!$loggedInUser) {

    session_destroy();

    header("Location: ../login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| FETCH ONLY ITEMS BELONGING TO LOGGED-IN USER
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT 
        items.id,
        items.user_id,
        items.title,
        items.price,
        items.category,
        items.description,
        items.location,
        items.status,
        items.created_at,

        item_images.image_blob,
        item_images.mime_type

    FROM items

    LEFT JOIN item_images 
        ON item_images.id = (

            SELECT ii.id
            FROM item_images ii
            WHERE ii.item_id = items.id
            ORDER BY ii.id ASC
            LIMIT 1
        )

    WHERE items.user_id = ?

    ORDER BY items.created_at DESC
");

$stmt->execute([$userId]);

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ================= PAGE WRAPPER ================= -->
<div class="bg-white rounded-[2rem] p-5 md:p-8 border border-gray-100 shadow-sm overflow-hidden animate-fadeInUp">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-10">

        <!-- LEFT -->
        <div>

            <div class="flex items-center gap-3">

                <!-- SVG ICON -->
                <div class="w-14 h-14 rounded-2xl bg-yellow-500/10
                            flex items-center justify-center">

                    <svg class="w-7 h-7 text-yellow-500"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M20 13V7a2 2 0 00-1-1.73l-6-3.46
                                 a2 2 0 00-2 0L5 5.27A2 2 0 004 7v6
                                 a2 2 0 001 1.73l6 3.46a2 2 0 002 0
                                 l6-3.46A2 2 0 0020 13z"/>

                    </svg>

                </div>

                <div>

                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                        My Listings
                    </h2>

                    <p class="text-gray-500 mt-1 text-sm md:text-base">
                        Manage all products you posted on MarketCircle
                    </p>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <a href="?page=post-item"
           class="inline-flex items-center justify-center gap-3
                  px-6 py-4 rounded-2xl
                  bg-yellow-500 hover:bg-yellow-600
                  text-black font-semibold
                  transition-all duration-300
                  hover:scale-[1.02]
                  shadow-lg shadow-yellow-500/20">

            <!-- PLUS SVG -->
            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 4v16m8-8H4"/>

            </svg>

            Post New Item

        </a>

    </div>

    <!-- ================= EMPTY STATE ================= -->
    <?php if (count($items) === 0): ?>

        <div class="py-20 flex flex-col items-center justify-center text-center">

            <div class="w-28 h-28 rounded-full bg-yellow-100
                        flex items-center justify-center mb-8">

                <svg class="w-14 h-14 text-yellow-500"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M20 13V7a2 2 0 00-1-1.73l-6-3.46
                             a2 2 0 00-2 0L5 5.27A2 2 0 004 7v6
                             a2 2 0 001 1.73l6 3.46a2 2 0 002 0
                             l6-3.46A2 2 0 0020 13z"/>

                </svg>

            </div>

            <h3 class="text-3xl font-bold text-gray-900">
                No Listings Yet
            </h3>

            <p class="text-gray-500 mt-3 max-w-md leading-relaxed">
                You haven’t posted any products yet.
                Start selling and grow your marketplace visibility.
            </p>

            <a href="in?page=post-item"
               class="mt-8 inline-flex items-center justify-center
                      px-6 py-4 rounded-2xl
                      bg-gray-900 hover:bg-black
                      text-white font-semibold
                      transition">

                Create First Listing

            </a>

        </div>

    <?php else: ?>

    <!-- ================= GRID ================= -->
    <div class="grid sm:grid-cols-2 2xl:grid-cols-3 gap-7">

        <?php foreach ($items as $item): ?>

        <!-- ================= CARD ================= -->
        <div class="group bg-white rounded-[2rem]
                    overflow-hidden border border-gray-100
                    hover:border-yellow-300
                    hover:shadow-2xl
                    transition-all duration-500
                    hover:-translate-y-1">

            <!-- ================= IMAGE ================= -->
            <div class="relative h-64 overflow-hidden bg-gray-100">

                <?php if (!empty($item['image_blob'])): ?>

                    <img
                        src="data:<?= htmlspecialchars($item['mime_type']) ?>;base64,<?= base64_encode($item['image_blob']) ?>"
                        alt="<?= htmlspecialchars($item['title']) ?>"
                        class="w-full h-full object-cover
                               group-hover:scale-110
                               transition duration-700"
                    >

                <?php else: ?>

                    <div class="w-full h-full flex items-center justify-center bg-gray-50">

                        <svg class="w-20 h-20 text-gray-300"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.5"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 7l9-4 9 4-9 4-9-4z"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 17l9 4 9-4"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 12l9 4 9-4"/>

                        </svg>

                    </div>

                <?php endif; ?>

                <!-- DARK OVERLAY -->
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></div>

                <!-- STATUS -->
                <div class="absolute top-4 left-4">

                    <span class="px-4 py-2 rounded-full text-xs font-semibold backdrop-blur-sm
                        <?= $item['status'] === 'approved'
                            ? 'bg-green-500 text-white'
                            : 'bg-yellow-500 text-black'
                        ?>">

                        <?= ucfirst(htmlspecialchars($item['status'])) ?>

                    </span>

                </div>

            </div>

            <!-- ================= CONTENT ================= -->
            <div class="p-6">

                <!-- CATEGORY -->
                <div class="mb-4">

                    <span class="inline-flex items-center
                                 px-3 py-1 rounded-full
                                 text-xs font-semibold
                                 bg-gray-100 text-gray-700">

                        <?= htmlspecialchars($item['category']) ?>

                    </span>

                </div>

                <!-- TITLE -->
                <h3 class="text-2xl font-bold text-gray-900 line-clamp-1">
                    <?= htmlspecialchars($item['title']) ?>
                </h3>

                <!-- LOCATION -->
                <div class="flex items-center gap-2 mt-3 text-gray-500 text-sm">

                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M17.657 16.657L13.414 20.9
                                 a2 2 0 01-2.828 0
                                 l-4.243-4.243
                                 a8 8 0 1111.314 0z"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15 11a3 3 0 11-6 0
                                 3 3 0 016 0z"/>

                    </svg>

                    <?= htmlspecialchars($item['location']) ?>

                </div>

                <!-- PRICE -->
                <div class="mt-5">

                    <h4 class="text-3xl font-bold text-gray-900">
                        GHS <?= number_format($item['price'], 2) ?>
                    </h4>

                </div>

                <!-- DATE -->
                <div class="mt-2 text-sm text-gray-400">
                    Posted <?= date("F j, Y", strtotime($item['created_at'])) ?>
                </div>

                <!-- ================= ACTIONS ================= -->
                <div class="mt-7 flex flex-col sm:flex-row gap-3">

                    <!-- VIEW -->
                    <a href="?page=view-item&id=<?= $item['id'] ?>"
                       class="flex-1 flex items-center justify-center gap-2
                              py-3.5 rounded-2xl
                              bg-gray-900 hover:bg-yellow-500
                              hover:text-black
                              text-white font-semibold
                              transition-all duration-300">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0
                                     3 3 0 016 0z"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M2.458 12C3.732 7.943
                                     7.523 5 12 5
                                     c4.478 0 8.268 2.943
                                     9.542 7
                                     -1.274 4.057
                                     -5.064 7
                                     -9.542 7
                                     -4.477 0
                                     -8.268-2.943
                                     -9.542-7z"/>

                        </svg>

                        View

                    </a>

                    <!-- EDIT -->
                    <a href="?page=edit-item&id=<?= $item['id'] ?>"
                       class="flex-1 flex items-center justify-center gap-2
                              py-3.5 rounded-2xl
                              border border-gray-200
                              hover:bg-gray-100
                              font-semibold
                              transition-all duration-300">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M11 5h2m-1-1v2m6.586 2.586
                                     a2 2 0 010 2.828l-8.172 8.172
                                     a4 4 0 01-1.414.943L6 21l.471-2.828
                                     a4 4 0 01.943-1.414l8.172-8.172
                                     a2 2 0 012.828 0z"/>

                        </svg>

                        Edit

                    </a>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

    <?php endif; ?>

</div>

<!-- ================= ANIMATION ================= -->
<style>
@keyframes fadeInUp {

    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp .5s ease;
}
</style>