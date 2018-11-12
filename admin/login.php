<!DOCTYPE html>
<?php
session_start();

$fajl = "login";

include("konfiguracija.php");

$naslov = "Admin login";

if (isset($_GET['task'])) $task = mysql_real_escape_string($_GET['task']);

function AdminUlogovan()
{
	if (!empty($_SESSION['a_id']) && is_numeric($_SESSION['a_id']))
	{
		$verifikacija = mysql_query( "SELECT `username` FROM `admin` WHERE `id` = '".$_SESSION['a_id']."'" );
		if (mysql_num_rows($verifikacija) == 1)
		{
			return TRUE;
		}
		unset($verifikacija);
	}
	return FALSE;
}

if (AdminUlogovan() == TRUE) { header("Location: index.php"); die(); }

?>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>O-Neon.info | Admin Panel - Login</title>

	<link rel="stylesheet" type="text/css" href="./login_files/main.css">

	<!-- CSS Povezivanje -->
    <link href="./login_files/mobile.css" rel="stylesheet" media="all">
    <link href="./login_files/signin.css" rel="stylesheet" media="all">
    <link href="./login_files/bootstrap.min.css" rel="stylesheet" media="all">
</head>
<body>
	<!-- Error script -->
	<div id="gp_msg"></div>

    <script type="text/javascript">
    	setTimeout(function() {
    		document.getElementById('gp_msg').innerHTML = "";
    	}, 5000);
    </script>

	<!-- header -->
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container"> 
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<a class="brand" href="#">
					<img src="./login_files/gh_logo.png" alt="ONEON LOGO!">
				</a>
			</div>
		</div>
	</div>

	<!-- login -->
	<div class="account-container">
		<div class="content clearfix">
			<form class="form-signin" role="form" action="login_process.php" method="POST">
			<input type="hidden" name="task" value="login" />
			<input type="hidden" name="return" value="<?php
		if (isset($_GET['return']))
		{
			echo htmlspecialchars($_GET['return'], ENT_QUOTES);
		}
?>" />
				<h1>Admin Panel</h1>		
				<div class="login-fields">
					<p>Welcome to admin panel, please login</p><?php
		if (isset($_SESSION['loginerror']))
		{
?>
			<div class="alert alert-danger">
				<a class="close" data-dismiss="alert">&times;</a>
				Neuspešan login br. <?php echo $_SESSION['loginattempt']; ?>
			</div>
<?php
			unset($_SESSION['loginerror']);
		}
		if (isset($_SESSION['msg']))
		{
?>
			<div class="alert alert-danger">
				<a class="close" data-dismiss="alert">&times;</a>
				<?php echo $_SESSION['msg']; ?>
			</div>
<?php
			unset($_SESSION['msg']);
		}
?>			
					<div class="field">

			<input name="username" type="text" class="form-control" required autofocus <?php
		if (isset($_COOKIE['adminUsername']))
		{
			$cookie = htmlspecialchars($_COOKIE['adminUsername'], ENT_QUOTES);
			echo "value=\"{$cookie}\"";
			echo " placeholder=\"Korisničko ime\"";
			unset($cookie);
		}
		else
		{
			echo "placeholder=\"Korisničko ime\"";
		}
?>></div>
					<div class="field">

			<input name="sifra" type="password" class="form-control" placeholder="Lozinka" required>
			</div>
			</div>
			<div class="login-actions">
					<span class="login-checkbox">
				<input name="rememberMe" type="checkbox" value="remember-me" checked="checked"> Ostani ulogovan
			</span>
			
					<button class="button btn btn-success btn-large">LOGIN</button>
		</div>

		</form>

		</div>
	</div>

	<div class="go_down" style="position:fixed;bottom:0;left:0;right:0;">
		<!-- footer -->
		<div class="extra">
			<div class="extra-inner">
				<div class="container">
					<div class="row">
						<div class="span12">
							<center>
								<img src="./login_files/gh_logo.png" alt="Gold Hosting LOGO!">
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer">
			<div class="footer-inner">
				<div class="container">
					<div class="row">
						<div class="span12" style="color:#fff;"> © 2015 - 2018 <a href="#">O-Neon.info</a>. </div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- JS / End -->
	<script src="./login_files/excanvas.min.js.преузимање"></script> 
<script src="./login_files/base.js.преузимање"></script> 


<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>-->
<script type="text/javascript" src="./login_files/bootstrap.min.js.преузимање"></script>
<script src="./login_files/bootstrap-select.min.js.преузимање"></script>	

</body></html>