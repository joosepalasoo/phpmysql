<?php
include 'config.php';

$info = null;
$broneering_id = null;
$errors = [];
$success = null;

// Kui broneeringu kood on postitatud, otsi broneering
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kood']) && !isset($_POST['muuda']) && !isset($_POST['kustuta'])) {
    $kood = mysqli_real_escape_string($yhendus, $_POST['kood']);

    $query = "
        SELECT b.id, b.saabumise_kuupaev, b.lahkumise_kuupaev, b.staatus, 
               r.ruumi_nr, r.tyyp, r.hind
        FROM broneeringud b
        JOIN ruumid r ON b.ruum_id = r.id
        WHERE b.kood = '$kood'
        LIMIT 1
    ";

    $result = mysqli_query($yhendus, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $info = mysqli_fetch_assoc($result);
        $broneering_id = $info['id'];
    } else {
        $info = 'Broneeringut selle koodiga ei leitud.';
    }
}

// Kui muuda vorm saadetud
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['muuda'])) {
    $broneering_id = (int)$_POST['broneering_id'];
    $saabumise_kuupaev = mysqli_real_escape_string($yhendus, $_POST['saabumise_kuupaev']);
    $lahkumise_kuupaev = mysqli_real_escape_string($yhendus, $_POST['lahkumise_kuupaev']);

    // Lihtne kuupäeva kontroll
    if ($saabumise_kuupaev >= $lahkumise_kuupaev) {
        $errors[] = 'Lahkumise kuupäev peab olema hiljem kui saabumise kuupäev.';
    }

    if (empty($errors)) {
        $update_sql = "
            UPDATE broneeringud 
            SET saabumise_kuupaev = '$saabumise_kuupaev', lahkumise_kuupaev = '$lahkumise_kuupaev'
            WHERE id = $broneering_id
        ";
        if (mysqli_query($yhendus, $update_sql)) {
            $success = 'Broneering on edukalt uuendatud.';
            // Võta uuendatud info andmebaasist
            $query = "
                SELECT b.id, b.saabumise_kuupaev, b.lahkumise_kuupaev, b.staatus, 
                       r.ruumi_nr, r.tyyp, r.hind
                FROM broneeringud b
                JOIN ruumid r ON b.ruum_id = r.id
                WHERE b.id = $broneering_id
                LIMIT 1
            ";
            $result = mysqli_query($yhendus, $query);
            $info = mysqli_fetch_assoc($result);
        } else {
            $errors[] = 'Broneeringu uuendamine ebaõnnestus.';
        }
    }
}

// Kui kustuta vorm saadetud
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kustuta'])) {
    $broneering_id = (int)$_POST['broneering_id'];

    // Esiteks leiame broneeringu ruum_id, et hiljem ruumi olekut muuta
    $query = "SELECT ruum_id FROM broneeringud WHERE id = $broneering_id LIMIT 1";
    $result = mysqli_query($yhendus, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $ruum_id = (int)$row['ruum_id'];

        // Kustutame broneeringu
        $delete_sql = "DELETE FROM broneeringud WHERE id = $broneering_id";

        if (mysqli_query($yhendus, $delete_sql)) {
            // Muudame ruumi oleku vabaks
            $update_sql = "UPDATE ruumid SET olek = 'vaba' WHERE id = $ruum_id";
            mysqli_query($yhendus, $update_sql);

            $success = 'Broneering on kustutatud ja tuba märgitud vabaks.';
            $info = null;
            $broneering_id = null;
        } else {
            $errors[] = 'Broneeringu kustutamine ebaõnnestus.';
        }
    } else {
        $errors[] = 'Broneeringut ei leitud.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'navbar.php'; ?>
    <title>Broneeringu kontroll ja haldus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <h2>Kontrolli ja halda oma broneeringut</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?=$success?></div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?=htmlspecialchars($error)?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!$info): ?>
        <form method="post" class="mb-4">
            <div class="mb-3">
                <label for="kood" class="form-label">Sisesta broneeringu kood</label>
                <input type="text" name="kood" id="kood" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Kontrolli</button>
        </form>
    <?php endif; ?>

    <?php if ($info && is_array($info)): ?>
        <div class="alert alert-info">
            <h5>Broneering leitud:</h5>
            <p><strong>Tuba:</strong> <?=htmlspecialchars($info['ruumi_nr'])?> (<?=htmlspecialchars($info['tyyp'])?>)</p>
            <p><strong>Hind:</strong> €<?=htmlspecialchars($info['hind'])?> / öö</p>
        </div>

        <form method="post" class="mb-3">
            <input type="hidden" name="broneering_id" value="<?=htmlspecialchars($info['id'])?>">
            <div class="mb-3">
                <label for="saabumise_kuupaev" class="form-label">Saabumise kuupäev</label>
                <input type="date" name="saabumise_kuupaev" id="saabumise_kuupaev" class="form-control" required value="<?=htmlspecialchars($info['saabumise_kuupaev'])?>">
            </div>
            <div class="mb-3">
                <label for="lahkumise_kuupaev" class="form-label">Lahkumise kuupäev</label>
                <input type="date" name="lahkumise_kuupaev" id="lahkumise_kuupaev" class="form-control" required value="<?=htmlspecialchars($info['lahkumise_kuupaev'])?>">
            </div>
            <div class="mb-3">
                <strong>Staatus:</strong> <?=htmlspecialchars($info['staatus'])?>
            </div>
            <button type="submit" name="muuda" class="btn btn-warning">Muuda broneeringut</button>
            <button type="submit" name="kustuta" class="btn btn-danger" onclick="return confirm('Kas oled kindel, et soovid broneeringu kustutada?');">Kustuta broneering</button>
        </form>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mt-3">Tagasi avalehele</a>
</div>
</body>
</html>
