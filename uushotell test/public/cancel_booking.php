<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

$id = $_GET['id'] ?? 0;
$check = $conn->prepare("SELECT * FROM bookings WHERE id = ? AND user_id = ?");
$check->execute([$id, $_SESSION['user_id']]);
$booking = $check->fetch();

if ($booking && strtotime($booking['start_date']) > strtotime('+3 days')) {
    $del = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $del->execute([$id]);
}
header("Location: index.php");
exit();
