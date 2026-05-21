<?php if ($totalPages > 1): ?>

<div class="flex justify-center mt-12 px-4">

    <!-- WRAPPER -->
    <div class="w-full max-w-full overflow-x-auto">

        <div class="flex items-center justify-center gap-2 bg-white p-2 rounded-xl shadow-sm border min-w-max mx-auto">

            <!-- PREV -->
            <?php if ($page > 1): ?>
                <a href="?cat=<?= $cat ?>&page=<?= $page - 1 ?>"
                   class="px-3 md:px-4 py-2 text-sm rounded-lg hover:bg-gray-100 transition whitespace-nowrap">
                    Prev
                </a>
            <?php endif; ?>

            <!-- FIRST PAGE (mobile safe shortcut) -->
            <?php if ($page > 3): ?>
                <a href="?cat=<?= $cat ?>&page=1"
                   class="px-3 py-2 text-sm rounded-lg hover:bg-gray-100">
                    1
                </a>

                <span class="px-2 text-gray-400">...</span>
            <?php endif; ?>

            <!-- NUMBERS -->
            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>

                <a href="?cat=<?= $cat ?>&page=<?= $i ?>"
                   class="px-3 md:px-4 py-2 text-sm rounded-lg transition font-medium whitespace-nowrap
                   <?= $i == $page ? 'bg-yellow-500 text-black shadow' : 'hover:bg-gray-100 text-gray-700' ?>">
                    <?= $i ?>
                </a>

            <?php endfor; ?>

            <!-- LAST PAGE -->
            <?php if ($page < $totalPages - 2): ?>
                <span class="px-2 text-gray-400">...</span>

                <a href="?cat=<?= $cat ?>&page=<?= $totalPages ?>"
                   class="px-3 py-2 text-sm rounded-lg hover:bg-gray-100">
                    <?= $totalPages ?>
                </a>
            <?php endif; ?>

            <!-- NEXT -->
            <?php if ($page < $totalPages): ?>
                <a href="?cat=<?= $cat ?>&page=<?= $page + 1 ?>"
                   class="px-3 md:px-4 py-2 text-sm rounded-lg hover:bg-gray-100 transition whitespace-nowrap">
                    Next
                </a>
            <?php endif; ?>

        </div>

    </div>

</div>

<?php endif; ?>