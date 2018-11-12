<?php 
$ip = "31.172.80.47";
$port = "9987";
$nick = "GameHoster.biz";

$url = "ts3server://".$ip."/?port=".$port."&nickname=".$nick;
header("Location: ".$url);
?>