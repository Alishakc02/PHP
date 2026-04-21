<?php
// Set cookies with past expiration time to delete them
setcookie("username", "", time() - 3600, "/");
setcookie("email", "", time() - 3600, "/");

echo "Cookies have been deleted.<br>";
echo "<a href='store_cookies.php'>Set Cookie Again</a>";
?>
