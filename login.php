
<?php
session_start();

/*
|--------------------------------------------------------------------------
| SECURITY HEADERS
|--------------------------------------------------------------------------
*/
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
header("X-XSS-Protection: 1; mode=block");

/*
|--------------------------------------------------------------------------
| CSRF TOKEN
|--------------------------------------------------------------------------
*/
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include './components/head.php'; ?>
<?php
include './components/preloader.php';

?>
<body class="bg-gray-50 min-h-screen overflow-hidden">

<!-- ================= MAIN WRAPPER ================= -->
<div class="min-h-screen grid lg:grid-cols-2">

    <!-- ================= LEFT SIDE ================= -->
    <div class="relative hidden lg:flex items-center justify-center overflow-hidden bg-black">

        <!-- BACKGROUND IMAGE -->
        <img
            src="./assets/images/auth-marketplace.jpg"
            alt="Marketplace"
            class="absolute inset-0 w-full h-full object-cover opacity-40"
        >

        <!-- DARK OVERLAY -->
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- CONTENT -->
        <div class="relative z-10 max-w-lg px-10 text-white">

            <!-- LOGO -->
            <div class="flex items-center gap-3 mb-10">

                <div class="w-12 h-12 rounded-2xl bg-yellow-500 flex items-center justify-center shadow-lg">

                    <!-- SHOP ICON -->
                    <svg class="w-6 h-6 text-black"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3 9l1-5h16l1 5M5 9h14v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9z"/>

                    </svg>

                </div>

                <h1 class="text-3xl font-bold tracking-tight">
                    Market<span class="text-yellow-400">Circle</span>
                </h1>

            </div>

            <!-- TEXT -->
            <h2 class="text-5xl font-bold leading-tight">
                Buy & Sell Safely Across Ghana
            </h2>

            <p class="mt-6 text-gray-300 text-lg leading-relaxed">
                Join thousands of trusted buyers and verified sellers
                on Ghana’s modern digital marketplace.
            </p>

            <!-- FEATURES -->
            <div class="mt-10 space-y-5">

                <!-- FEATURE -->
                <div class="flex items-center gap-4">

                    <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur">

                        <svg class="w-5 h-5 text-yellow-400"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"/>

                        </svg>

                    </div>

                    <div>
                        <h3 class="font-semibold">Verified Sellers</h3>
                        <p class="text-sm text-gray-400">
                            Trusted accounts & secure marketplace
                        </p>
                    </div>

                </div>

                <!-- FEATURE -->
                <div class="flex items-center gap-4">

                    <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur">

                        <svg class="w-5 h-5 text-yellow-400"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 11c0-1.657 2-3 2-3s2 1.343 2 3-2 3-2 3-2-1.343-2-3z"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 21c4.97 0 9-3.582 9-8s-4.03-8-9-8-9 3.582-9 8 4.03 8 9 8z"/>

                        </svg>

                    </div>

                    <div>
                        <h3 class="font-semibold">Safe Transactions</h3>
                        <p class="text-sm text-gray-400">
                            Secure buying & selling experience
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ================= RIGHT SIDE ================= -->
    <div class="flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-md">

            <!-- MOBILE LOGO -->
            <div class="flex items-center justify-center gap-3 lg:hidden mb-8">

                <div class="w-11 h-11 rounded-2xl bg-yellow-500 flex items-center justify-center">

                    <svg class="w-5 h-5 text-black"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3 9l1-5h16l1 5M5 9h14v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9z"/>

                    </svg>

                </div>

                <h1 class="text-2xl font-bold">
                    Market<span class="text-yellow-500">Circle</span>
                </h1>

            </div>

            <!-- LOGIN CARD -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-10">

                <div class="text-center">

                    <h2 class="text-3xl font-bold text-gray-900">
                        Welcome Back
                    </h2>

                    <p class="text-gray-500 mt-3 leading-relaxed">
                        Sign in securely to continue to your marketplace account
                    </p>

                </div>

                <!-- FORM -->
          <form method="POST" action="./services/login-verify.php" class="mt-8 space-y-5">

    <!-- CSRF -->
    <input type="hidden"
           name="csrf_token"
           value="<?= $_SESSION['csrf_token']; ?>">

    <!-- EMAIL -->
    <div>
        <label class="text-sm text-gray-700">Email Address</label>
        <input type="email"
               name="email"
               required
               class="w-full mt-2 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
    </div>

    <!-- PASSWORD -->
    <div>
        <label class="text-sm text-gray-700">Password</label>
        <input type="password"
               name="password"
               required
               class="w-full mt-2 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none">
    </div>

    <!-- SUBMIT -->
    <button type="submit"
            class="w-full py-4 rounded-2xl bg-yellow-500 hover:bg-yellow-600 text-black font-semibold transition">

        Sign In

    </button>

</form>
                <!-- TRUST -->
                <div class="mt-8">

                    <div class="flex items-center justify-center gap-2 text-sm text-gray-400">

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                        </svg>

                        Secure Google Authentication

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
```
