<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$page = $_GET['page'] ?? 'overview';

// $allowedPages = ['overview','my-items','post-item','profile','settings'];

$allowedPages = [
    'overview',
    'my-items',
    'post-item',
    'view-item',
    'edit-item',
    'profile',
    'settings'
];

if (!in_array($page, $allowedPages)) {
    $page = 'overview';
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../components/head.php'; ?>

<body class="bg-white overflow-x-hidden">


<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <?php include './components/sidebar.php'; ?>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- TOPBAR -->
        <?php include './components/topbar.php'; ?>

        <!-- CONTENT -->
        <main class="p-4 md:p-6 lg:p-8">

            <?php include __DIR__ . "/{$page}.php"; ?>

        </main>

    </div>

</div>

<!-- MOBILE OVERLAY BACKDROP -->
<div id="overlay"
     class="fixed inset-0 bg-black/40 hidden z-40 lg:hidden">
</div>

<script src="../assets/js/sidebar.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmLogout() {

    Swal.fire({
        title: "Logout?",
        text: "Are you sure you want to exit your dashboard?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "#d1d5db",
        confirmButtonText: "Yes, Logout",
        cancelButtonText: "Cancel",
        background: "#fff",
        customClass: {
            popup: "rounded-2xl"
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../logout.php";
        }
    });

}
</script>
<?php include "./components/logout-confimation.php"; ?>
</body>
</html>