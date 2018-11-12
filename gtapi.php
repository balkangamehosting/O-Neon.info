<?php
header("Content-Type: application/json; charset=UTF-8");

include('connect_db.php');

$ipAdr = $_GET['ip'];
$ipPor = $_GET['port'];

$info = mysql_fetch_array(mysql_query("SELECT * FROM `lgsl` WHERE ip='$ipAdr' AND c_port='$ipPor'"));

$serverinfo->players_day = $info['igraci'];
$serverinfo->players_week = $info['igraci_5min'];
?>