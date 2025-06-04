<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Hotell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/public/index.php">Hotell</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <li class="nav-item"><a class="nav-link" href="/admin/index.php">Admin</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="/public/logout.php">Logi välja</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/public/login.php">Logi sisse</a></li>
                    <li class="nav-item"><a class="nav-link" href="/public/register.php">Registreeru</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
