<?php
	try {

		$db_server = 'localhost';
		$db_andmebaas = 'jalasoo';
		$db_kasutaja = 'jalasoo';
		$db_salasona = 'vlOMSPI7WOruJnDZ';

		
		$yhendus = mysqli_connect($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);
	} catch (mysqli_sql_exception $e) {
		die('Probleem andmebaasiga: ' . $e->getMessage());
	}
?>