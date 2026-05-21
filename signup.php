<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include './components/head.php'; ?>

<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4 py-10">

<!-- BACKGROUND -->
<div class="absolute top-10 left-10 w-72 h-72 bg-yellow-400/10 blur-3xl rounded-full"></div>
<div class="absolute bottom-10 right-10 w-72 h-72 bg-black/5 blur-3xl rounded-full"></div>

<!-- CARD -->
<div class="relative w-full max-w-2xl">

    <div class="bg-white border border-gray-100 rounded-2xl p-6 md:p-10">

        <!-- ALERTS -->
        <?php include './components/alerts.php'; ?>

        <!-- HEADER -->
        <div class="text-center mb-8">

            <div class="w-12 h-12 mx-auto bg-yellow-400 flex items-center justify-center rounded-xl mb-4">
                <span class="font-bold text-black">MC</span>
            </div>

            <h1 class="text-3xl font-bold text-gray-900">Create Account</h1>
            <p class="text-gray-500 mt-2">Join MarketCircle today</p>

        </div>

        <!-- FORM -->
        <form action="./services/register-handler.php" method="POST" class="space-y-5">

            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <!-- FULL NAME -->
            <div>
                <label class="text-sm text-gray-700">Full Name</label>
                <input type="text" name="full_name" required
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
            </div>

            <!-- EMAIL + PHONE -->
            <div class="grid md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm text-gray-700">Email Address</label>
                    <input type="email" name="email" required
                           class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
                </div>

                <div>
                    <label class="text-sm text-gray-700">Phone Number</label>
                    <input type="tel" name="phone" required
                           class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
                </div>

            </div>

            <!-- GENDER + LOCATION -->
            <div class="grid md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm text-gray-700">Gender</label>
                    <select name="gender" required
                            class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
                        <option value="">Select Gender</option>
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-700">Location</label>
                    <input type="text" name="location" required
                           class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
                </div>

            </div>

            <!-- GPS -->
            <div>
                <label class="text-sm text-gray-700">GPS Address (Optional)</label>
                <input type="text" name="gps_address"
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
            </div>

            <!-- GHANA CARD -->
            <div>
                <label class="text-sm text-gray-700">Ghana Card Number</label>
                <input type="text" name="ghana_card" required
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="text-sm text-gray-700">Password</label>
                <input type="password" name="password" required
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
            </div>

            <!-- TERMS -->
            <div class="flex items-start gap-2 text-sm text-gray-600">
                <input type="checkbox" required class="mt-1">
                <p>I agree to MarketCircle Terms & Privacy Policy</p>
            </div>

            <!-- BUTTON -->
            <button type="submit"
                    class="w-full py-3 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-black font-semibold transition">
                Create Account
            </button>

        </form>

    </div>

</div>

</body>
</html>