<?php
session_start();
include 'config.php';

if (!isset($_SESSION['kasutaja_id']) || $_SESSION['roll'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// KÜLASTAJAD ja RUUMID dropdown jaoks
$kylastajad = $yhendus->query("SELECT id, eesnimi, perenimi FROM kylastajad ORDER BY eesnimi");
$ruumid = $yhendus->query("SELECT id, ruumi_nr FROM ruumid ORDER BY ruumi_nr");

// Broneeringu kustutamine
if (isset($_GET['kustuta'])) {
    $kustuta_id = (int)$_GET['kustuta'];

    // Leia ruum, mis seostub kustutatava broneeringuga
    $stmt = $yhendus->prepare("SELECT ruum_id FROM broneeringud WHERE id = ?");
    $stmt->bind_param("i", $kustuta_id);
    $stmt->execute();
    $stmt->bind_result($ruum_id);
    if ($stmt->fetch()) {
        $stmt->close();

        // Kustuta broneering
        $yhendus->query("DELETE FROM broneeringud WHERE id = $kustuta_id");

        // Muuda ruumi olek 'vaba'
        $updateRuum = $yhendus->prepare("UPDATE ruumid SET olek = 'vaba' WHERE id = ?");
        $updateRuum->bind_param("i", $ruum_id);
        $updateRuum->execute();
    } else {
        $stmt->close();
    }

    header('Location: admin.php');
    exit;
}

// Broneeringu muutmine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['muuda_id'])) {
    $id = (int)$_POST['muuda_id'];
    $kylastaja_id = (int)$_POST['kylastaja_id'];
    $ruum_id = (int)$_POST['ruum_id'];
    $kood = $_POST['kood'] ?? '';
    $saabumine = $_POST['saabumise_kuupaev'];
    $lahkumine = $_POST['lahkumise_kuupaev'];
    $staatus = $_POST['staatus'];

    if ($id > 0 && $kylastaja_id > 0 && $ruum_id > 0 && $saabumine && $lahkumine && in_array($staatus, ['aktiivne', 'tühistatud', 'lõpetatud'])) {
        $update = $yhendus->prepare("UPDATE broneeringud SET kylastaja_id = ?, ruum_id = ?, kood = ?, saabumise_kuupaev = ?, lahkumise_kuupaev = ?, staatus = ? WHERE id = ?");
        $update->bind_param("iissssi", $kylastaja_id, $ruum_id, $kood, $saabumine, $lahkumine, $staatus, $id);
        $update->execute();
    }

    header('Location: admin.php');
    exit;
}

// Võta broneeringud koos külaliste ja ruumidega
$sql = "SELECT b.id, b.kylastaja_id, b.ruum_id, b.kood, b.saabumise_kuupaev, b.lahkumise_kuupaev, b.staatus, 
               k.eesnimi, k.perenimi, r.ruumi_nr
        FROM broneeringud b
        JOIN kylastajad k ON b.kylastaja_id = k.id
        JOIN ruumid r ON b.ruum_id = r.id
        ORDER BY b.saabumise_kuupaev DESC";
$result = $yhendus->query($sql);
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Broneeringute haldus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">
<div class="container">
    <h2 class="mb-4">Broneeringute haldus</h2>

    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Külaline</th>
                <th>Ruum</th>
                <th>Kood</th>
                <th>Saabumine</th>
                <th>Lahkumine</th>
                <th>Staatus</th>
                <th>Tegevus</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <form method="post">
                    <td><?= $row['id'] ?></td>
                    <td>
                        <select name="kylastaja_id" class="form-select form-select-sm">
                            <?php foreach ($kylastajad as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= $k['id'] == $row['kylastaja_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($k['eesnimi'] . ' ' . $k['perenimi']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="ruum_id" class="form-select form-select-sm">
                            <?php foreach ($ruumid as $r): ?>
                                <option value="<?= $r['id'] ?>" <?= $r['id'] == $row['ruum_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['ruumi_nr']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="text" name="kood" value="<?= htmlspecialchars($row['kood']) ?>" class="form-control form-control-sm"></td>
                    <td><input type="date" name="saabumise_kuupaev" value="<?= $row['saabumise_kuupaev'] ?>" class="form-control form-control-sm"></td>
                    <td><input type="date" name="lahkumise_kuupaev" value="<?= $row['lahkumise_kuupaev'] ?>" class="form-control form-control-sm"></td>
                    <td>
                        <select name="staatus" class="form-select form-select-sm">
                            <option value="aktiivne" <?= $row['staatus'] === 'aktiivne' ? 'selected' : '' ?>>Aktiivne</option>
                            <option value="tühistatud" <?= $row['staatus'] === 'tühistatud' ? 'selected' : '' ?>>Tühistatud</option>
                            <option value="lõpetatud" <?= $row['staatus'] === 'lõpetatud' ? 'selected' : '' ?>>Lõpetatud</option>
                        </select>
                    </td>
                    <td class="d-flex gap-1">
                        <input type="hidden" name="muuda_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-success">Salvesta</button>
                        <a href="?kustuta=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Kas oled kindel, et soovid kustutada?')">Kustuta</a>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="logout.php" class="btn btn-secondary mt-3">Logi välja</a>
</div>
</body>
</html>
