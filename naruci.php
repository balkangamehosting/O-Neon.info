<?php 

$game = $_GET['game'];

$pp_provera   = explode("/", $_SERVER['REQUEST_URI']);
$ip      = $pp_provera[0];
$ip2     = $pp_provera[1];
$ip3     = $pp_provera[2];

if ($game == "cs") {
	$igra = "Counter-Strike 1.6";
} else if ($game == "cs-go") {
	$igra = "Counter-Strike: GO";
} else if ($game == "gta") {
	$igra = "GTA San Andreas";
} else if ($game == "cod2") {
	$igra = "Call of Duty 2";
} else if ($game == "cod4") {
	$igra = "Call of Duty 4";
} else if ($game == "mc") {
	$igra = "Minecraft";
} else if ($game == "ts3") {
	$igra = "TeamSpeak3";
} else {
	$igra = "Ovu igru nemamo u ponudi.";
	$game = "logo";
}

/* 
	
	if(isset($_POST['naruciserver'])) {

		$ime = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));  				
		$email = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));		
		$game = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteigru'])));
		$slotovi = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['odaberiteslotove'])));
		$nacin_placanja = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['nacinplacanja'])));
		$cena = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['cijenaserverainput'])));
		$lokacija = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['lokacija'])));

		$subject = "Narucili ste server! INFO";

		$msg = 	"Zdravo $ime, uspesno ste narucili server na demo-hosting.info.". "\r\n\r\n\r\n" .
		"Podaci o narudzbini:". "\r\n\r\n\r\n" .
		"Ime: <b>$ime</b>". "\r\n\r\n\r\n" .
		"Email: <b>$email</b>". "\r\n\r\n\r\n" .
		"Igra: <b>$game</b>". "\r\n\r\n\r\n" .	
		"Broj slotova: <b>$slotovi</b>". "\r\n\r\n\r\n" .	
		"Nacin placanja: <b>$nacin_placanja</b>". "\r\n\r\n\r\n" .
		"Lokacija: <b>$lokacija</b>". "\r\n\r\n\r\n" .						
		"Cena za uplatu: <b>$cena</b>". "\r\n\r\n\r\n" .
		"Slika uplatnice za Srbiju: http://slikauplatice.rs/ ". "\r\n\r\n\r\n" .						
		"Kada uplatite server slikate uplatnicu i sliku posaljite na <b>info@demohosting.info</b>". "\r\n\r\n\r\n";

		$from = $email;
		$to = $from;

		if(mail($to, $subject, $msg, $from)) {
			$_SESSION['ok'] = "Uspesno ste narucili server! Podaci poslati na $email";
			header("Location:index.php");
			die();
		};	

		$_SESSION['error'] = "Doslo je do greske!";
		header("Location:index.php");
		die();

	}

*/

?>

<?php if ($ip == "" AND $ip3 == "") { ?>

<div id="cards_container2">
	<div class="card">
		<div class="top_card">
			<span style="color: #076ba6;"><i class="glyphicon glyphicon-link"></i></span> Igra: Counter-Strike 1.6
		</div>
		<div class="card_img">
			<img src="/img/icon/game/cs.png">
			<div class="bottom_img">
				<p>12 SLOTOVA</p>
				<p>CENA: 4.50 &#x20AC;</p>
			</div>
		</div>
		<div class="buttons_container">
			<a class="vise_info" href="#">Vise Info</a>
			<a class="naruci" href="/naruci/cs">Naruci</a>
		</div>
	</div>
	<div class="card">
		<div class="top_card">
			<span style="color: #076ba6;"><i class="glyphicon glyphicon-link"></i></span> Igra: Counter-Strike: GO
		</div>
		<div class="card_img">
			<img src="/img/icon/game/cs-go.png">
			<div class="bottom_img">
				<p>12 SLOTOVA</p>
				<p>CENA: 5.27 &#x20AC;</p>
			</div>
		</div>
		<div class="buttons_container">
			<a class="vise_info" href="#">Vise Info</a>
			<a class="naruci" href="/naruci/cs-go">Naruci</a>
		</div>
	</div>
	<div class="card">
		<div class="top_card">
			<span style="color: #076ba6;"><i class="glyphicon glyphicon-link"></i></span> Igra: GTA San Andreas
		</div>
		<div class="card_img">
			<img src="/img/icon/game/gta.png">
			<div class="bottom_img">
				<p>50 SLOTOVA</p>
				<p>CENA: 1.00 &#x20AC;</p>
			</div>
		</div>
		<div class="buttons_container">
			<a class="vise_info" href="#">Vise Info</a>
			<a class="naruci" href="/naruci/gta">Naruci</a>
		</div>
	</div>
	<div class="card">
		<div class="top_card">
			<span style="color: #076ba6;"><i class="glyphicon glyphicon-link"></i></span> Igra: Minecraft
		</div>
		<div class="card_img">
			<img src="/img/icon/game/mc.png">
			<div class="bottom_img">
				<p>1 GB</p>
				<p>CENA: 4 &#x20AC;</p>
			</div>
		</div>
		<div class="buttons_container">
			<a class="vise_info" href="#">Vise Info</a>
			<a class="naruci" href="/naruci/mc">Naruci</a>
		</div>
	</div>
	<div class="card">
		<div class="top_card">
			<span style="color: #076ba6;"><i class="glyphicon glyphicon-link"></i></span> Igra: Call of Duty 2
		</div>
		<div class="card_img">
			<img src="/img/icon/game/cod2.png">
			<div class="bottom_img">
				<p>12 SLOTOVA</p>
				<p>CENA: 4.50 &#x20AC;</p>
			</div>
		</div>
		<div class="buttons_container">
			<a class="vise_info" href="#">Vise Info</a>
			<a class="naruci" href="/naruci/cod2">Naruci</a>
		</div>
	</div>
	<div class="card">
		<div class="top_card">
			<span style="color: #076ba6;"><i class="glyphicon glyphicon-link"></i></span> Igra: Call of Duty 4
		</div>
		<div class="card_img">
			<img src="/img/icon/game/cod4.png">
			<div class="bottom_img">
				<p>12 SLOTOVA</p>
				<p>CENA: 4.50 &#x20AC;</p>
			</div>
		</div>
		<div class="buttons_container">
			<a class="vise_info" href="#">Vise Info</a>
			<a class="naruci" href="/naruci/cod4">Naruci</a>
		</div>
	</div>
	<div class="card">
		<div class="top_card">
			<span style="color: #076ba6;"><i class="glyphicon glyphicon-link"></i></span> Voice: TeamSpeak 3
		</div>
		<div class="card_img">
			<img src="/img/icon/game/ts3.png">
			<div class="bottom_img">
				<p>5 SLOTOVA</p>
				<p>CENA: 0.50 &#x20AC;</p>
			</div>
		</div>
		<div class="buttons_container">
			<a class="vise_info" href="#">Vise Info</a>
			<a class="naruci" href="http://client.o-neon.info/cart.php?a=confproduct&i=0">Naruci</a>
		</div>
	</div>
	<div class="card">
		<div class="top_card">
			<span style="color: #076ba6;"><i class="glyphicon glyphicon-link"></i></span> Virtual Private Server
		</div>
		<div class="card_img">
			<img src="/img/icon/game/vps.png">
			<div class="bottom_img">
				<p>512 MB RAM ECC</p>
				<p>CENA: $1.20 USD</p>
			</div>
		</div>
		<div class="buttons_container">
			<a class="vise_info" href="#">Vise Info</a>
			<a class="naruci" href="https://client.o-neon.info">Naruci</a>
		</div>
	</div>
</div>
	
<?php } else { ?>

<!-- ORDER CS 1.6 -->
<div class="row">
<div class="col-md-12">
<div class="col-sm-5 col-md-3">
	<div class="NarServerGameImg">
		<strong><p style="color: #bbb;">Igra:<b><i style="color: #0c9ad4;"> <?php echo $igra; ?> </i></b></p></strong>
		<img src="/img/icon/game/<?php echo $game; ?>.png" style="width:228px; height:188px;">
	</div>
</div>

<div class="col-md-9 forma">

<?php }

	if($game == "cs") {
		include("fnc/cs.php");
	} else if($game == "cs-go") {
		include("fnc/csgo.php");
	} else if($game == "gta") {
		include("fnc/gta.php");
	} else if($game == "cod2") {
		include("fnc/cod2.php");
	} else if($game == "cod4") {
		include("fnc/cod4.php");
	} else if($game == "mc") {
		include("fnc/mc.php");
	} else if($game == "ts3") {
		include("fnc/ts3.php");
	}

?>