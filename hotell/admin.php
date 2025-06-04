<?php
include 'db.php';

// Tühista broneering (vajutades vormi nuppu)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_id'])) {
    $cancel_id = (int) $_POST['cancel_id'];
    $mysqli->query("DELETE FROM bookings WHERE id = $cancel_id");
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Admin – Broneeringute haldus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1 class="mb-4">Administraatori vaade – Kõik broneeringud</h1>
    <a href="index.php" class="btn btn-secondary mb-3">← Tagasi avalehele</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Külastaja</th>
                <th>Isikukood</th>
                <th>Tuba</th>
                <th>Algus</th>
                <th>Lõpp</th>
                <th>Tegevus</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $mysqli->query("
            SELECT b.id as booking_id, b.start_date, b.end_date, 
                   r.room_number,
                   v.first_name, v.last_name, v.personal_id
            FROM bookings b
            JOIN rooms r ON b.room_id = r.id
            JOIN visitors v ON b.visitor_id = v.id
            ORDER BY b.start_date DESC
        ");
        while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['personal_id']) ?></td>
                <td><?= htmlspecialchars($row['room_number']) ?></td>
                <td><?= htmlspecialchars($row['start_date']) ?></td>
                <td><?= htmlspecialchars($row['end_date']) ?></td>
                <td>
                    <form method="post" onsubmit="return confirm('Oled kindel, et soovid broneeringu tühistada?');">
                        <input type="hidden" name="cancel_id" value="<?= $row['booking_id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Tühista</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
