<?php
session_start();
include("konfiguracija.php");
include("includes.php");

if(empty($_GET['id']) or !is_numeric($_GET['id'])) 
{
	header("Location: index.php");
}
			if(isset($_GET['id']))
			{			
				$serverid = mysql_real_escape_string($_GET['id']);
				if(query_numrows("SELECT * FROM `serveri` WHERE `id` = '".$serverid."'") == 0) die("test");
				$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '".$serverid."'");
				$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '".$server['ip_id']."'");
				$box = query_fetch_assoc("SELECT * FROM `box` WHERE `boxid` = '".$server['box_id']."'");
				$mod = query_fetch_assoc("SELECT * FROM `modovi` WHERE `id` = '".$server['mod']."'");
				$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '".$server['user_id']."'");

				if($server['igra'] == "1") { $igras = "halflife"; $igra = "<img src='./assets/img/game-cs.png' /> Counter-Strike 1.6"; }
				else if($server['igra'] == "2") { $igras = "samp"; $igra = "<img src='./assets/img/game-samp.png' /> San Andreas Multiplayer"; }
				else if($server['igra'] == "4") { $igras = "callofduty4"; $igra = "<img src='./assets/img/game-cod4.png' /> Call Of Duty 4"; }
				else if($server['igra'] == "3") { $igras = "minecraft"; $igra = "<img src='./assets/img/game-minecraft.png' /> Minecraft"; }
				else if($server['igra'] == "5") { $igras = "mta"; $igra = "<img src='./assets/img/game-mta.png' /> Multi Theft Auto"; }
	
				if($server['startovan'] == "1")
				{
					if($server['igra'] == "5") $serverl = lgsl_query_live($igras, $boxip['ip'], NULL, $server['port']+123, NULL, 's');
					else $serverl = lgsl_query_live($igras, $boxip['ip'], NULL, $server['port'], NULL, 's');
					$srvmapa = @$serverl['s']['map'];
					$srvime = @$serverl['s']['name'];
					$srvigraci = @$serverl['s']['players'].'/'.@$serverl['s']['playersmax'];
				}

				if($srvonline == "Da") $online = '<span style="color: green;">Online</span>';
				else if($srvonline == "Ne") $online = '<span style="color: red;">Offline</span>';
				
				if($srvonline == "Da") {
					if($server['igra'] == "1") $mapa = "http://banners.gametracker.rs/map/cs/".$srvmapa;
					if($server['igra'] == "2") $mapa = "http://banners.gametracker.rs/map/samp/".$srvmapa;
					if($server['igra'] == "3") $mapa = "http://banners.gametracker.rs/map/minecraft/".$srvmapa;
					if($server['igra'] == "4") $mapa = "http://banners.gametracker.rs/map/cs/".$srvmapa;				
?>
					<p id="h2"><i class="icon-th-large"></i>  Online: <z><?php echo $srvonline; ?></p>
					<p id="h2"><i class="icon-edit-sign"></i>  Ime servera: <z><?php echo $srvime; ?></z></p>
<?php
					if($server['igra'] == "2") { 
?>
					<p id="h2"><i class="icon-edit-sign"></i>  Gamemode: <z><?php echo $gt; ?></z></p>
<?php
					}
?>
					<p id="h2"><i class="icon-flag"></i>  Mapa: <z><?php echo $srvmapa; ?></z></p>
					<p id="h2"><i class="icon-th"></i>  Igraci: <z><?php echo $srvigraci; ?></z></p>
					<div id="srvmapa">
						<img width="110px" height="90px" src="<?php echo $mapa; ?>.jpg" />
					</div>					
<?php
				} else {
?>
					<p id="h2"><i class="icon-th-large"></i>  Online: <z><?php echo $srvonline; ?></p>
<?php
					if($server['startovan'] == "1")
					{
?>
					<p id="h2"><i class="icon-asterisk"></i>  Moguće rešenje i greška: <z>Server je startovan ali nije online. Proverite da li je default mapa ispravna i da li postoji. Ako je ispravna onda izbrišite zadnji plugin koji ste dodali.</z></p>
<?php
					} else {
?>
					<p id="h2"><i class="icon-asterisk"></i> Rešenje: <z>Server je ugašen, da bi ga pokrenuli morate ga startovati klikom na dugme start ispred.</z></p>
<?php					
					}
				}
			}
?>