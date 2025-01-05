<?php
session_start();
unset($_SESSION['Email']);
unset($_SESSION['Password']);
session_destroy();

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

header('Location: loginpage.php');
exit;
?>