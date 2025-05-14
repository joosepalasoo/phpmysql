<?php
	try {

		$db_server = 'localhost';
		$db_andmebaas = 'sport2025';
		$db_kasutaja = 'joosep';
		$db_salasona = 'admin';

		
		$yhendus = mysqli_connect($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);
	} catch (mysqli_sql_exception $e) {
		die('Probleem andmebaasiga: ' . $e->getMessage());
	}
?>