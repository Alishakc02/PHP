<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $remember = isset($_POST['remember']);

    $users = file('users.txt', FILE_IGNORE_NEW_LINES);

    foreach ($users as $user) {
        list($storedUser, $storedHash) = explode('|', $user);
        if ($storedUser === $username && password_verify($password, $storedHash)) {
            $_SESSION['user'] = $username;
            if ($remember) {
                setcookie('remember', $username, time() + 3600, '/');
            }
            header("Location: dashboard.php");
            exit;
        }
    }

    echo "Invalid credentials.";
}
?>

<h2>Login</h2>
<form method="POST">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <label><input type="checkbox" name="remember"> Remember Me</label><br>
    <button type="submit">Login</button>
</form>
