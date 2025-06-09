<?php
include 'config.php';
$sql = "SELECT * FROM ruumid";
$tulemused = mysqli_query($yhendus, $sql);
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Kõik toad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Kõik meie toad</h1>
    <div class="row">
        <?php while ($ruum = mysqli_fetch_assoc($tulemused)) : ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-<?= $ruum['olek'] === 'vaba' ? 'success' : 'danger' ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Tuba <?=htmlspecialchars($ruum['ruumi_nr'])?> (<?=htmlspecialchars($ruum['tyyp'])?>)</h5>
                        <p class="mb-1">Hind: €<?=htmlspecialchars($ruum['hind'])?> / öö</p>
                        <p class="mb-1"><?=htmlspecialchars($ruum['kirjeldus'])?></p>
                        <p class="text-muted">Olek: 
                            <strong class="<?= $ruum['olek'] === 'vaba' ? 'text-success' : 'text-danger' ?>">
                                <?=htmlspecialchars($ruum['olek'])?>
                            </strong>
                        </p>
                        <div class="mt-auto">
                            <?php if ($ruum['olek'] === 'vaba') : ?>
                                <a href="broneerimine.php?ruum_id=<?=urlencode($ruum['id'])?>" class="btn btn-primary">Broneeri</a>
                            <?php else : ?>
                                <button class="btn btn-secondary" disabled>Broneeritud</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
