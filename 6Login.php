<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Register");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$email = $password = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Enter a valid email.";
    if (empty($password)) $errors['password'] = "Password is required.";

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, name, password FROM registrations WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $name, $hashedPassword);
            $stmt->fetch();
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                header("Location: 56dashboard.php"); // or any welcome page
                exit;
            } else {
                $errors['login'] = "Incorrect password.";
            }
        } else {
            $errors['login'] = "Email not found.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!-- HTML Login Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            padding-top: 60px;
        }

        form {
            background: white;
            padding: 25px;
            width: 350px;
            border-radius: 8px;
            box-shadow: 0 0 10px #aaa;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <form method="POST">
        <h2>Login</h2>
        <?php if (!empty($errors['login'])) echo "<div class='error'>{$errors['login']}</div>"; ?>

        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>">
        <div class="error"><?= $errors['email'] ?? '' ?></div>

        <input type="password" name="password" placeholder="Password">
        <div class="error"><?= $errors['password'] ?? '' ?></div>

        <button type="submit">Login</button>
    </form>
</body>

</html>