<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include './components/head.php'; ?>

<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">

<!-- ================= CARD ================= -->
<div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

<?php if (!empty($_SESSION['error'])): ?>
    <div class="text-red-600">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>
    <!-- TITLE -->
    <h1 class="text-2xl font-bold text-center text-gray-900">
        Verify Your Email
    </h1>

    <p class="text-center text-gray-500 mt-2 text-sm">
        We sent a 6-digit code to your email address
    </p>

    <!-- OTP FORM -->
    <form id="otpForm" class="mt-8 space-y-5">

        <div>
            <label class="text-sm font-medium text-gray-700">Enter OTP</label>

            <input
                type="text"
                name="otp"
                maxlength="6"
                inputmode="numeric"
                placeholder="000000"
                class="mt-2 w-full px-4 py-3 text-center tracking-widest text-lg border rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400"
                required
            >
        </div>

        <!-- SUBMIT -->
        <button
            type="submit"
            id="verifyBtn"
            class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2"
        >
            Verify Account
        </button>

    </form>

    <!-- RESEND -->
    <p class="text-center text-sm text-gray-500 mt-6">
        Didn’t receive code?
        <button class="text-yellow-600 font-medium hover:underline">
            Resend OTP
        </button>
    </p>

</div>

<!-- ================= SCRIPTS ================= -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const form = document.getElementById("otpForm");
const btn = document.getElementById("verifyBtn");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    btn.disabled = true;
    btn.innerText = "Verifying...";

    try {
        const res = await fetch("./services/verify-otp.php", {
            method: "POST",
            body: formData
        });

        const data = await res.json();

        if (data.status === "success") {

            Swal.fire({
                icon: "success",
                title: "Verified!",
                text: data.message,
                confirmButtonColor: "#facc15"
            }).then(() => {
                window.location.href = "login.php";
            });

        } else {

            Swal.fire({
                icon: "error",
                title: "Oops!",
                text: data.message
            });

        }

    } catch (err) {

        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Something went wrong"
        });

    } finally {
        btn.disabled = false;
        btn.innerText = "Verify Account";
    }
});
</script>

</body>
</html>