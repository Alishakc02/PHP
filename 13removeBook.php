<?php
$conn = new mysqli("localhost", "root", "", "library");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Query to check if the book exists
    $result = $conn->query("SELECT * FROM books WHERE id = $book_id");

    if ($result->num_rows > 0) {
        // Prepare and execute the DELETE query
        $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $book_id);

        if ($stmt->execute()) {
            echo "Book deleted successfully.";
            // Redirect to the books list after deletion
            header("Location: 11retrieveBook.php");
            exit;
        } else {
            echo "Error deleting book: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Book not found.";
    }
} else {
    echo "Book ID not provided.";
}

$conn->close();
?>
