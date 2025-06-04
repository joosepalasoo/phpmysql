<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Keelatud");

if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
}

$stmt = $conn->query("
    SELECT b.*, u.email, r.name AS room_name 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN rooms r ON b.room_id = r.id
");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<h2>Broneeringud</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Kasutaja</th><th>Tuba</th><th>Algus</th><th>Lõpp</th><th>Tegevus</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bookings as $b): ?>
        <tr>
            <td><?= htmlspecialchars($b['email']) ?></td>
            <td><?= htmlspecialchars($b['room_name']) ?></td>
            <td><?= htmlspecialchars($b['start_date']) ?></td>
            <td><?= htmlspecialchars($b['end_date']) ?></td>
            <td><a href="?delete=<?= $b['id'] ?>" class="btn btn-danger btn-sm">Kustuta</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
