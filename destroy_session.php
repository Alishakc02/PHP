<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

echo "Session destroyed successfully.<br>";
echo "<a href='store_session.php'>Start New Session</a>";
?>
