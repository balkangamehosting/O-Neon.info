<?php
include('./../connect_db.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/fnc/mail.php');
//echo $_SERVER['DOCUMENT_ROOT'].'/swiftmailer/lib/swift_required.php';
/* Naruci server | Counter-Strike 1.6 */

if (isset($_GET['task']) && $_GET['task'] == "buy_cs") {

	if ($_SESSION['userid'] == "") {
		$_SESSION['error'] = "Morate biti ulogovani!";
		header("Location: $_SERVER[HTTP_REFERER]");
        die();
	}
	
	$user_ip = $_SERVER['REMOTE_ADDR']; 
	
	//$uzmi_toket 		= addslashes($_SESSION['uzmi_toket']);
	$ime 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));
	$email 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	$slotovi_lite 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove'])));
	$slotovi_prem 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove2'])));
	$serverName 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['naziv'])));
	$lokacija 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['lokacija'])));
	$drzava 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['drzava'])));
	$nacin_p 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['nacinplacanja'])));
	$mjeseci 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mjeseci'])));
	$cena 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['cijenaserverainput'])));
	$d 					= date("d-m-Y");
	$v 					= date("h.m.s");
	if ($ime == ""||$email == ""||$serverName == ""||$lokacija == ""||$drzava == ""||$nacin_p == ""||$mjeseci == ""||$cena == "") {
		$_SESSION['error'] = "Morate popuniti sva polja.";
		header("Location: $_SERVER[HTTP_REFERER]");
        die();
	}
	if ($slotovi_lite == "") {
		$slotovi = $slotovi_prem;
	} else {
		$slotovi = $slotovi_lite;
	}
	if ($lokacija == "1") {
		$lokacija = "Lite - Njemacka";
	} elseif ($lokacija == "2") {
		$lokacija = "Lite - Poljska";
	} elseif ($lokacija == "3") {
		$lokacija = "Lite - Francuska";
	} elseif ($lokacija == "4") {
		$lokacija = "Premium - Srbija";
	} elseif ($lokacija == "5") {
		$lokacija = "Premium - BiH";
	} else {
		$lokacija = "Lite - Njemacka";
	}

	//Klijent id
	//iznos-cena
	//datum
	//status
	//vreme
	//slotovi 
	//lokacija
	//placaza
	//description
	//paytype

	$billing_desc = "Game: Counter-Strike 1.6 | ServerName: $serverName | Lokacija: $lokacija | Cena: $cena";
	$spremi = mysql_query("INSERT INTO `billing` (`id`, `klijentid`, 
														`iznos`, 
														`datum`, 
														`status`, 
														`vreme`, 
														`slotovi`, 
														`lokacija`, 
														`placaza`, 
														`description`, 
														`paytype`,
														`game`,
														`srw_name`) VALUES(NULL, '$_SESSION[userid]', 
																				'$cena', 
																				'$d', 
																				'0', 
																				'$v', 
																				'$slotovi',
																				'$lokacija', 
																				'$mjeseci', 
																				'$billing_desc', 
																				'$nacin_p',
																				'Counter-Strike 1.6',
																				'$serverName')");
	if (!$spremi) {
		$_SESSION['error'] = "Doslo je do greske prilikom narucivanja vaseg servera... Javite se na info@gamehoster.biz .";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	} else {
		//$info_u_m = mysql_fetch_array(mysql_query("SELECT * FROM `klijenti` WHERE `klijentid` = '$_SESSION[userid]'"));

		// SEND EMAIL
		$to = $email;
        $subject = "Narudzba servera | GameHoster.biz";
        $message = "Pozdrav ". $ime ."<br/>";
                        
        ###
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: GameHoster.biz <localhost@'.$_SERVER['SERVER_NAME'].'>' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        #-----------------+
        $mail = mail($to, $subject, $message, $headers);
        #-----------------+
        
        if(!$mail) {
            $_SESSION['error'] = "Ne mogu poslati poruku na email.";
            header("Location: $_SERVER[HTTP_REFERER]");
            die();
        } 

        //var_dump($mail);

		$_SESSION['info'] = "Uspesno ste narucili svoj server, na e-mail adresu ce vam stici sva obavestenja vezana za uplatu.";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	}
}

/* Naruci server | Counter-Strike CS:GO */

if (isset($_GET['task']) && $_GET['task'] == "buy_csgo") {
	
	$user_ip = $_SERVER['REMOTE_ADDR']; 
	
	//$uzmi_toket 		= addslashes($_SESSION['uzmi_toket']);
	$ime 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));
	$email 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	$slotovi_lite 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove'])));
	$slotovi_prem 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove2'])));
	$serverName 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['naziv'])));
	$lokacija 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['lokacija'])));
	$drzava 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['drzava'])));
	$nacin_p 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['nacinplacanja'])));
	$mjeseci 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mjeseci'])));
	$cena 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['cijenaserverainput'])));
	$d 					= date("d-m-Y");
	$v 					= date("h.m.s");
	if ($ime == ""||$email == ""||$serverName == ""||$lokacija == ""||$drzava == ""||$nacin_p == ""||$mjeseci == ""||$cena == "") {
		$_SESSION['error'] = "Morate popuniti sva polja.";
		header("Location: $_SERVER[HTTP_REFERER]");
        die();
	}
	if ($slotovi_lite == "") {
		$slotovi = $slotovi_prem;
	} else {
		$slotovi = $slotovi_lite;
	}

	//Klijent id
	//iznos-cena
	//datum
	//status
	//vreme
	//slotovi 
	//lokacija
	//placaza
	//description
	//paytype

	$billing_desc = "Game: Counter-Strike GO | ServerName: $serverName | Lokacija: $lokacija | Cena: $cena";
	$spremi = mysql_query("INSERT INTO `billing` (`id`, `klijentid`, 
														`iznos`, 
														`datum`, 
														`status`, 
														`vreme`, 
														`slotovi`, 
														`lokacija`, 
														`placaza`, 
														`description`, 
														`paytype`) VALUES(NULL, '$_SESSION[userid]', 
																				'$cena', 
																				'$d', 
																				'Na cekanju', 
																				'$v', 
																				'$slotovi',
																				'$lokacija', 
																				'$mjeseci', 
																				'$billing_desc', 
																				'$nacin_p')");
	if (!$spremi) {
		$_SESSION['error'] = "Doslo je do greske prilikom narucivanja vaseg servera... Javite se na info@gamehoster.biz .";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	} else {
		$_SESSION['info'] = "Uspesno ste narucili svoj server, na e-mail ce vam stici sva obavestenja.";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	}
}

/* Naruci server | GTA San Andreas */

if (isset($_GET['task']) && $_GET['task'] == "buy_gta") {
	
	$user_ip = $_SERVER['REMOTE_ADDR']; 
	
	//$uzmi_toket 		= addslashes($_SESSION['uzmi_toket']);
	$ime 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));
	$email 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	$slotovi_lite 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove'])));
	$slotovi_prem 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove2'])));
	$serverName 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['naziv'])));
	$lokacija 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['lokacija'])));
	$drzava 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['drzava'])));
	$nacin_p 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['nacinplacanja'])));
	$mjeseci 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mjeseci'])));
	$cena 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['cijenaserverainput'])));
	$d 					= date("d-m-Y");
	$v 					= date("h.m.s");
	if ($ime == ""||$email == ""||$serverName == ""||$lokacija == ""||$drzava == ""||$nacin_p == ""||$mjeseci == ""||$cena == "") {
		$_SESSION['error'] = "Morate popuniti sva polja.";
		header("Location: $_SERVER[HTTP_REFERER]");
        die();
	}
	if ($slotovi_lite == "") {
		$slotovi = $slotovi_prem;
	} else {
		$slotovi = $slotovi_lite;
	}

	//Klijent id
	//iznos-cena
	//datum
	//status
	//vreme
	//slotovi 
	//lokacija
	//placaza
	//description
	//paytype

	$billing_desc = "Game: GTA San Andreas | ServerName: $serverName | Lokacija: $lokacija | Cena: $cena";
	$spremi = mysql_query("INSERT INTO `billing` (`id`, `klijentid`, 
														`iznos`, 
														`datum`, 
														`status`, 
														`vreme`, 
														`slotovi`, 
														`lokacija`, 
														`placaza`, 
														`description`, 
														`paytype`) VALUES(NULL, '$_SESSION[userid]', 
																				'$cena', 
																				'$d', 
																				'Na cekanju', 
																				'$v', 
																				'$slotovi',
																				'$lokacija', 
																				'$mjeseci', 
																				'$billing_desc', 
																				'$nacin_p')");
	if (!$spremi) {
		$_SESSION['error'] = "Doslo je do greske prilikom narucivanja vaseg servera... Javite se na info@gamehoster.biz .";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	} else {
		$_SESSION['info'] = "Uspesno ste narucili svoj server, na e-mail ce vam stici sva obavestenja.";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	}
}

/* Naruci server | Minecraft */

if (isset($_GET['task']) && $_GET['task'] == "buy_mc") {
	
	$user_ip = $_SERVER['REMOTE_ADDR']; 
	
	//$uzmi_toket 		= addslashes($_SESSION['uzmi_toket']);
	$ime 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));
	$email 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	$slotovi_lite 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove'])));
	$slotovi_prem 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove2'])));
	$serverName 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['naziv'])));
	$lokacija 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['lokacija'])));
	$drzava 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['drzava'])));
	$nacin_p 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['nacinplacanja'])));
	$mjeseci 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mjeseci'])));
	$cena 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['cijenaserverainput'])));
	$d 					= date("d-m-Y");
	$v 					= date("h.m.s");
	if ($ime == ""||$email == ""||$serverName == ""||$lokacija == ""||$drzava == ""||$nacin_p == ""||$mjeseci == ""||$cena == "") {
		$_SESSION['error'] = "Morate popuniti sva polja.";
		header("Location: $_SERVER[HTTP_REFERER]");
        die();
	}
	if ($slotovi_lite == "") {
		$slotovi = $slotovi_prem;
	} else {
		$slotovi = $slotovi_lite;
	}

	//Klijent id
	//iznos-cena
	//datum
	//status
	//vreme
	//slotovi 
	//lokacija
	//placaza
	//description
	//paytype

	$billing_desc = "Game: Minecraft | ServerName: $serverName | Lokacija: $lokacija | Cena: $cena";
	$spremi = mysql_query("INSERT INTO `billing` (`id`, `klijentid`, 
														`iznos`, 
														`datum`, 
														`status`, 
														`vreme`, 
														`slotovi`, 
														`lokacija`, 
														`placaza`, 
														`description`, 
														`paytype`) VALUES(NULL, '$_SESSION[userid]', 
																				'$cena', 
																				'$d', 
																				'Na cekanju', 
																				'$v', 
																				'$slotovi',
																				'$lokacija', 
																				'$mjeseci', 
																				'$billing_desc', 
																				'$nacin_p')");
	if (!$spremi) {
		$_SESSION['error'] = "Doslo je do greske prilikom narucivanja vaseg servera... Javite se na info@gamehoster.biz .";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	} else {
		$_SESSION['info'] = "Uspesno ste narucili svoj server, na e-mail ce vam stici sva obavestenja.";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	}
}

/* Naruci server | Call Of Duty 2 */

if (isset($_GET['task']) && $_GET['task'] == "buy_cod2") {
	
	$user_ip = $_SERVER['REMOTE_ADDR']; 
	
	//$uzmi_toket 		= addslashes($_SESSION['uzmi_toket']);
	$ime 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));
	$email 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	$slotovi_lite 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove'])));
	$slotovi_prem 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove2'])));
	$serverName 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['naziv'])));
	$lokacija 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['lokacija'])));
	$drzava 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['drzava'])));
	$nacin_p 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['nacinplacanja'])));
	$mjeseci 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mjeseci'])));
	$cena 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['cijenaserverainput'])));
	$d 					= date("d-m-Y");
	$v 					= date("h.m.s");
	if ($ime == ""||$email == ""||$serverName == ""||$lokacija == ""||$drzava == ""||$nacin_p == ""||$mjeseci == ""||$cena == "") {
		$_SESSION['error'] = "Morate popuniti sva polja.";
		header("Location: $_SERVER[HTTP_REFERER]");
        die();
	}
	if ($slotovi_lite == "") {
		$slotovi = $slotovi_prem;
	} else {
		$slotovi = $slotovi_lite;
	}

	//Klijent id
	//iznos-cena
	//datum
	//status
	//vreme
	//slotovi 
	//lokacija
	//placaza
	//description
	//paytype

	$billing_desc = "Game: Call Of Duty 2 | ServerName: $serverName | Lokacija: $lokacija | Cena: $cena";
	$spremi = mysql_query("INSERT INTO `billing` (`id`, `klijentid`, 
														`iznos`, 
														`datum`, 
														`status`, 
														`vreme`, 
														`slotovi`, 
														`lokacija`, 
														`placaza`, 
														`description`, 
														`paytype`) VALUES(NULL, '$_SESSION[userid]', 
																				'$cena', 
																				'$d', 
																				'Na cekanju', 
																				'$v', 
																				'$slotovi',
																				'$lokacija', 
																				'$mjeseci', 
																				'$billing_desc', 
																				'$nacin_p')");
	if (!$spremi) {
		$_SESSION['error'] = "Doslo je do greske prilikom narucivanja vaseg servera... Javite se na info@gamehoster.biz .";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	} else {
		$_SESSION['info'] = "Uspesno ste narucili svoj server, na e-mail ce vam stici sva obavestenja.";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	}
}

/* Naruci server | Call Of Duty 4 */

if (isset($_GET['task']) && $_GET['task'] == "buy_cod4") {
	
	$user_ip = $_SERVER['REMOTE_ADDR']; 
	
	//$uzmi_toket 		= addslashes($_SESSION['uzmi_toket']);
	$ime 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));
	$email 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	$slotovi_lite 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove'])));
	$slotovi_prem 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove2'])));
	$serverName 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['naziv'])));
	$lokacija 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['lokacija'])));
	$drzava 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['drzava'])));
	$nacin_p 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['nacinplacanja'])));
	$mjeseci 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mjeseci'])));
	$cena 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['cijenaserverainput'])));
	$d 					= date("d-m-Y");
	$v 					= date("h.m.s");
	if ($ime == ""||$email == ""||$serverName == ""||$lokacija == ""||$drzava == ""||$nacin_p == ""||$mjeseci == ""||$cena == "") {
		$_SESSION['error'] = "Morate popuniti sva polja.";
		header("Location: $_SERVER[HTTP_REFERER]");
        die();
	}
	if ($slotovi_lite == "") {
		$slotovi = $slotovi_prem;
	} else {
		$slotovi = $slotovi_lite;
	}

	//Klijent id
	//iznos-cena
	//datum
	//status
	//vreme
	//slotovi 
	//lokacija
	//placaza
	//description
	//paytype

	$billing_desc = "Game: Call Of Duty 4 | ServerName: $serverName | Lokacija: $lokacija | Cena: $cena";
	$spremi = mysql_query("INSERT INTO `billing` (`id`, `klijentid`, 
														`iznos`, 
														`datum`, 
														`status`, 
														`vreme`, 
														`slotovi`, 
														`lokacija`, 
														`placaza`, 
														`description`, 
														`paytype`) VALUES(NULL, '$_SESSION[userid]', 
																				'$cena', 
																				'$d', 
																				'Na cekanju', 
																				'$v', 
																				'$slotovi',
																				'$lokacija', 
																				'$mjeseci', 
																				'$billing_desc', 
																				'$nacin_p')");
	if (!$spremi) {
		$_SESSION['error'] = "Doslo je do greske prilikom narucivanja vaseg servera... Javite se na info@gamehoster.biz .";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	} else {
		$_SESSION['info'] = "Uspesno ste narucili svoj server, na e-mail ce vam stici sva obavestenja.";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	}
}

/* Naruci server | Team-Speak 3 */

if (isset($_GET['task']) && $_GET['task'] == "buy_ts3") {
	
	$user_ip = $_SERVER['REMOTE_ADDR']; 
	
	//$uzmi_toket 		= addslashes($_SESSION['uzmi_toket']);
	$ime 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));
	$email 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	$slotovi_lite 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove'])));
	$slotovi_prem 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove2'])));
	$serverName 		= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['naziv'])));
	$lokacija 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['lokacija'])));
	$drzava 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['drzava'])));
	$nacin_p 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['nacinplacanja'])));
	$mjeseci 			= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mjeseci'])));
	$cena 				= htmlspecialchars(mysql_real_escape_string(addslashes($_POST['cijenaserverainput'])));
	$d 					= date("d-m-Y");
	$v 					= date("h.m.s");
	if ($ime == ""||$email == ""||$serverName == ""||$lokacija == ""||$drzava == ""||$nacin_p == ""||$mjeseci == ""||$cena == "") {
		$_SESSION['error'] = "Morate popuniti sva polja.";
		header("Location: $_SERVER[HTTP_REFERER]");
        die();
	}
	if ($slotovi_lite == "") {
		$slotovi = $slotovi_prem;
	} else {
		$slotovi = $slotovi_lite;
	}

	//Klijent id
	//iznos-cena
	//datum
	//status
	//vreme
	//slotovi 
	//lokacija
	//placaza
	//description
	//paytype

	$billing_desc = "Game: Team-Speak 3 | ServerName: $serverName | Lokacija: $lokacija | Cena: $cena";
	$spremi = mysql_query("INSERT INTO `billing` (`id`, `klijentid`, 
														`iznos`, 
														`datum`, 
														`status`, 
														`vreme`, 
														`slotovi`, 
														`lokacija`, 
														`placaza`, 
														`description`, 
														`paytype`) VALUES(NULL, '$_SESSION[userid]', 
																				'$cena', 
																				'$d', 
																				'Na cekanju', 
																				'$v', 
																				'$slotovi',
																				'$lokacija', 
																				'$mjeseci', 
																				'$billing_desc', 
																				'$nacin_p')");
	if (!$spremi) {
		$_SESSION['error'] = "Doslo je do greske prilikom narucivanja vaseg servera... Javite se na info@gamehoster.biz .";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	} else {
		$_SESSION['info'] = "Uspesno ste narucili svoj server, na e-mail ce vam stici sva obavestenja.";
		header("Location: $_SERVER[HTTP_REFERER]");
		die();
	}
}

?>