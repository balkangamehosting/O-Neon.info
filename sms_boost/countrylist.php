<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Allowed country SMS by Fortumo</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="keywords" content="gamehosting,gameserver,cs1.6,cs,gta,mc">
    <meta name="author" content="Muhamed Skoko (Kevia)">

    <link rel="shortcut icon" href="/img/logo/logo.png"> <!-- LOGO, ICON -->
   
    <!-- CSS BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		
	<style>
		input:focus,textarea:focus,button:focus,select:focus,option:focus,a:focus {
		    outline: none;
		}

		select { color: #ccc!important; } 
		option { color: #000; }

		#popUP {
		    margin-top: 100px;
		    background: #fff;
		    border: 2px solid #000;
		    border-radius: 10px;
		    padding: 10px 15px;
		}

		.popUP li {
		    display: block;
		}

		.popUP button {
		    background: none;
		    border: 1px solid #043654;
		    margin: 15px 5px;
		    display: inline-block;
		    padding: 3px 10px;
		    float: left;
		}
		
		.jezik li {
			display: inline-block;
			padding: 10px;
		}
		
	</style>

</head>
<body>

	<?php
		// Func, trazi preko get metode fajl. (rs,en,de)
		header('Cache-control: private'); // IE 6 FIX

		if (isset($_GET['lang'])) {
			$lang = $_GET['lang'];

			$_SESSION['lang'] = $lang;

			setcookie("lang", $lang, time() + (3600 * 24 * 30));
		} else if(isset($_SESSION['lang'])) {
			$lang = $_SESSION['lang'];
		} else if(isset($_COOKIE['lang'])) {
			$lang = $_COOKIE['lang'];
		} else {
			$lang = 'en';
		}

		switch ($lang) {
			case 'rs':
			$lang_file = 'jezik.rs.php';
			break;

			case 'en':
			$lang_file = 'jezik.en.php';
			break;

			case 'de':
			$lang_file = 'jezik.de.php';
			break;

			default:
			$lang_file = 'jezik.en.php';

		}
		include_once '../jezik/'.$lang_file;

		// Izaberi jezik
		if (!isset($_SESSION['lang'])) { ?>
			
			<div id="jezik" style="padding: 0 20px;">
				<div class="jezik">

					<center>
						
						<h2>Molimo izaberite jezik</h2>

						<li><a href="countrylist.php?lang=rs"><img src="/img/icon/flag/RS.png" alt=""></a></li>
						<li><a href="countrylist.php?lang=de"><img src="/img/icon/flag/DE.png" alt=""></a></li>
						<li><a href="countrylist.php?lang=en"><img src="/img/icon/flag/US.png" alt=""></a></li>
					</center>
					
				</div>
			</div>

		<?php } else { //Izvrsava komandu ukoliko je jezik i get - info popunjen ?>

			<div id="boost" style="padding: 0 20px;">
				<div class="boost">

					<h3><?php echo $jezik['boost_uplata']; ?></h3>
					<li><?php echo $jezik['boost_obv1']; ?></li>
					<li><?php echo $jezik['boost_obv2']; ?></li>
					<li><?php echo $jezik['boost_obv3']; ?></li>
					<li><?php echo $jezik['boost_obv4']; ?></li>

					<hr />

					<strong><?php echo $jezik['boost_drzave']; ?></strong>

					<br />

					<?php
			            // Sluzi za generisanje tabele sa info-om svih drzava (Ovde stavi link do svog API-a)
						$xml = simplexml_load_string( file_get_contents( "https://api.fortumo.com/api/services/2/91922a0ddc6cb60b8d3ed06169348362.7049cc6d3c1dcd26d614d6d0e25d8914.xml" ) );

						//$xml = simplexml_load_string( file_get_contents( "sms.xml" ) ); // Test
					?>

					<?php foreach( $xml->service->countries->country as $country ) { ?>
						<a data-toggle="modal" href="#<?php echo strtoupper ( $country[ 'code' ] ); ?>" style="text-decoration: none;">
							<img data-toggle="tooltip" data-placement="top" title="<?php echo $country[ 'name' ]; ?>" src="/img/icon/country/<?php echo strtoupper ( $country[ 'code' ] ); ?>.png">
						</a>
						
				        <div class="modal fade" id="<?php echo strtoupper ( $country[ 'code' ] ); ?>" role="dialog">
				            <div class="modal-dialog">
				                <div id="popUP"> 
				                    <div class="popUP">
				                    	<li style="text-align:center;float: right;">
		                                    <button type="button" data-dismiss="modal" loginClose="close"> x </button>
		                                </li>
				                        <fieldset>
			                                <h2><?php echo $jezik['boost_upustvo']; ?></h2>
			                                <ul>
			                                	<h3><?php echo $jezik['boost_primer']; ?> </h3>
			                                	<li>
			                                		<p>
			                                			<i>Primer: </i>
			                                			<strong style="text-decoration: underline;">
			                                				<?php
			                                					echo $country->prices->price->message_profile[ "keyword" ].' '."192.168.49.24:27015".' '."Kevia | send to ".$country->prices->price->message_profile[ "shortcode" ];
			                                				?>
			                                			</strong>
			                                		</p>
			                                	</li>

			                                	<hr>

			                                	<h3><?php echo $jezik['boost_info']; ?> </h3>

			                                    <li>
			                                        <p><?php echo $jezik['boost_drzava'] ?>
			                                        	<strong>
			                                        		<?php echo $country[ "name" ]; ?> 
			                                        		<img src="/img/icon/country/<?php echo strtoupper($country['code']); ?>.png">
			                                        	</strong>
			                                        </p>
			                                        <p><?php echo $jezik['boost_pare']; ?> 
			                                        	<strong>
			                                        		<?php echo $country->prices->price[ "amount" ]; ?> 
			                                        		<?php echo $country->prices->price[ "currency" ]; ?> &euro;
			                                        	</strong>
			                                        </p>
			                                        <p><?php echo $jezik['boost_kod']; ?> 
			                                        	<strong><?php echo $country->prices->price->message_profile[ "keyword" ]; ?></strong>
			                                        </p>
			                                        <p><?php echo $jezik['boost_send'] ?> 
			                                        	<strong>
			                                        		<?php echo $country->prices->price->message_profile[ "shortcode" ]; ?>
			                                        	</strong>
			                                        </p>
			                                        <p><?php echo $jezik['boost_supp'] ?> <strong><?php echo $country->promotional_text->local; ?></strong></p>
			                                    </li>
			                                </ul>
			                            </fieldset>
				                    </div>        
				                </div>  
				            </div>
				        </div>
					<?php } ?>
				</div>
			</div>

		<?php } ?>

	<!-- JAVA :) -->
	<script>
		$(document).ready(function(){
		    $('[data-toggle="modal"]').tooltip();
		});
		$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();
		});
	</script>
	
</body>
</html>