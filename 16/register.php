<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "user_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    $photo = $_FILES['photo'];
    $photo_name = $photo['name'];
    $photo_tmp_name = $photo['tmp_name'];
    $photo_error = $photo['error'];

    // Check if there were any errors with the file upload
    if ($photo_error === 0) {
        // Define file upload directory and allowed file extensions
        $upload_dir = 'uploads/';
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Get the file extension of the uploaded file
        $file_extension = pathinfo($photo_name, PATHINFO_EXTENSION);

        // Validate file extension
        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            // Generate a unique name for the file to avoid overwriting
            $new_file_name = uniqid('', true) . '.' . $file_extension;
            $file_destination = $upload_dir . $new_file_name;

            // Move the uploaded file to the desired location
            if (move_uploaded_file($photo_tmp_name, $file_destination)) {
                // Insert user data into the database
                $stmt = $conn->prepare("INSERT INTO users (name, email, password, photo) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $email, $hashed_password, $file_destination);

                if ($stmt->execute()) {
                    echo "User registered successfully!";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type. Only jpg, jpeg, png, and gif are allowed.";
        }
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>
