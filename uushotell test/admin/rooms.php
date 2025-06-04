<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Keelatud");

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $stmt = $conn->prepare("INSERT INTO rooms (name, type, price) VALUES (?, ?, ?)");
    $stmt->execute([$name, $type, $price]);
}

if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
}

$stmt = $conn->query("SELECT * FROM rooms");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<h2>Toad</h2>
<form method="POST" class="row g-3 mb-4">
    <div class="col-md-4">
        <input type="text" name="name" class="form-control" placeholder="Toa nimi" required>
    </div>
    <div class="col-md-3">
        <input type="text" name="type" class="form-control" placeholder="Tüüp" required>
    </div>
    <div class="col-md-3">
        <input type="number" name="price" class="form-control" placeholder="Hind (€)" required>
    </div>
    <div class="col-md-2">
        <button type="submit" name="add" class="btn btn-success">Lisa tuba</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nimi</th><th>Tüüp</th><th>Hind</th><th>Tegevus</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rooms as $room): ?>
        <tr>
            <td><?= htmlspecialchars($room['name']) ?></td>
            <td><?= htmlspecialchars($room['type']) ?></td>
            <td>€<?= htmlspecialchars($room['price']) ?></td>
            <td><a href="?delete=<?= $room['id'] ?>" class="btn btn-danger btn-sm">Kustuta</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
