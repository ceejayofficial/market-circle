<?php

require_once __DIR__ . '/config/db.php';

/*
|--------------------------------------------------------------------------
| SESSION
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/*
|--------------------------------------------------------------------------
| ITEM ID
|--------------------------------------------------------------------------
*/

$itemId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($itemId <= 0) {
    header("Location: explore.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| FETCH ITEM
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT 
        i.id,
        i.user_id,
        i.title,
        i.category,
        i.price,
        i.location,
        i.description,
        i.status,
        i.created_at,
        u.full_name,
        u.phone,
        u.email
    FROM items i
    LEFT JOIN users u 
        ON u.id = i.user_id
    WHERE i.id = ?
    LIMIT 1
");

$stmt->execute([$itemId]);

$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    header("Location: explore.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| FETCH IMAGES
|--------------------------------------------------------------------------
*/

$stmtImg = $pdo->prepare("
    SELECT
        id,
        image_blob,
        mime_type
    FROM item_images
    WHERE item_id = ?
    ORDER BY id ASC
");

$stmtImg->execute([$itemId]);

$images = $stmtImg->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| HELPERS
|--------------------------------------------------------------------------
*/

function e($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}


/*
|--------------------------------------------------------------------------
| STATUS STYLE
|--------------------------------------------------------------------------
*/

$status = strtolower($item['status']);

$statusClass = match ($status) {

    'active' =>
        'bg-green-100 text-green-700',

    'sold' =>
        'bg-red-100 text-red-700',

    'inactive' =>
        'bg-gray-100 text-gray-600',

    default =>
        'bg-yellow-100 text-yellow-700'
};


/*
|--------------------------------------------------------------------------
| WHATSAPP NUMBER
|--------------------------------------------------------------------------
*/

$whatsappNumber = preg_replace(
    '/[^0-9]/',
    '',
    $item['phone'] ?? ''
);


/*
|--------------------------------------------------------------------------
| COMPONENTS
|--------------------------------------------------------------------------
*/

include './components/head.php';
include './components/preloader.php';
include './components/navbar.php';

?>


<!-- ============================================================
     VIEW ITEM
============================================================ -->

<section class="py-10 md:py-16 bg-gray-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 md:px-6">


        <!-- ====================================================
             BACK
        ==================================================== -->

        <div class="mb-6">

            <a
                href="explore.php"
                class="inline-flex items-center gap-2
                       text-sm font-semibold
                       text-gray-500
                       hover:text-gray-900
                       transition"
            >

                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Back to Marketplace

            </a>

        </div>


        <!-- ====================================================
             ITEM
        ==================================================== -->

        <div class="grid lg:grid-cols-2 gap-8">


            <!-- =================================================
                 LEFT — IMAGE
            ================================================= -->

            <div>

                <div
                    class="bg-white
                           rounded-2xl
                           border
                           shadow-sm
                           overflow-hidden"
                >

                    <!-- MAIN IMAGE -->

                    <div
                        class="relative
                               h-[350px]
                               sm:h-[450px]
                               bg-gray-100
                               overflow-hidden"
                    >

                        <?php if (!empty($images)): ?>

                            <img
                                id="mainImage"
                                src="data:<?= e($images[0]['mime_type']) ?>;base64,<?= base64_encode($images[0]['image_blob']) ?>"
                                alt="<?= e($item['title']) ?>"
                                class="w-full h-full object-cover"
                            >

                        <?php else: ?>

                            <div
                                class="w-full h-full
                                       flex flex-col
                                       items-center
                                       justify-center
                                       text-gray-400"
                            >

                                <svg
                                    class="w-12 h-12 mb-3"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />

                                </svg>

                                <span class="text-sm">
                                    No image available
                                </span>

                            </div>

                        <?php endif; ?>


                        <!-- STATUS -->

                        <span
                            class="absolute
                                   top-4
                                   left-4
                                   px-3
                                   py-1.5
                                   rounded-full
                                   text-xs
                                   font-semibold
                                   <?= $statusClass ?>"
                        >

                            <?= e(ucfirst($status)) ?>

                        </span>


                        <!-- IMAGE COUNT -->

                        <?php if (count($images) > 1): ?>

                            <span
                                class="absolute
                                       top-4
                                       right-4
                                       px-3
                                       py-1.5
                                       rounded-full
                                       bg-black/70
                                       text-white
                                       text-xs
                                       font-semibold"
                            >

                                <span id="imageCounter">
                                    1
                                </span>

                                / <?= count($images) ?>

                            </span>

                        <?php endif; ?>

                    </div>


                    <!-- THUMBNAILS -->

                    <?php if (count($images) > 1): ?>

                        <div
                            class="p-4
                                   border-t
                                   flex
                                   gap-3
                                   overflow-x-auto"
                        >

                            <?php foreach ($images as $index => $img): ?>

                                <button
                                    type="button"
                                    onclick="changeImage(<?= $index ?>)"
                                    class="
                                        image-thumbnail
                                        flex-shrink-0
                                        w-20
                                        h-16
                                        rounded-lg
                                        overflow-hidden
                                        border-2
                                        <?= $index === 0
                                            ? 'border-yellow-500'
                                            : 'border-transparent' ?>
                                    "
                                >

                                    <img
                                        src="data:<?= e($img['mime_type']) ?>;base64,<?= base64_encode($img['image_blob']) ?>"
                                        alt=""
                                        class="w-full h-full object-cover"
                                    >

                                </button>

                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>

                </div>


                <!-- =================================================
                     DESCRIPTION
                ================================================= -->

                <div
                    class="mt-6
                           bg-white
                           rounded-2xl
                           border
                           shadow-sm
                           p-6"
                >

                    <h2 class="text-xl font-bold text-gray-900">
                        Description
                    </h2>

                    <div class="mt-4 text-gray-600 leading-7 text-sm md:text-base">

                        <?php if (!empty($item['description'])): ?>

                            <?= nl2br(e($item['description'])) ?>

                        <?php else: ?>

                            <p class="text-gray-400">
                                No description was provided for this item.
                            </p>

                        <?php endif; ?>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 RIGHT — DETAILS
            ================================================= -->

            <div>

                <div
                    class="bg-white
                           rounded-2xl
                           border
                           shadow-sm
                           p-6 md:p-8"
                >


                    <!-- CATEGORY -->

                    <?php if (!empty($item['category'])): ?>

                        <p
                            class="text-sm
                                   font-semibold
                                   text-yellow-600
                                   uppercase
                                   tracking-wide"
                        >

                            <?= e($item['category']) ?>

                        </p>

                    <?php endif; ?>


                    <!-- TITLE -->

                    <h1
                        class="mt-2
                               text-3xl
                               md:text-4xl
                               font-bold
                               tracking-tight
                               text-gray-900"
                    >

                        <?= e($item['title']) ?>

                    </h1>


                    <!-- LOCATION -->

                    <div
                        class="flex
                               items-center
                               gap-2
                               mt-4
                               text-sm
                               text-gray-500"
                    >

                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 21s7-6.2 7-12a7 7 0 10-14 0c0 5.8 7 12 7 12z"
                            />

                            <circle
                                cx="12"
                                cy="9"
                                r="2"
                            />

                        </svg>

                        <?= e($item['location']) ?>

                    </div>


                    <!-- PRICE -->

                    <div
                        class="mt-6
                               pb-6
                               border-b"
                    >

                        <p class="text-sm text-gray-400">
                            Price
                        </p>

                        <p
                            class="mt-1
                                   text-3xl
                                   font-bold
                                   text-gray-900"
                        >

                            GHS <?= number_format(
                                (float) $item['price'],
                                2
                            ) ?>

                        </p>

                    </div>


                    <!-- =================================================
                         SELLER
                    ================================================= -->

                    <div class="mt-6">

                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">
                            Seller Information
                        </h2>


                        <div
                            class="mt-4
                                   p-4
                                   bg-gray-50
                                   border
                                   rounded-xl"
                        >

                            <div class="flex items-center gap-3">

                                <!-- AVATAR -->

                                <div
                                    class="w-11
                                           h-11
                                           rounded-full
                                           bg-gray-900
                                           text-yellow-400
                                           flex
                                           items-center
                                           justify-center
                                           font-bold"
                                >

                                    <?= e(
                                        strtoupper(
                                            substr(
                                                $item['full_name'] ?: 'S',
                                                0,
                                                1
                                            )
                                        )
                                    ) ?>

                                </div>


                                <!-- NAME -->

                                <div>

                                    <p class="font-semibold text-gray-900">

                                        <?= e(
                                            $item['full_name']
                                                ?: 'Seller'
                                        ) ?>

                                    </p>

                                    <p class="text-xs text-gray-500 mt-0.5">
                                        MarketCircle Seller
                                    </p>

                                </div>

                            </div>


                            <!-- CONTACT INFO -->

                            <div
                                class="mt-4
                                       pt-4
                                       border-t
                                       space-y-2"
                            >

                                <?php if (!empty($item['phone'])): ?>

                                    <div
                                        class="flex
                                               items-center
                                               gap-3
                                               text-sm
                                               text-gray-600"
                                    >

                                        <svg
                                            class="w-4 h-4 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M22 16.92v3a2 2 0 01-2.18 2
                                                   19.79 19.79 0 01-8.63-3.07
                                                   19.5 19.5 0 01-6-6
                                                   A19.79 19.79 0 012.12 4.18
                                                   2 2 0 014.11 2h3a2 2 0 012 1.72
                                                   c.12.9.33 1.78.62 2.63
                                                   a2 2 0 01-.45 2.11L8 9.73
                                                   a16 16 0 006 6l1.27-1.27
                                                   a2 2 0 012.11-.45
                                                   c.85.29 1.73.5 2.63.62
                                                   A2 2 0 0122 16.92z"
                                            />

                                        </svg>

                                        <?= e($item['phone']) ?>

                                    </div>

                                <?php endif; ?>


                                <?php if (!empty($item['email'])): ?>

                                    <div
                                        class="flex
                                               items-center
                                               gap-3
                                               text-sm
                                               text-gray-600
                                               break-all"
                                    >

                                        <svg
                                            class="w-4 h-4 text-gray-400 shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            viewBox="0 0 24 24"
                                        >

                                            <rect
                                                x="3"
                                                y="5"
                                                width="18"
                                                height="14"
                                                rx="2"
                                            />

                                            <path
                                                d="M3 7l9 6 9-6"
                                            />

                                        </svg>

                                        <?= e($item['email']) ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         CONTACT BUTTONS
                    ================================================= -->

                    <?php if (!empty($item['phone'])): ?>

                        <div class="grid grid-cols-2 gap-3 mt-6">

                            <!-- CALL -->

                            <a
                                href="tel:<?= e($item['phone']) ?>"
                                class="
                                    flex
                                    items-center
                                    justify-center
                                    gap-2
                                    bg-gray-900
                                    hover:bg-yellow-500
                                    hover:text-black
                                    text-white
                                    py-3.5
                                    rounded-xl
                                    font-semibold
                                    text-sm
                                    transition
                                "
                            >

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M22 16.92v3a2 2 0 01-2.18 2
                                           19.79 19.79 0 01-8.63-3.07
                                           19.5 19.5 0 01-6-6
                                           A19.79 19.79 0 012.12 4.18
                                           2 2 0 014.11 2h3a2 2 0 012 1.72
                                           c.12.9.33 1.78.62 2.63
                                           a2 2 0 01-.45 2.11L8 9.73
                                           a16 16 0 006 6l1.27-1.27
                                           a2 2 0 012.11-.45
                                           c.85.29 1.73.5 2.63.62
                                           A2 2 0 0122 16.92z"
                                    />

                                </svg>

                                Call

                            </a>


                            <!-- WHATSAPP -->

                            <?php if (!empty($whatsappNumber)): ?>

                                <a
                                    href="https://wa.me/<?= e($whatsappNumber) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="
                                        flex
                                        items-center
                                        justify-center
                                        gap-2
                                        bg-yellow-500
                                        hover:bg-yellow-400
                                        text-black
                                        py-3.5
                                        rounded-xl
                                        font-semibold
                                        text-sm
                                        transition
                                    "
                                >

                                    <svg
                                        class="w-4 h-4"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            d="M20.5 3.5A11.8 11.8 0 0012.05 0
                                               C5.55 0 .26 5.29.26 11.8
                                               c0 2.08.54 4.1 1.57 5.88L.2 24
                                               l6.48-1.6a11.77 11.77 0 005.37
                                               1.29h.01c6.5 0 11.79-5.29
                                               11.79-11.8 0-3.15-1.23-6.11
                                               -3.35-8.39z"
                                        />

                                    </svg>

                                    WhatsApp

                                </a>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>


                    <!-- =================================================
                         SAFETY
                    ================================================= -->

                    <div
                        class="mt-6
                               p-4
                               bg-yellow-50
                               border
                               border-yellow-100
                               rounded-xl"
                    >

                        <div class="flex gap-3">

                            <svg
                                class="w-5 h-5 text-yellow-600 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v4m0 4h.01M10.3 3.3L2.8 16.3
                                       A2 2 0 004.53 19h14.94a2 2 0 001.73-2.7
                                       L13.7 3.3a2 2 0 00-3.4 0z"
                                />

                            </svg>

                            <div>

                                <p class="text-sm font-semibold text-gray-900">
                                    Stay safe
                                </p>

                                <p class="text-xs text-gray-600 mt-1 leading-5">
                                    Inspect the item before making payment
                                    and meet the seller in a safe public place.
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- LISTING ID -->

                    <div
                        class="mt-6
                               pt-5
                               border-t
                               flex
                               items-center
                               justify-between
                               text-xs"
                    >

                        <span class="text-gray-400">
                            Listing ID
                        </span>

                        <span class="font-semibold text-gray-600">
                            #<?= (int) $item['id'] ?>
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ============================================================
     IMAGE GALLERY
============================================================ -->

<script>

const itemImages = <?= json_encode(
    array_map(
        function ($img) {
            return 'data:' .
                $img['mime_type'] .
                ';base64,' .
                base64_encode($img['image_blob']);
        },
        $images
    ),
    JSON_UNESCAPED_SLASHES
) ?>;

let currentImage = 0;


function changeImage(index)
{
    if (!itemImages.length) {
        return;
    }

    currentImage = index;

    document.getElementById('mainImage').src =
        itemImages[index];


    const counter =
        document.getElementById('imageCounter');

    if (counter) {
        counter.textContent = index + 1;
    }


    document
        .querySelectorAll('.image-thumbnail')
        .forEach((thumbnail, thumbnailIndex) => {

            thumbnail.classList.remove(
                'border-yellow-500'
            );

            thumbnail.classList.add(
                'border-transparent'
            );

            if (thumbnailIndex === index) {

                thumbnail.classList.remove(
                    'border-transparent'
                );

                thumbnail.classList.add(
                    'border-yellow-500'
                );
            }

        });
}

</script>


<?php

include './components/footer.php';

?>