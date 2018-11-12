<?php

include("connect_db.php");  
include_once("analyticstracking.php");
/* DEMO LOGIN */

$email = htmlspecialchars(mysql_real_escape_string(addslashes("demo@o-neon.info"))); //email
$password = htmlspecialchars(mysql_real_escape_string(addslashes("demo1337"))); //password

if ($email == ""||$password == "") {
	$_SESSION['error'] = "Morate popuniti sva polja.";
	header("Location: /home");
    die();
}

$password = md5($password);

$kveri = mysql_query("SELECT * FROM `klijenti` WHERE `email` = '$email' AND `sifra` = '$password'");
if (mysql_num_rows($kveri)) {

	$user = mysql_fetch_array($kveri);

	$_SESSION['userid'] = $user['klijentid'];
	$_SESSION['email'] = $user['email'];
	$_SESSION['ime'] = $user['ime'];
	$_SESSION['prezime'] = $user['prezime'];
	$mesec = 24*60*60*31; // mesec dana
	
	$time = time();
	
	$sesija = md5($user['email'].$user['prezime'].$user['ime'].$mesec.$time."Kevia <3");

	setcookie("userid", $_SESSION['userid'], time()+ $mesec);
	setcookie("email", $_SESSION['email'], time()+ $mesec);
	setcookie("i_p", $_SESSION['ime'] .' '.$_SESSION['prezime'], time()+ $mesec);
	setcookie("sesija", $sesija, time() + $mesec);

	$log_msg = "Uspesan login kao DEMO klijent.";
	$v_d = date('d.m.Y, H:i:s');
	$ip = get_client_ip();

	mysql_query("INSERT INTO `logovi` (`id`, `clientid`, `message`, `name`, `ip`, `vreme`, `adminid`) VALUES (NULL, '$_SESSION[userid]', '$log_msg', '$log_msg', '$ip', '$v_d', NULL);");
    
    $_SESSION['ok'] = "Uspesno ste se ulogovali kao demo klijent.";
	header("Location: /home");
} else {
	$_SESSION['error'] = "Podaci za prijavu nisu tacni.";
	header("Location: /home");
	die();
}


?>