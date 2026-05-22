<?php
session_start();

/*
|--------------------------------------------------------------------------
| DESTROY ALL SESSION DATA
|--------------------------------------------------------------------------
*/

// Unset all session variables
$_SESSION = [];

// Destroy session cookie if exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy session
session_destroy();

/*
|--------------------------------------------------------------------------
| PREVENT CACHE (IMPORTANT FOR SECURITY)
|--------------------------------------------------------------------------
*/
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/*
|--------------------------------------------------------------------------
| REDIRECT TO LOGIN
|--------------------------------------------------------------------------
*/
header("Location: login.php");
exit;