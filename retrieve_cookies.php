<?php
// Check and display cookies
if (isset($_COOKIE['username']) && isset($_COOKIE['email'])) {
    echo "Username: " . $_COOKIE['username'] . "<br>";
    echo "Email: " . $_COOKIE['email'] . "<br>";
} else {
    echo "No cookies found.<br>";
}

echo "<a href='destroy_cookies.php'>Go to Delete Cookie</a>";
?>
