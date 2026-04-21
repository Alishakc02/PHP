<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    if (!file_exists('users.txt')) {
        file_put_contents('users.txt', '');
    }

    $users = file('users.txt', FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($existingUser,) = explode('|', $user);
        if ($existingUser === $username) {
            echo "Username already exists.";
            exit;
        }
    }

    file_put_contents('users.txt', "$username|$password\n", FILE_APPEND);
    echo "Registration successful. <a href='login.php'>Login here</a>";
    exit;
}
?>

<h2>Register</h2>
<form method="POST">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
