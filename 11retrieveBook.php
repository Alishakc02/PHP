<?php
$conn = new mysqli("localhost", "root", "", "library");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM books");

echo "<h2>Books List</h2><table border='1'>";
echo "<tr><th>ID</th><th>Title</th><th>Publisher</th><th>Author</th><th>
Edition</th><th>Pages</th><th>Price</th><th>Date</th><th>ISBN</th><th>
Action</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    foreach ($row as $field) {
        echo "<td>" . htmlspecialchars($field) . "</td>";
    }
    // Edit and Delete links
    echo "<td><a href='12modifyBook.php?id=" . $row['id'] . "'>Edit</a>
| <a href='13removeBook.php?id=" . $row['id'] . "'>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
