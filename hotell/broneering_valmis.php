<?php
$kood = htmlspecialchars($_GET['kood'] ?? ''); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Broneering kinnitatud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Broneering kinnitatud!</h2>
    <p>Teie broneeringu kood: <strong><?=$kood?></strong></p>
    <p>Palun salvestage see kood – selle abil saate oma broneeringut hiljem vaadata või tühistada.</p>
    <a href="../index.php" class="btn btn-secondary">Tagasi avalehele</a>
</div>
</body>
</html>
