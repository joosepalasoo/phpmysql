<?php
include 'config.php';

$ruum_id = isset($_GET['ruum_id']) ? (int)$_GET['ruum_id'] : 0;

if ($ruum_id <= 0) {
    die('Valitud tuba puudub või on vigane.');
}

// Võta tuba andmebaasist
$sql = "SELECT * FROM ruumid WHERE id = $ruum_id AND olek = 'vaba' LIMIT 1";
$result = mysqli_query($yhendus, $sql);

if (mysqli_num_rows($result) === 0) {
    die('Valitud tuba ei ole saadaval.');
}

$ruum = mysqli_fetch_assoc($result);

// Tänane kuupäev formaadis YYYY-MM-DD
$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Broneeri tuba <?=htmlspecialchars($ruum['ruumi_nr'])?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Broneeri tuba <?=htmlspecialchars($ruum['ruumi_nr'])?> (<?=htmlspecialchars($ruum['tyyp'])?>)</h2>
    <form id="bookingForm" action="submit_booking.php" method="post">
        <input type="hidden" name="ruum_id" value="<?=htmlspecialchars($ruum['id'])?>">

        <div class="mb-3">
            <label for="eesnimi" class="form-label">Eesnimi</label>
            <input type="text" name="eesnimi" id="eesnimi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="perenimi" class="form-label">Perenimi</label>
            <input type="text" name="perenimi" id="perenimi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="isikukood" class="form-label">Isikukood</label>
            <input type="text" name="isikukood" id="isikukood" class="form-control" pattern="\d{11}" maxlength="11" required>
            <div class="form-text">Sisesta 11-kohaline Eesti isikukood.</div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="telefon" class="form-label">Telefon</label>
            <input type="text" name="telefon" id="telefon" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="saabumise_kuupaev" class="form-label">Saabumise kuupäev</label>
            <input type="date" name="saabumise_kuupaev" id="saabumise_kuupaev" class="form-control" required min="<?= $today ?>">
        </div>
        <div class="mb-3">
            <label for="lahkumise_kuupaev" class="form-label">Lahkumise kuupäev</label>
            <input type="date" name="lahkumise_kuupaev" id="lahkumise_kuupaev" class="form-control" required min="<?= $today ?>">
        </div>
        <button type="submit" class="btn btn-primary">Saada broneering</button>
    </form>
    <br>
    <a href="index.php" class="btn btn-secondary">Tagasi avalehele</a>
</div>

<script>
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const saabumiseKuupaev = document.getElementById('saabumise_kuupaev').value;
        const lahkumiseKuupaev = document.getElementById('lahkumise_kuupaev').value;
        const täna = new Date().toISOString().split('T')[0];

        if (saabumiseKuupaev < täna) {
            alert('Saabumise kuupäev ei saa olla minevikus.');
            e.preventDefault();
            return;
        }

        if (lahkumiseKuupaev < täna) {
            alert('Lahkumise kuupäev ei saa olla minevikus.');
            e.preventDefault();
            return;
        }

        if (lahkumiseKuupaev <= saabumiseKuupaev) {
            alert('Lahkumise kuupäev peab olema hiljem kui saabumise kuupäev.');
            e.preventDefault();
            return;
        }
    });
</script>

</body>
</html>
