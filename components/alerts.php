
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (!empty($_SESSION['error'])): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: <?= json_encode($_SESSION['error']); ?>,
    confirmButtonColor: '#facc15'
});
</script>
<?php unset($_SESSION['error']); endif; ?>


<?php if (!empty($_SESSION['success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: <?= json_encode($_SESSION['success']); ?>,
    confirmButtonColor: '#facc15'
});
</script>
<?php unset($_SESSION['success']); endif; ?>