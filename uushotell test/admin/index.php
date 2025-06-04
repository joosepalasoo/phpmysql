<?php
session_start();
require_once '../includes/functions.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Keelatud");

require_once '../includes/header.php';
?>

<h2>Admin Paneel</h2>
<ul>
    <li><a href="rooms.php">Halda tube</a></li>
    <li><a href="bookings.php">Halda broneeringuid</a></li>
    <li><a href="users.php">Halda kasutajaid</a></li>
</ul>

<?php require_once '../includes/footer.php'; ?>
