<?php
$host = 'localhost';
$db = 'hotell';
$user = 'joosep';
$pass = 'Passw0rd';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Ühendus ebaõnnestus: " . $e->getMessage());
}
