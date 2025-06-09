<?php
session_start();
include 'config.php';

if (isset($_SESSION['kasutaja_id']) && $_SESSION['roll'] === 'admin') {
    header('Location: admin.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kasutajanimi = $_POST['kasutajanimi'] ?? '';
    $parool = $_POST['parool'] ?? '';

    $stmt = $yhendus->prepare("SELECT * FROM kasutajad WHERE kasutajanimi = ?");
    $stmt->bind_param("s", $kasutajanimi);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $kasutaja = $result->fetch_assoc();
        if (password_verify($parool, $kasutaja['parool']) && $kasutaja['roll'] === 'admin') {
            // Määra sessioon ja mäleta mind cookie (4h)
            $_SESSION['kasutaja_id'] = $kasutaja['id'];
            $_SESSION['kasutajanimi'] = $kasutaja['kasutajanimi'];
            $_SESSION['roll'] = $kasutaja['roll'];
            $_SESSION['login_time'] = time();

            if (isset($_POST['remember'])) {
                setcookie('kasutaja_id', $kasutaja['id'], time() + 14400, "/"); // 4 tundi
                setcookie('kasutajanimi', $kasutaja['kasutajanimi'], time() + 14400, "/");
                setcookie('roll', $kasutaja['roll'], time() + 14400, "/");
            }

            header('Location: admin.php');
            exit;
        } else {
            $error = 'Vale kasutajanimi või parool.';
        }
    } else {
        $error = 'Vale kasutajanimi või parool.';
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8" />
    <title>Admin login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">
<div class="container" style="max-width: 400px;">
    <h2>Admin login</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label for="kasutajanimi" class="form-label">Kasutajanimi</label>
            <input type="text" name="kasutajanimi" id="kasutajanimi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="parool" class="form-label">Parool</label>
            <input type="password" name="parool" id="parool" class="form-control" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input">
            <label for="remember" class="form-check-label">Mäleta mind (4 tundi)</label>
        </div>
        <button type="submit" class="btn btn-primary">Logi sisse</button>
    </form>
    <button type="button" class="btn btn-secondary mt-3" onclick="window.location.href='index.php'">Avalehele tagasi</button>
</div>
</body>
</html>
