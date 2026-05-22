<!-- logout-confirmation.php -->
<script>
function confirmLogout() {
    Swal.fire({
        title: "Logout?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Logout"
    }).then((r) => {
        if (r.isConfirmed) {
            window.location.href = "../logout.php";
        }
    });
}
</script>