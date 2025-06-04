<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $id = $_POST['personal_id'];
    $email = $_POST['email'];
    $room_id = $_POST['room_id'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];

    // Kontroll: topeltbroneering
    $stmt = $mysqli->prepare("SELECT * FROM bookings WHERE room_id = ? AND NOT (? >= end_date OR ? <= start_date)");
    $stmt->bind_param("iss", $room_id, $start, $end);
    $stmt->execute();
    $conflict = $stmt->get_result();

    if ($conflict->num_rows > 0) {
        die("Valitud tuba on juba broneeritud sellel perioodil.");
    }

    // Lisa külastaja
    $stmt = $mysqli->prepare("INSERT INTO visitors (first_name, last_name, personal_id, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first, $last, $id, $email);
    $stmt->execute();
    $visitor_id = $mysqli->insert_id;

    // Lisa broneering
    $stmt = $mysqli->prepare("INSERT INTO bookings (visitor_id, room_id, start_date, end_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $visitor_id, $room_id, $start, $end);
    $stmt->execute();

    echo "<p>Broneering salvestatud! <a href='index.php'>Tagasi</a></p>";
}
?>
