<?php
	$dir = "/admin";
	$admini = mysql_query("SELECT * FROM `admin`");
	$bradmini = mysql_num_rows($admini);
	
	$call = mysql_query("SELECT * FROM `klijenti`");
	$brcall = mysql_num_rows($call);	
	
	$call2 = mysql_query("SELECT * FROM `klijenti` WHERE `status` = 'Aktivacija'");
	$brcalla = mysql_num_rows($call2);	
	
        $novac_all = mysql_query("SELECT * FROM `klijenti` WHERE `novac` != '0'");
	$brnovac_all = mysql_num_rows($novac_all);

	$cb = mysql_query("SELECT * FROM `klijenti` WHERE `banovan` = '1'");
	$brcb = mysql_num_rows($cb);		

	$lastactive = mysql_query('UPDATE admin SET lastactivity = "'.$_SERVER['REQUEST_TIME'].'" WHERE id="'.$_SESSION["a_id"].'"');
	$lastactivename = mysql_query('UPDATE admin SET lastactivityname = "Pregled strane - '.$naslov.'" WHERE id="'.$_SESSION["a_id"].'"');
	
	$tiketi_novi = query_numrows("SELECT * FROM `tiketi` WHERE `status` = '1' OR `status` = '4' OR `status` = '5' OR `status` = '8' OR `status` = '10' AND `admin` = '{$_SESSION['a_id']}'");
	$tiketi_odgovoreni = query_numrows("SELECT * FROM `tiketi` WHERE `status` = '2'");
	$tiketi_zakljucani = query_numrows("SELECT * FROM `tiketi` WHERE `status` = '3'");
	$tiketi_prosl = query_numrows("SELECT * FROM `tiketi` WHERE `status` = '10'");
	$tiketi_procitani = query_numrows("SELECT * FROM `tiketi` WHERE `status` = '4'");
	
	$tiketi_billing = query_numrows("SELECT * FROM `tiketi` WHERE `status` = '8'");
	
	$tiketi_billing_svi = query_numrows("SELECT * FROM `tiketi` WHERE `naslov` LIKE 'Billing: Nova uplata %'");

	$tiketi_prosl = query_numrows("SELECT * FROM `tiketi` WHERE `status` = '10' AND `admin` = '".$_SESSION['a_id']."'");
	$error_logovi = query_numrows("SELECT * FROM `error_log` WHERE `vrsta` = '1'");
	$kerror_logovi = query_numrows("SELECT * FROM `error_log` WHERE `vrsta` = '2'");
	$bugs = query_numrows("SELECT * FROM `bug`");
	
	$brsrv = query_numrows("SELECT * FROM `serveri`");
	$braktsrv = query_numrows("SELECT * FROM `serveri` WHERE `status` = 'Aktivan'");
	$brissrv = query_numrows("SELECT * FROM `serveri` WHERE `status` = 'Istekao'");
	$brsussrv = query_numrows("SELECT * FROM `serveri` WHERE `status` = 'Suspendovan'");
	$brfreesrv = query_numrows("SELECT * FROM `serveri` WHERE `free` = 'Da'");
	
	$commentsnew = mysql_query("SELECT novo FROM `komentari` WHERE profilid = '".$_SESSION['a_id']."' and novo = '1'");
	$commentsnew = mysql_num_rows($commentsnew);
	
	$masine = mysql_query("SELECT * FROM `box` ORDER BY `boxid`");
	$brmasine = mysql_num_rows($masine);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>O-NEON.INFO | <?php echo $naslov; ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <link href="<?php echo $dir; ?>/assets/admin/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $dir; ?>/assets/admin/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $dir; ?>/assets/admin/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $dir; ?>/assets/admin/font-awesome.css" rel="stylesheet" type="text/css">        
    <link href="<?php echo $dir; ?>/assets/admin/dashboard.css" rel="stylesheet" type="text/css">        
    <link href="<?php echo $dir; ?>/assets/admin/main.css?v2" rel="stylesheet" type="text/css">        

	<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" media="all">
<link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" media="all">
<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">

<!--<script src="/admin/assets/js/jquery.min.js"></script>
<script src="/admin/assets/js/jquery-ui.js"></script>
-->
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

<body onload="Refresh()">
<div class="wrapperr">
<!-- header -->
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container"> 
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<a class="brand" href="index.php">
					<img src="<?php echo $dir; ?>/assets/img/gh_logo.png" alt="GameHoster.me LOGO!"> 
				</a>
				
				<div class="nav-collapse">
					<ul class="nav pull-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-user"></i> <span style="color:#0ba3fd;"><?php echo admin_ime($_SESSION['a_id']); ?></span> <b class="caret"></b>
							</a>

							<ul class="dropdown-menu">
								<li><a href="<?php echo $dir; ?>/mojprofil">Profile</a></li>
								<li><a href="<?php echo $dir; ?>/login_process.php?task=logout">Logout</a></li>
							</ul>
						</li>
					</ul>
				</div> 
			</div>
		</div>
	</div>

    

  
	<div class="subnavbar">
		<div class="subnavbar-inner">
			<div class="container">
				<ul class="mainnav">

				
					<li <?php if($fajl == "index") echo' class="active"';  ?>>
						<a href="<?php echo $dir; ?>/index.php">
							<i class="icon-dashboard"></i>
							<span>POČETNA</span>
						</a>	    				
					</li>
					
					<li class="dropdown<?php if($fajl == "klijenti") echo' active';  ?>">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-th"></i>
							<span>KLIJENTI<?php if(vlasnik($_SESSION['a_id'])) { ?><?php } ?></span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<?php if(vlasnik($_SESSION['a_id'])) { ?><li><a href="#klijentadd" data-toggle="modal">DODAJ NALOG</a></li><?php } ?>
							<li><a href="klijenti.php?view=all">LISTA KLIJENATA</a></li>
							<li><a href="klijenti.php?view=banovani">BANOVANI KLIJENTI</a></li>
						</ul> 				
					</li>
					
					<li class="dropdown<?php if($fajl == "server") echo' active';  ?>">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-gamepad"></i>
							<span>SERVERI</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<?php if(vlasnik($_SESSION['a_id'])) { ?><li><a href="serveradd.php">DODAJ SERVER</a></li><?php } ?>
							<li><a href="serveri.php?view=all">LISTA SVIH SERVERA</a></li>
						</ul> 				
					</li>
					
					<li class="dropdown<?php if($fajl == "tiket" OR $fajl == "tiket_lista") echo' active';  ?>">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-comments"></i>
							<span>TIKETI </span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<li><a href="tiket_lista.php?vrsta=novi">OTVORENI TIKETI</a></li>
<?php
							if(pristup())
							{
?>
							<li><a href="tiket_lista.php?vrsta=sve_uplate">SVI TIKETI</a></li>
<?php
							}
?>
						</ul> 				
					</li>					
					<!--
					<?php /* if(vlasnik($_SESSION['a_id'])) { ?>
					<li<?php if($fajl == "logovi") echo' class="active"';  ?>>
						<a href="<?php echo $dir; ?>/logovi">
							<i class="icon-align-justify"></i>
							<span>Logovi</span>
						</a>	    				
					</li>
					
					<li class="dropdown<?php if($fajl == "error_log") echo' active';  ?>">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-warning-sign"></i>
							<span>Error log</span>
							<b class="caret"></b>
						</a>	

						<ul class="dropdown-menu">
							<li><a href="<?php echo $dir; ?>/error_log">Za admin panel</a></li>
							<li><a href="<?php echo $dir; ?>/kerror_log">Za klijent panel</a></li>
						</ul> 						
					</li>
					
					<?php }*/ ?>		
					-->
<?php
							if(pristup())
							{
?>							<li class="dropdown<?php if($fajl == "modovi") echo' active';  ?>">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-code"></i>
							<span>MODOVI</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<?php if(vlasnik($_SESSION['a_id'])) { ?><li><a href="#modadd" data-toggle="modal">DODAJ NOVI MOD</a></li><?php } ?>
							<li><a href="modovi.php">LISTA MODOVA</a></li>
						</ul> 
					</li>	
					
					<li class="dropdown<?php if($fajl == "plugini") echo' active';  ?>">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-code"></i>
							<span>PLUGINI</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<?php if(vlasnik($_SESSION['a_id'])) { ?><li><a href="#pluginadd" data-toggle="modal">DODAJ NOVI PLUGIN</a></li><?php } ?>
							<li><a href="pluginovi.php">LISTA PLUGINA</a></li>
						</ul> 
					</li>

							
<?php
					}

?>					
					
					

					
					<?php if(vlasnik($_SESSION['a_id'])) { ?>
							
					<li class="dropdown<?php if($fajl == "box") echo' active';  ?>">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-hdd-o"></i>
							<span>Masine</span>
							<b class="caret"></b>
						</a>	
					
						<ul class="dropdown-menu">
							<li><a href="#dodajMasinu" data-toggle="modal">Dodaj novu masinu</a></li>
							<li><a href="box_lista.php">Pregled masina</a></li>
							<li class="dropdown-submenu">
			                  <a tabindex="-1" href="box_lista.php">Masine - <?php echo $brmasine; ?></a>
			                  <ul class="dropdown-menu">
					<?php		while($row = mysql_fetch_array($masine)) {	?>
			                    <li><a tabindex="-1" href="box.php?id=<?php echo $row['boxid']; ?>">#<?php echo $row['boxid']." ".$row['name']." - <m>".$row['ip']; ?></m></a></li>
					<?php		}	?>
			                  </ul>
			                </li>
						</ul>    				
					</li>
					<!--
					<li<?php if($fajl == "bug") echo' class="active"';  ?>>
						<a href="<?php echo $dir; ?>/bug.php">
							<i class="icon-th"></i>
							<span>Bugovi <span class="label label-warning"><?php echo $bugs; ?></span></span>
						</a>	    				
					</li>						
					-->	
				<?php } ?>
					<li class="<?php if($fajl == "admin_pregled" or $fajl == "admin_lista" or $fajl == "admini" or $fajl == "dodaj_admina") echo'active ';  ?>dropdown">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-users"></i>
							<span>Admini</span>
							<b class="caret"></b>
						</a>	
						<ul class="dropdown-menu">
							<li><a href="admin_lista.php">Pregled admina</a></li>
							<?php if($_SESSION['a_id'] <= 2) { ?><li><a href="#adminadd" data-toggle="modal">Dodaj novog admina</a></li><?php } ?>
							<li class="dropdown-submenu">
			                  <a tabindex="-1" href="admin_lista.php">Admini - <?php echo $bradmini; ?></a>
			                  <ul class="dropdown-menu">
						<?php	while($row = mysql_fetch_array($admini)) {	?>
			                    <li><a tabindex="-1" href="<?php echo $dir; ?>/admin_pregled.php?id=<?php echo $row['id']; ?>">#<?php echo $row['id']; ?> <?php echo admin_ime($row['id']) . ' - ' . get_status($row['lastactivity']); ?></a></li>
						<?php	}	?>
			                  </ul>
			                </li>
						</ul>   
					</li>
					
					<li class="<?php if($fajl == "reputacija" OR $fajl == "error_log" OR $fajl == "kerror_log" OR $fajl == "bug") echo'active ';  ?>dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-long-arrow-down"></i>
							<span>Ostalo</span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="reputacija.php"><i class="icon-align-justify"></i> Reputacija</a></li>
							<?php if(vlasnik($_SESSION['a_id'])) { ?>
							<li class="divider"></li>
							<li><a href="obavestenja.php?view=klijenti">Obaveštenja</a></li>
							<li><a href="#dodajobavestenje" data-toggle="modal">Dodaj obavestenje</a></li>
							<li><a href="vesti.php">Vesti</a></li>
							<li><a href="<?php echo $dir; ?>/errorlog"><i class="icon-warning-sign"></i> Error log <span class="label label-warning"><?php echo $error_logovi; ?></span></a></li>
							<li><a href="<?php echo $dir; ?>/kerror_log"><i class="icon-warning-sign"></i> Klijent error log <span class="label label-warning"><?php echo $kerror_logovi; ?></span></a></li>
							<li class="divider"></li>
							<li><a href="bug.php"><i class="icon-th"></i> Bugovi <span class="label label-warning"><?php echo $bugs; ?></span></a></li>
							<li class="divider"></li>
							<li><a href="#mailtoall" data-toggle="modal"><i class="icon-forward"></i> Mail</a></li>
						<?php } ?>
						</ul>
					</li>				
				</ul>
			</div> <!-- /.subnav-collapse -->

		</div> <!-- /container -->
	
	</div> <!-- /subnavbar-inner -->
 <!-- /subnavbar -->
    
    
<div class="main">

    <div class="container">	
	
<?php
require("./assets/libs/phpseclib/SSH2.php");

if (!class_exists('Net_SSH2')) {
?>
		<div class="alertt alert-error">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4 class="alert-heading">SSH2 GRESKA</h4>
			SSH2 extenzija nije instalirana.
		</div>
<?php
}

if (isset($_SESSION['msg1']) && isset($_SESSION['msg2']) && isset($_SESSION['msg-type']))
{
?>
			<div class="alert alert-<?php
	switch ($_SESSION['msg-type'])
	{
		case 'block':
			echo 'block';
			break;

		case 'error':
			echo 'error';
			break;

		case 'success':
			echo 'success';
			break;

		case 'info':
			echo 'info';
			break;
	}
?>">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<h4 class="alert-heading"><?php echo $_SESSION['msg1']; ?></h4>
				<?php echo $_SESSION['msg2']; ?>
			</div>
<?php
	unset($_SESSION['msg1']);
	unset($_SESSION['msg2']);
	unset($_SESSION['msg-type']);
}
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

if(isset($srv)) 
{
	if($srv == "1")
	{
?>	
	<h3 style="margin-top: -25px;"><?php echo $server['name']; ?></h3>
    <div class="navbar">
		<div class="navbar-inner">
			<ul class="nav">
				<li style="margin-left: -20px;"<?php if($fajl == "srv-pocetna") echo ' class="active"'; ?>><a href="srv-pocetna.php?id=<?php echo $server['id']; ?>"><i class="icon-home"></i> Server info</a></li>
				<li<?php if($fajl == "srv-podesavanja") echo ' class="active"'; ?>><a href="srv-podesavanja.php?id=<?php echo $server['id']; ?>&masina=<?php echo $server['box_id']; ?>"><i class="icon-cogs"></i> Podešavanja</a></li>
				<li<?php if($fajl == "srv-webftp") echo ' class="active"'; ?>><a href="srv-webftp.php?id=<?php echo $server['id']; ?>"><i class="icon-folder-open"></i> WebFTP</a></li>
				<li<?php if($fajl == "srv-plugini") echo ' class="active"'; ?>><a href="srv-plugini.php?id=<?php echo $server['id']; ?>"><i class="icon-cog"></i> Plugini</a></li>
				<li<?php if($fajl == "srv-modovi") echo ' class="active"'; ?>><a href="srv-modovi.php?id=<?php echo $server['id']; ?>"><i class="icon-cogs"></i> Modovi</a></li>
				<li<?php if($fajl == "srv-konzola") echo ' class="active"'; ?>><a href="srv-konzola.php?id=<?php echo $server['id']; ?>"><i class="icon-th-list"></i> Konzola</a></li>
			</ul>
		</div>
    </div>
<?php
	}
}
?>

