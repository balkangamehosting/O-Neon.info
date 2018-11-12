<?php
$loc_ip = @file_get_contents('make_ip.txt');  
$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
$loc_ip = json_decode(file_get_contents("http://ipinfo.io/$user_ip/json/"));
echo "Radi li? - Password: ";
echo $loc_ip = $loc_ip->ip;

@file_put_contents('make_ip.txt', $loc_ip);

?>