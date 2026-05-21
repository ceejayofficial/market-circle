<?php if ($totalPages > 1): ?>

<div class="flex justify-center mt-12">

    <div class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm border">

        <!-- PREV -->
        <?php if ($page > 1): ?>
            <a href="?cat=<?= $cat ?>&page=<?= $page - 1 ?>"
               class="px-4 py-2 text-sm rounded-lg hover:bg-gray-100 transition">
                Prev
            </a>
        <?php endif; ?>

        <!-- NUMBERS -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>

            <a href="?cat=<?= $cat ?>&page=<?= $i ?>"
               class="px-4 py-2 text-sm rounded-lg transition font-medium
               <?= $i == $page ? 'bg-yellow-500 text-black' : 'hover:bg-gray-100 text-gray-700' ?>">
                <?= $i ?>
            </a>

        <?php endfor; ?>

        <!-- NEXT -->
        <?php if ($page < $totalPages): ?>
            <a href="?cat=<?= $cat ?>&page=<?= $page + 1 ?>"
               class="px-4 py-2 text-sm rounded-lg hover:bg-gray-100 transition">
                Next
            </a>
        <?php endif; ?>

    </div>

</div>

<?php endif; ?>

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
    animation: fadeInUp 0.6s ease forwards;
}
</style>