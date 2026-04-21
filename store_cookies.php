<?php
// Set cookies valid for 1 hour
setcookie("username", "Nishant Chaudhary", time() + 3600, "/");
setcookie("email", "nishantchaudhary052@gmail.com", time() + 3600, "/");

echo "Cookies have been set successfully.<br>";
echo "<a href='retrieve_cookies.php'>Go to Get Cookie</a>";
?>
