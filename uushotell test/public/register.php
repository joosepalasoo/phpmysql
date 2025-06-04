<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $isikukood = $_POST['isikukood'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "E-posti vorming vale.";
    } elseif (!preg_match("/^\d{11}$/", $isikukood)) {
        $error = "Isikukood peab olema 11 numbrit.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, isikukood, password, role) VALUES (?, ?, ?, 'visitor')");
        $stmt->execute([$email, $isikukood, $password]);
        header("Location: login.php");
        exit();
    }
}
?>

<h2>Registreeru</h2>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" novalidate>
    <div class="mb-3">
        <label class="form-label">E-post</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Isikukood</label>
        <input type="text" name="isikukood" class="form-control" pattern="\d{11}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Parool</label>
        <input type="password" name="password" class="form-control" required minlength="6">
    </div>
    <button type="submit" class="btn btn-primary">Registreeri</button>
</form>

<?php require_once '../includes/footer.php'; ?>
