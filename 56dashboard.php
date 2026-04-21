<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: 6Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
    <a href="#">Logout</a>
</body>
</html>

