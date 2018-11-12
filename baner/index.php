<?php

$ipAdr = $_GET['ip'];
$ipPor = $_GET['port'];
include('includes.php');

echo $gtapi->GraficonInBanner();

// echo $gtapi->GTBigGraficonPlayer();
// echo $gtapi->GetServerHostedMap();
// echo $gtapi->GetCurrentMapImage();

?>
