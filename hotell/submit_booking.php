<?php
include 'config.php';

function genereeriKood($pikkus = 5) {
    $tähed = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle(str_repeat($tähed, $pikkus)), 0, $pikkus);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eesnimi = $_POST['eesnimi'];
    $perenimi = $_POST['perenimi'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $ruum_id = (int)$_POST['ruum_id'];
    $saabumine = $_POST['saabumise_kuupaev'];
    $lahkumine = $_POST['lahkumise_kuupaev'];
    $isikukood = $_POST['isikukood'];

    $broneeringukood = genereeriKood();

    // 1. Lisa külaline
    $stmt = $yhendus->prepare("INSERT INTO kylastajad (eesnimi, perenimi, email, telefon, isikukood) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("SQL viga külalase lisamisel: " . $yhendus->error);
    }
    $stmt->bind_param("sssss", $eesnimi, $perenimi, $email, $telefon, $isikukood);
    if (!$stmt->execute()) {
        die("Külalase lisamine ebaõnnestus: " . $stmt->error);
    }
    $kylastaja_id = $stmt->insert_id;
    $stmt->close();

    // 2. Lisa broneering
    $stmt2 = $yhendus->prepare("INSERT INTO broneeringud (kylastaja_id, ruum_id, saabumise_kuupaev, lahkumise_kuupaev, staatus, kood) VALUES (?, ?, ?, ?, 'aktiivne', ?)");
    if (!$stmt2) {
        die("SQL viga broneeringu lisamisel: " . $yhendus->error);
    }
    $stmt2->bind_param("iisss", $kylastaja_id, $ruum_id, $saabumine, $lahkumine, $broneeringukood);
    if (!$stmt2->execute()) {
        die("Broneeringu lisamine ebaõnnestus: " . $stmt2->error);
    }
    $stmt2->close();

    // 3. Muuda ruumi olek "broneeritud"
    $stmt3 = $yhendus->prepare("UPDATE ruumid SET olek = 'broneeritud' WHERE id = ?");
    if (!$stmt3) {
        die("SQL viga ruumi oleku muutmisel: " . $yhendus->error);
    }
    $stmt3->bind_param("i", $ruum_id);
    if (!$stmt3->execute()) {
        die("Ruumide oleku muutmine ebaõnnestus: " . $stmt3->error);
    }
    $stmt3->close();

} else {
    die('Broneeringut saab teha vaid POST meetodiga.');
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Broneering valmiskinnitus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Broneering edukalt tehtud!</h2>
    <p>Teie broneeringu kood on:</p>
    <h3 class="text-primary"><?=htmlspecialchars($broneeringukood)?></h3>
    <p>Palun hoidke seda koodi, et vajadusel broneeringut kontrollida või muuta.</p>
    <a href="/phpmysql/phpmysql/hotell/index.php" class="btn btn-secondary mt-3">Tagasi avalehele</a>
</div>
</body>
</html>
