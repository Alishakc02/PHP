<?php
$conn = new mysqli("localhost", "root", "", "library"); // Update user/pass if needed

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO books (title, publisher, author, edition, no_of_page, price, publish_date, isbn) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssidsd",
        $_POST['title'],
        $_POST['publisher'],
        $_POST['author'],
        $_POST['edition'],
        $_POST['no_of_page'],
        $_POST['price'],
        $_POST['publish_date'],
        $_POST['isbn']
    );

    if ($stmt->execute()) {
        echo "Book saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<h2>Add Book</h2>
<form method="POST">
    Title: <input name="title" required><br>
    Publisher: <input name="publisher" required><br>
    Author: <input name="author" required><br>
    Edition: <input name="edition" required><br>
    Pages: <input name="no_of_page" type="number" required><br>
    Price: <input name="price" type="number" step="0.01" required><br>
    Publish Date: <input name="publish_date" type="date" required><br>
    ISBN: <input name="isbn" required><br>
    <button type="submit">Add Book</button>
</form>
