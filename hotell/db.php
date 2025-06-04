<?php
$mysqli = new mysqli("localhost", "joosep", "Passw0rd", "hotel_system");
if ($mysqli->connect_error) {
    die("Andmebaasi ühendus ebaõnnestus: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8");
?>
