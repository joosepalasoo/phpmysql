<?php
try {
    $db_server = 'localhost';
    $db_andmebaas = 'hotell';
    $db_kasutaja = 'joosep';        // muuda vastavalt oma kasutajanimele
    $db_salasona = 'Passw0rd';            // muuda vastavalt oma salasõnale

    $yhendus = mysqli_connect($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);

    if (!$yhendus) {
        throw new Exception('Andmebaasi ühendus ebaõnnestus: ' . mysqli_connect_error());
    }
} catch (Exception $e) {
    die('Probleem andmebaasiga: ' . $e->getMessage());
}
?>