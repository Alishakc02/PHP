<?php
$conn = new mysqli("localhost", "root", "", "library");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve book details by ID
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM books WHERE id = $book_id");

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        die("Book not found.");
    }

    // Handle form submission (update the book)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $conn->prepare("UPDATE books SET title = ?, publisher = ?, author = ?, edition = ?, no_of_page = ?, price = ?, publish_date = ?, isbn = ? WHERE id = ?");
        $stmt->bind_param(
            "ssssidsdi",
            $_POST['title'],
            $_POST['publisher'],
            $_POST['author'],
            $_POST['edition'],
            $_POST['no_of_page'],
            $_POST['price'],
            $_POST['publish_date'],
            $_POST['isbn'],
            $book_id
        );

        if ($stmt->execute()) {
            echo "Book updated successfully.";
            // Optionally, redirect to the view page after successful update
            header("Location: 11retrieveBook.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    die("Book ID not provided.");
}

?>

<h2>Edit Book</h2>
<form method="POST">
    Title: <input name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required><br>
    Publisher: <input name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>" required><br>
    Author: <input name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required><br>
    Edition: <input name="edition" value="<?php echo htmlspecialchars($book['edition']); ?>" required><br>
    Pages: <input name="no_of_page" type="number" value="<?php echo htmlspecialchars($book['no_of_page']); ?>" required><br>
    Price: <input name="price" type="number" step="0.01" value="<?php echo htmlspecialchars($book['price']); ?>" required><br>
    Publish Date: <input name="publish_date" type="date" value="<?php echo htmlspecialchars($book['publish_date']); ?>" required><br>
    ISBN: <input name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" required><br>
    <button type="submit">Update Book</button>
</form>
