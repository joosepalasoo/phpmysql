<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
redirectIfNotLoggedIn();
if (!isAdmin()) die("Keelatud");

$users = $conn->query("SELECT * FROM users")->fetchAll();

require_once '../includes/header.php';
?>

<h2>Kasutajad</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Email</th><th>Isikukood</th><th>Roll</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['isikukood']) ?></td>
            <td><?= htmlspecialchars($u['role']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
