<!doctype html>
<html lang="et">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>phpMySQL</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
<body>
    <div class="container">

<?php include('config.php'); ?>

<h4>Väljasta kogu ‘albumid’ sisu ridade kaupa</h4>

<br>

<?php

// Väljasta kogu ‘albumid’ sisu ridade kaupa

//päring

$paring = 'SELECT * FROM sport2025';				//mysql käsk VALI kõik veerud TABELIST albumid
$valjund = mysqli_query($yhendus, $paring);		//mysql käsu saatmine andmebaasile


while($rida = mysqli_fetch_row($valjund)){
	echo $rida[1].' '.$rida[2].' '.$rida[3].' '.$rida[4].'<br>';
}

?>

<br>
<br>
<br>

<h4>Väljasta tabelist ainult artist ja album read, kusjuures sorteeri kasvavalt artisti järgi</h4>

<br>

<?php

// Väljasta tabelist ainult artist ja album read, kusjuures sorteeri kasvavalt artisti järgi

$paring = 'SELECT artist,album FROM albumid ORDER BY artist';				//mysql käsk VALI kõik veerud TABELIST albumid
$valjund = mysqli_query($yhendus, $paring);		//mysql käsu saatmine andmebaasile

while($rida = mysqli_fetch_row($valjund)){
	echo $rida[0].' '.$rida[1].'<br>';
}

?>


<br>
<br>
<br>

<h4>Väljasta tabelist ainult artist ja album read, mille aasta on 2010 ja uuemad</h4>

<br>

<?php

// Väljasta tabelist ainult artist ja album read, mille aasta on 2010 ja uuemad

$paring = 'SELECT artist,album FROM albumid WHERE aasta>2010';				//mysql käsk VALI kõik veerud TABELIST albumid
$valjund = mysqli_query($yhendus, $paring);		//mysql käsu saatmine andmebaasile

while($rida = mysqli_fetch_row($valjund)){
	echo $rida[0].' '.$rida[1].'<br>';
}

?>

<br>
<br>
<br>

<h4>Väljasta kui palju erinevaid albumeid on andmebaasis, mis on nende keskmine hind ja koguväärtus (summa)</h4>

<br>

<?php

// Väljasta kui palju erinevaid albumeid on andmebaasis, mis on nende keskmine hind ja koguväärtus (summa)

//päring
$paring = '
	SELECT 
	AVG(hind) AS "Keskmine hind",
	COUNT(*) AS "Albumeid kokku",
    MAX(hind) AS "Hind kokku" 
	FROM albumid
';
//mysql käsu saatmine andmebaasile
$valjund = mysqli_query($yhendus, $paring);		
//väljastamine
while($rida = mysqli_fetch_assoc($valjund)){
    printf("Albumeid kokku: %d tk<br>", $rida['Albumeid kokku']);
	printf("Keskmine hind: %0.2f eur<br>", $rida['Keskmine hind']);
    printf("Kogu väärtus: %d tk<br>", $rida['Hind kokku']);
}

?>

<br>
<br>
<br>

<h4>Väljasta kõige vanema albumi nimed</h4>

<br>

<?php

// Väljasta kõige vanema albumi nimed

//päring
$paring = 'SELECT artist,album FROM albumid ORDER BY aasta DESC';
//mysql käsu saatmine andmebaasile
$valjund = mysqli_query($yhendus, $paring);		
//väljastamine
echo $valjund

?>

<?php

mysqli_free_result($valjund);					//päringu vabastamine
mysqli_close($yhendus);							//andmebaasi ühenduse sulgemine

?>


</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>