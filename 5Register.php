<?php
$conn = new mysqli("localhost", "root", "", "Register");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$name = $email = $password = $phone = $gender = $faculty = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    $phone    = trim($_POST["phone"]);
    $gender   = $_POST["gender"] ?? '';
    $faculty  = trim($_POST["faculty"]);

    if (empty($name) || !preg_match("/^[a-zA-Z ]{2,}$/", $name)) $errors['name'] = "Valid name required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Valid email required.";
    if (empty($password) || !preg_match("/^(?=.*[A-Za-z])(?=.*\d).{6,}$/", $password)) $errors['password'] = "Password must be at least 6 characters and contain letters & numbers.";
    if (empty($phone) || !preg_match("/^\d{10,15}$/", $phone)) $errors['phone'] = "Valid phone required.";
    if (empty($gender)) $errors['gender'] = "Select gender.";
    if (empty($faculty) || !preg_match("/^[a-zA-Z\s]+$/", $faculty)) $errors['faculty'] = "Valid faculty required.";

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO registrations (name, email, password, phone, gender, faculty) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $hashedPassword, $phone, $gender, $faculty);
        if ($stmt->execute()) {
            $success = "Registered successfully!";
            $name = $email = $password = $phone = $gender = $faculty = "";
        } else {
            $errors['submit'] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            padding-top: 50px;
        }

        form {
            background: white;
            padding: 25px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 0 10px #aaa;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

        .success {
            color: green;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <form method="POST">
        <h2>Register</h2>
        <?php if (!empty($success)) echo "<div class='success'>$success</div>"; ?>
        <?php if (!empty($errors['submit'])) echo "<div class='error'>{$errors['submit']}</div>"; ?>

        <input type="text" name="name" placeholder="Name" value="<?= htmlspecialchars($name) ?>">
        <div class="error"><?= $errors['name'] ?? '' ?></div>

        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>">
        <div class="error"><?= $errors['email'] ?? '' ?></div>

        <input type="password" name="password" placeholder="Password">
        <div class="error"><?= $errors['password'] ?? '' ?></div>

        <input type="text" name="phone" placeholder="Phone" value="<?= htmlspecialchars($phone) ?>">
        <div class="error"><?= $errors['phone'] ?? '' ?></div>

        <select name="gender">
            <option value="">-- Select Gender --</option>
            <option value="Male" <?= $gender == "Male" ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $gender == "Female" ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= $gender == "Other" ? 'selected' : '' ?>>Other</option>
        </select>
        <div class="error"><?= $errors['gender'] ?? '' ?></div>

        <input type="text" name="faculty" placeholder="Faculty" value="<?= htmlspecialchars($faculty) ?>">
        <div class="error"><?= $errors['faculty'] ?? '' ?></div>

        <button type="submit">Register</button>
    </form>
</body>

</html>