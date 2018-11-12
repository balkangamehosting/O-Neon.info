<?php
header('Content-Type: application/json');
date_default_timezone_set("Europe/Belgrade");
include('./connect_db.php');


if (isset($_GET['task']) && $_GET['task'] == "vesti") {
{
$data_query = mysql_query("SELECT * FROM `vesti` ORDER BY id DESC");
while($rez = mysql_fetch_array($data_query)) { 
$jsondata->naslov = $rez["naslov"];
$jsondata->poruka = $rez["poruka"];
$jsondata->vreme = $rez["vreme"];
$jsondata->pregleda = $rez["views"];
$jsondata->slika = $rez["l_slika"];

$json = json_encode($jsondata, JSON_PRETTY_PRINT);

echo $json;
}
}
else
{
echo "Zabranjen pristup!"
die();
}
?>
