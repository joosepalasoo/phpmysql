<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
redirectIfNotLoggedIn();
require_once '../includes/header.php';

$room_id = $_GET['room_id'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];

    if (strtotime($start) < strtotime(date('Y-m-d'))) {
        $error = "Minevikukuupäev ei ole lubatud.";
    } elseif (strtotime($start) >= strtotime($end)) {
        $error = "Alguskuupäev peab olema enne lõppu.";
    } else {
        $check = $conn->prepare("SELECT * FROM bookings WHERE room_id = ? AND NOT (end_date < ? OR start_date > ?)");
        $check->execute([$room_id, $start, $end]);
        if ($check->rowCount() > 0) {
            $error = "Tuba on sel perioodil juba broneeritud.";
        } else {
            $insert = $conn->prepare("INSERT INTO bookings (user_id, room_id, start_date, end_date) VALUES (?, ?, ?, ?)");
            $insert->execute([$_SESSION['user_id'], $room_id, $start, $end]);
            $success = "Broneering lisatud!";
        }
    }
}
?>

<h2>Broneeri tuba</h2>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php elseif ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Alguskuupäev</label>
        <input type="date" name="start_date" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Lõppkuupäev</label>
        <input type="date" name="end_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Broneeri</button>
</form>

<?php require_once '../includes/footer.php'; ?>
