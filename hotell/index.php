<?php 
include 'config.php';

// Küsi vabad ruumid
$sql = "SELECT * FROM ruumid WHERE olek = 'vaba'";
$tulemused = mysqli_query($yhendus, $sql);
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hotelli vabad toad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .banner {
            background: url('https://picsum.photos/200/200') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 120px 30px;
            text-align: center;
            position: relative;
            box-shadow: inset 0 0 0 2000px rgba(0,0,0,0.4);
        }
        .banner h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
        }
        .banner p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.6);
        }
        .btn-banner {
            font-size: 1.25rem;
            padding: 12px 30px;
        }
        .card {
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.2);
        }
        .card-title {
            font-weight: 600;
            font-size: 1.25rem;
        }
        .card-text {
            color: #555;
            font-size: 0.95rem;
        }
        .footer {
            background-color: #343a40;
            color: #bbb;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="banner">
    <h1>Tere tulemast meie hotelli!</h1>
    <p>Broneeri mugavalt sobiv tuba ja naudi suurepärast teenindust.</p>
</div>

<!-- Avalehe sisu (teenused, pildid, kutsuv tekst) -->
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Tere tulemast Meie Hotelli</h2>
        <p class="lead text-muted">Naudi mugavust, rahu ja esmaklassilist teenindust kogu oma peatumise jooksul.</p>
        <a href="toad.php" class="btn btn-primary btn-lg mt-3">Vaata meie tube</a>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <img src="https://picsum.photos/200/200" class="card-img-top" alt="Hotelli tuba">
                <div class="card-body">
                    <h5 class="card-title">Stiilsed toad</h5>
                    <p class="card-text">Meie toad on kaasaegsed ja sisustatud mugavuse eesmärgil – ideaalne lõõgastumiseks.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <img src="https://picsum.photos/200/200" class="card-img-top" alt="Hommikusöök">
                <div class="card-body">
                    <h5 class="card-title">Tasuta hommikusöök</h5>
                    <p class="card-text">Alusta päeva maitsva ja mitmekesise hommikusöögiga, mis sisaldub hinnas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <img src="https://picsum.photos/200/200" class="card-img-top" alt="Spa teenused">
                <div class="card-body">
                    <h5 class="card-title">Lõõgastavad teenused</h5>
                    <p class="card-text">Spa, saun ja massaažid – kõike selleks, et tunneksid end tõeliselt hästi.</p>
                </div>
            </div>
        </div>
    </div>
</div>


<footer class="footer">
    <div class="container">
        <p>&copy; <?=date('Y')?> Meie Hotell. Kõik õigused kaitstud.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
