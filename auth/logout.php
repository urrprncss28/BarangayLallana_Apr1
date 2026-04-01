<?php
// 1. START THE SESSION
session_start();

// 2. UNSET ALL SESSION VARIABLES
$_SESSION = array();

// 3. DESTROY THE SESSION COOKIE (Optional but Recommended)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. DESTROY THE SESSION
session_destroy();

// 5. REDIRECT TO LOGIN PAGE
header("Location: login.php");
exit();
?>