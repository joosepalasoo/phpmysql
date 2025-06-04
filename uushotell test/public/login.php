<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($remember) {
            setcookie('user_id', $user['id'], time() + 14400, "/");
        }
        header("Location: index.php");
        exit();
    } else {
        $error = "Vale kasutaja või parool";
    }
}
?>

<h2>Logi sisse</h2>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" novalidate>
    <div class="mb-3">
        <label class="form-label">E-post</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Parool</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="remember" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Mäleta mind (4h)</label>
    </div>
    <button type="submit" class="btn btn-primary">Logi sisse</button>
</form>

<?php require_once '../includes/footer.php'; ?>
