<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

$stmt = $conn->query("SELECT * FROM rooms WHERE id NOT IN (
    SELECT room_id FROM bookings 
    WHERE CURDATE() BETWEEN start_date AND end_date
)");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Vabad toad</h2>

<div class="row">
    <?php foreach ($rooms as $room): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($room['name']) ?></h5>
                    <p class="card-text">Tüüp: <?= htmlspecialchars($room['type']) ?></p>
                    <p class="card-text">Hind: €<?= htmlspecialchars($room['price']) ?>/öö</p>
                    <?php if (isLoggedIn()): ?>
                        <a href="book.php?room_id=<?= $room['id'] ?>" class="btn btn-primary">Broneeri</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-secondary">Logi sisse broneerimiseks</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once '../includes/footer.php'; ?>
