<?php
session_start();

// Restore from cookie
if (!isset($_SESSION['user']) && isset($_COOKIE['remember'])) {
    $_SESSION['user'] = $_COOKIE['remember'];
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<h2>Welcome to Dashboard, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
<p>This page is protected. Only logged-in users can access it.</p>
<a href="logout.php">Logout</a>
