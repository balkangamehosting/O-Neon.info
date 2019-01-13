<?php
//header("Location: /logout.php");
//Kevia
//include "/inc/libs/mysql2mysqli.php"; //root php 5.6 rewrite to php7+
error_reporting(E_ALL);
session_start();
ob_start();

define('DB_HOST', 'localhost');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', 'admin_oneon');
//root
define('MASTER_HOST', 'localhost');
define('MASTER_USER', '');
define('MASTER_PASS', '');
define('MASTER_NAME', '');

if (!$db=@mysql_connect(DB_HOST, DB_USER, DB_PASS)) {
	die ("<b>Doslo je do greske prilikom spajanja na MySQL...</b>");
}

if (!mysql_select_db(DB_NAME, $db)) {
	die ("<b>Greska prilikom biranja baze!</b>");
}

//MASTER CONNECT
//$mdb = new mysqli(MASTER_HOST, MASTER_USER, MASTER_PASS, MASTER_NAME);

/* Jezik */

include 'jezik/index.php';

/* CS by GH.biz link */

$dl_link_cs = "https://cs.gametracker.xyz/"; // Link counter-strike 1.6

// Set all default avatar
//$avatar = mysql_query("UPDATE `klijenti` SET `avatar` = 'default.png' WHERE `status` = 'Aktivan'");

/* Provera za LOGIN */

function is_login(){
	if(isset($_SESSION['userid'])){
		return true;
	} else {
		return false;
	}
}

/* Provera za PIN KOD */

function is_pin(){
	if(isset($_SESSION['_pin'])){
		return true;
	} else {
		return false;
	}
}

/* Provera za Demo klijenta */

function is_demo(){
	/*$p_demo = mysql_fetch_array(mysql_query("SELECT * FROM `klijenti` WHERE `klijentid` = '$_SESSION[userid]'"));
	if ($p_demo['username'] == "demo"||$p_demo['username'] == "demo_nalog")*/
	if($_SESSION[userid]==1) {
		return false;
	} else {
		return true;
	}
}

/* Client online */

if (isset($_SESSION['userid'])) {
$time_online = time();
mysql_query("UPDATE `klijenti` SET `lastactivity` = '$time_online' WHERE `klijentid` = '$_SESSION[userid]'");
}

/* GET IP ADRESS */

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

/* GET HOSTNAME CLIENT IP */

function clientIpHost($client_ip) {
	$cl_ip_host = json_decode(file_get_contents("https://ipinfo.io/$client_ip/json/"));
	if ($cl_ip_host == true) {
		return $cl_ip_host->hostname;
	} else {
		return "HostName nije pronadjen.";
	}
}

/* RANDOM SIFRA */

function randomSifra($duzina){
	$karakteri = "abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ";
	$string = str_shuffle($karakteri);
	$sifra = substr($string, 0, $duzina);
	return $sifra;
}

function randomNumber($duzina){
	$karakteri = "1234567890";
	$string = str_shuffle($karakteri);
	$sifra = substr($string, 0, $duzina);
	return $sifra;
}

/* Provera SQL */

function sqli($text) {
	$text = mysql_real_escape_string($text);
	$text = htmlspecialchars($text);
	return $text;
}

/* GP - IGRA */

function gp_igra($game_id) {
	if ($game_id == "1") {
		return "Counter-Strike 1.6";
	} else if ($game_id == "1") {
		return 'Counter-Strike 1.6.';
	} else if ($game_id == "2") {
		return 'SAMP';
	} else if ($game_id == "3") {
		return 'Minecraft';
	} else if ($game_id == "4") {
		return 'Call of duty 4: Modern warfare';
	} else if ($game_id == "5") {
		return 'Counter-Strike: GO';
	} else {
		return "Game?";
	}
}

/* LOKACIJA SERVERA */

function gp_lokacija($server_ip) {
	$location_ip = json_decode(file_get_contents("https://freegeoip.net/json/".$server_ip));
	if ($location_ip === true) {
		return $location_ip->country_code;
	} else {
		return "Lokacija nije pronadjena.";
	}
}

/* IME MODA */

function mod_ime($mod_id) {
	$mod_name = mysql_fetch_assoc(mysql_query("SELECT * FROM `modovi` WHERE `id` = '$mod_id'"));
	if ($mod_name == true) {
		return $mod_name['ime'];
	} else {
		return "Ne mogu pronaci mod.";
	}
}

/* IME KLIJENTA */

function userIme($user_id) {
	$ime_usera = mysql_fetch_assoc(mysql_query("SELECT * FROM `klijenti` WHERE `klijentid` = '$user_id'"));
	if ($ime_usera == true) {
		return $ime_usera['ime'].' '.$ime_usera['prezime'];
	} else {
		return "Ne mogu pronaci ime.";
	}
}

/* IME ADMINA */

function adminIme($user_id) {
	$ime_usera = mysql_fetch_assoc(mysql_query("SELECT * FROM `admin` WHERE `id` = '$user_id'"));
	if ($ime_usera == true) {
		return $ime_usera['fname'].' '.$ime_usera['lname'];
	} else {
		return "Ne mogu pronaci ime.";
	}
}

/* EMAIL KLIJENTA */

function userEmail($user_id) {
	$email_usera = mysql_fetch_assoc(mysql_query("SELECT * FROM `klijenti` WHERE `klijentid` = '$user_id'"));
	if ($email_usera == true) {
		return $email_usera['email'];
	} else {
		return "Ne mogu pronaci email.";
	}
}

/* CREATE DATUM KLIJENTA */

function lastLogin($user_id) {
	$lastlogin = mysql_fetch_assoc(mysql_query("SELECT * FROM `klijenti` WHERE `klijentid` = '$user_id'"));
	if ($lastlogin == true) {
		return $lastlogin['lastlogin'];
	} else {
		return "Ne mogu pronaci datum.";
	}
}

/* USER AVATAR */

function userAvatar($user_id) {
	$userAvatar = mysql_fetch_assoc(mysql_query("SELECT * FROM `klijenti` WHERE `klijentid` = '$user_id'"));
	if ($userAvatar["avatar"] == "default.png") {
		return "/img/a/default.png";
	} else {
		return $userAvatar['avatar'];
	}
}

/* KOLE!!!!!!!!!!!!!!!!!!!!!!!!!!*/

/*$fuck_kocko = mysql_fetch_array(mysql_query("SELECT * FROM `klijenti` WHERE `username` = 'Kole' AND `klijentid` = '$_SESSION[userid]'"));
if (!$fuck_kocko) { } else {
	$ispis = 0;
	while ($ispis < 5000) { ?>
		<center>
			<h3 style="color: #fff;"><strong>Kole picko .!.</strong></h3>
			<img style="border-radius: 50%;" src='https://pbs.twimg.com/profile_images/2101555272/middle_finger_flip_off_die_cut_vinyl_decal__84044.jpg' style=''>
		</center>
	<?php $ispis++; }
}
*/
/* REDIRECT - MOBILE */

/*if(!empty($_SERVER['HTTP_USER_AGENT'])) {
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if( preg_match('@(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)@', $useragent) ){
        header('Location: ./m/');
    }
}*/

/* ZASTITA - ISPRAVI TEXT */

function ispravi_text($poruka) {
	return htmlspecialchars(mysql_real_escape_string(addslashes($poruka)));
}
function ispravi_text_sql($poruka) {
	return htmlspecialchars(addslashes($poruka));
}
function ispravi_text_html($poruka) {
	return htmlspecialchars($poruka);
}

?>
