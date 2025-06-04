<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Tere tulemast Hotelli!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('https://images.unsplash.com/photo-1582719478185-2193d9918f14?auto=format&fit=crop&w=1950&q=80') no-repeat center center;
            background-size: cover;
            height: 400px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero h1 {
            background-color: rgba(0,0,0,0.5);
            padding: 20px;
            border-radius: 12px;
        }
    </style>
</head>
<body>
<!-- Nav või nupp lehe ülaossa -->
<div class="text-end p-3">
    <a href="admin.php" class="btn btn-outline-dark">Admin vaade</a>
</div>

<!-- Hero banner -->
<section class="hero">
    <h1>Tere tulemast Meie Hotelli</h1>
</section>

<!-- Hotelli info -->
<section class="container py-5">
    <h2>Meie Hotell</h2>
    <p>Pakume hubaseid tube, suurepärast teenindust ja imelist asukohta otse linna südames. Meie toad sobivad nii ärireisijale kui ka puhkajale.</p>
</section>

<!-- Toad -->
<section class="container py-4">
    <h2>Meie toad</h2>
    <div class="row">
        <?php
        $rooms = $mysqli->query("SELECT * FROM rooms");
        while ($room = $rooms->fetch_assoc()):
        ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="https://picsum.photos/200<?= $room['id'] ?>" class="card-img-top" alt="Tuba">
                <div class="card-body">
                    <h5 class="card-title">Tuba <?= $room['room_number'] ?></h5>
                    <p class="card-text">
                        Voodikohti: <?= $room['beds'] ?><br>
                        Hind: <?= $room['price'] ?> € / öö
                    </p>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- Broneerimine -->
<section class="container py-5">
    <h2>Broneeri tuba</h2>
    <form method="get" class="row g-3 mb-4">
        <div class="col-md-5">
            <label for="start_date" class="form-label">Saabumise kuupäev</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="col-md-5">
            <label for="end_date" class="form-label">Lahkumise kuupäev</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100" type="submit">Näita vabu tube</button>
        </div>
    </form>

    <?php if (isset($_GET['start_date'], $_GET['end_date'])):
        $start = $_GET['start_date'];
        $end = $_GET['end_date'];
        $stmt = $mysqli->prepare("
            SELECT * FROM rooms 
            WHERE id NOT IN (
                SELECT room_id FROM bookings 
                WHERE NOT (? >= end_date OR ? <= start_date)
            )
        ");
        $stmt->bind_param("ss", $start, $end);
        $stmt->execute();
        $rooms = $stmt->get_result();
    ?>

    <h4>Vabad toad (<?= htmlspecialchars($start) ?> kuni <?= htmlspecialchars($end) ?>)</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Tuba</th>
                <th>Voodikohti</th>
                <th>Hind</th>
                <th>Broneeri</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($room = $rooms->fetch_assoc()): ?>
            <tr>
                <td><?= $room['room_number'] ?></td>
                <td><?= $room['beds'] ?></td>
                <td><?= $room['price'] ?> €</td>
                <td>
                    <form action="booking_submit.php" method="post">
                        <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                        <input type="hidden" name="start_date" value="<?= $start ?>">
                        <input type="hidden" name="end_date" value="<?= $end ?>">
                        <div class="row g-2">
                            <div class="col">
                                <input type="text" name="first_name" class="form-control" placeholder="Eesnimi" required>
                            </div>
                            <div class="col">
                                <input type="text" name="last_name" class="form-control" placeholder="Perekonnanimi" required>
                            </div>
                            <div class="col">
                                <input type="text" name="personal_id" class="form-control" placeholder="Isikukood" required>
                            </div>
                            <div class="col">
                                <input type="email" name="email" class="form-control" placeholder="E-post" required>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success">Broneeri</button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <?php endif; ?>
<section class="container py-5">
  <div class="row">
    <!-- Kaart 2/3 laiuses -->
    <div class="col-lg-8 mb-4">
      <h2>Meie asukoht</h2>
      <div class="ratio ratio-16x9">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2436.093050636367!2d24.753574315746577!3d59.43700417930721!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4692939b55a97fd1%3A0x549a9d0a0edc668!2sTallinn%2C%20Estonia!5e0!3m2!1sen!2see!4v1696500000000!5m2!1sen!2see"
          style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>

    <!-- Lingid 1/3 laiuses -->
    <div class="col-lg-4">
      <h2>Kasutuslikud lingid</h2>
      <ul class="list-group">
        <li class="list-group-item"><a href="https://www.visitestonia.com/et" target="_blank" rel="noopener noreferrer">Visit Estonia</a></li>
        <li class="list-group-item"><a href="https://www.tallinn.ee/est" target="_blank" rel="noopener noreferrer">Tallinna linn</a></li>
        <li class="list-group-item"><a href="https://www.eki.ee/" target="_blank" rel="noopener noreferrer">Eesti Keele Instituut</a></li>
        <li class="list-group-item"><a href="https://www.hot.ee/" target="_blank" rel="noopener noreferrer">Hotellide Liit</a></li>
        <li class="list-group-item"><a href="https://www.tripadvisor.com/" target="_blank" rel="noopener noreferrer">TripAdvisor</a></li>
      </ul>
    </div>
  </div>
</section>
</section>

<footer class="bg-light text-center py-4">
    <p class="mb-0">© <?= date("Y") ?> Meie Hotell. Kõik õigused kaitstud.</p>
</footer>

</body>
</html>
