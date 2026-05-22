<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include './components/head.php'; ?>

<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">

<!-- CARD -->
<div class="w-full max-w-md bg-white rounded-2xl border border-gray-100 p-8">

    <!-- TITLE -->
    <h1 class="text-2xl font-bold text-center text-gray-900">
        Verify Your Email
    </h1>

    <p class="text-center text-gray-500 mt-2 text-sm">
        We sent a 6-digit verification code to your email
    </p>

    <!-- OTP FORM -->
    <form
        action="./services/verify-otp.php"
        method="POST"
        class="mt-8 space-y-5"
    >

        <!-- OTP -->
        <div>

            <label class="text-sm font-medium text-gray-700">
                Enter OTP Code
            </label>

            <input
                type="text"
                name="otp"
                maxlength="6"
                inputmode="numeric"
                placeholder="000000"
                required
                class="mt-2 w-full px-4 py-3 text-center tracking-[10px] text-lg border rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400"
            >

        </div>

        <!-- SUBMIT -->
        <button
            type="submit"
            class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 rounded-xl transition"
        >
            Verify Account
        </button>

    </form>

    <!-- RESEND -->
    <div class="text-center mt-6">

        <p class="text-sm text-gray-500">
            Didn’t receive the code?
        </p>

        <a
            href="./services/resend-otp.php"
            class="text-sm text-yellow-600 font-medium hover:underline"
        >
            Resend OTP
        </a>

    </div>

</div>

<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (!empty($_SESSION['error'])): ?>

<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: '<?= $_SESSION['error']; ?>',
    confirmButtonColor: '#facc15'
});
</script>

<?php unset($_SESSION['error']); endif; ?>

<?php if (!empty($_SESSION['success'])): ?>

<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '<?= $_SESSION['success']; ?>',
    confirmButtonColor: '#facc15'
}).then(() => {
    window.location.href = "login.php";
});
</script>

<?php unset($_SESSION['success']); endif; ?>

</body>
</html>