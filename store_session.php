<?php
session_start();

$_SESSION['username'] = 'Nishant Chaudhary';
$_SESSION['email'] = 'nishantchaudhary052@gmail.com';

echo "Session data stored successfully.<br>";
echo "<a href='retrieve_session.php'>Retrieve Session</a>";
?>
