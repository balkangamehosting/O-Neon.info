<?php
session_start();

include("konfiguracija.php");
include("includes.php");

$naslov = "Početna";
$fajl = "index";

$logovi = mysql_query("SELECT * FROM `logovi` WHERE `clientid` IS NULL ORDER BY `id` DESC LIMIT 20");
$logovisms = mysql_query("SELECT * FROM `billing_sms` ORDER BY `id` DESC LIMIT 20");

include("assets/header.php");

$admini = mysql_query("SELECT * FROM `admin` ORDER BY `status`");

$smajlici = "<a href='#' id='smajlici2' kod=':D'><img src='./assets/smajli/002.png' /></a> ".
			"<a href='#' id='smajlici' kod=':P'><img src='./assets/smajli/104.png' /></a> ".
			"<a href='#' id='smajlici' kod='o.o'><img src='./assets/smajli/012.png' /></a> ".
			"<a href='#' id='smajlici' kod=':)'><img src='./assets/smajli/001.png' /></a> ".
			"<a href='#' id='smajlici' kod='xD'><img src='./assets/smajli/xD.png' /></a> ".
			"<a href='#' id='smajlici' kod=':m'><img src='./assets/smajli/006.png' /></a> ".
			"<a href='#' id='smajlici' kod=';)'><img src='./assets/smajli/003.gif' /></a> <br />".
			"<a href='#' id='smajlici' kod=':o'><img src='./assets/smajli/004.png' /></a> ".
			"<a href='#' id='smajlici' kod='3:)'><img src='./assets/smajli/007.png' /></a> ".
			"<a href='#' id='smajlici' kod=':$'><img src='./assets/smajli/008.png' /></a> ".
			"<a href='#' id='smajlici' kod=':S'><img src='./assets/smajli/009.png' /></a> ".
			"<a href='#' id='smajlici' kod=':('><img src='./assets/smajli/010.png' /></a> ".
			"<a href='#' id='smajlici' kod=';('><img src='./assets/smajli/011.png' /></a> ".
			"<a href='#' id='smajlici' kod='<3'><img src='./assets/smajli/015.png' /></a> <br />".
			"<a href='#' id='smajlici' kod='</3'><img src='./assets/smajli/016.png' /></a> ".
			"<a href='#' id='smajlici' kod=':/'><img src='./assets/smajli/083.png' /></a> ".
			"<a href='#' id='smajlici' kod=':ninja'><img src='./assets/smajli/086.png' /></a> ".
			"<a href='#' id='smajlici' kod=':P'><img src='./assets/smajli/104.png' /></a> ".
			"<a href='#' id='smajlici' kod=':T'><img src='./assets/smajli/tuga.gif' /></a> ";
		
$cron = mysql_fetch_assoc(mysql_query( "SELECT `value` FROM `config` WHERE `setting` = 'lastcronrun' LIMIT 1" ));
$cronbox = mysql_fetch_assoc(mysql_query( "SELECT `value` FROM `config` WHERE `setting` = 'lastcronboxrun' LIMIT 1" ));
$cronlgsl = mysql_fetch_assoc(mysql_query( "SELECT `value` FROM `config` WHERE `setting` = 'lastcronlgslrun' LIMIT 1" ));
$lgsl_cron = mysql_fetch_assoc(mysql_query( "SELECT `value` FROM `config` WHERE `setting` = 'lgsl_cron' LIMIT 1" ));
$cache_grafik = mysql_fetch_assoc(mysql_query( "SELECT `value` FROM `config` WHERE `setting` = 'cache_grafik' LIMIT 1" ));
$nmbmasine = mysql_query( "SELECT * FROM `box`" );
$masinenum = mysql_num_rows($nmbmasine);

$tiketsql = "SELECT * FROM `tiketi` WHERE `status` = '1' OR `status` = '4' OR `status` = '5' ORDER BY `status`, `id`";
$tiketresult = mysql_query($tiketsql);
?>
    
		
			<div class="main">
		<div class="main-inner">
			<div class="container">
				<div class="row">
					<!-- Stats -->
					<div class="span12">
						<div class="widget widget-nopad">
							<div class="widget-header">
								<i class="icon-list-alt"></i>
								<h3> Statistika</h3>
								<div id="target-1"></div>
							</div>
							
							<div class="widget-content">
								<div class="widget big-stats-container">
									<div class="widget-content">
										<div id="big_stats" class="cf">
											<div class="stat">
												<i class="icon-signal"></i> 
												<span class="value" style="color:#fff;"><?php echo br_statistika('klijenti'); ?></span>
												<br />
												<span>Korisnika</span> 
											</div>

											<div class="stat"> 
												<i class="icon-comments-alt"></i> 
												<span class="value" style="color:#fff;"><?php echo $tiketi_novi; ?></span> 
												<br />
												<span>Tiketa</span> 
											</div>
											
											<div class="stat"> 
												<i class="fa fa-gamepad"></i> 
												<span class="value" style="color:#fff;"><?php echo br_statistika('serveri'); ?></span> 
												<br />
												<span>Servera</span> 
											</div>

											<div class="stat"> 
												<i class="fa fa-server"></i> 
												<span class="value" style="color:#fff;"><?php echo $masinenum ?></span> 
												<br />
												<span>Masina</span> 
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

		
		
							<div class="span8">			
						<div class="widget stacked">
							<div class="widget-header">
								<i class="icon-signal"></i>				
								<h3>Chat</h3>
								<?php 	if(pristup()){	?>
								<div class="right" style="margin-right:10px;">
									<button class="btn btn-danger" onclick="Chat_IzbrisiSve()">
										<i class="fa fa-remove"></i> Delete all messages
									</button>
								</div>
								<?php	}	?>
							</div>

							<div class="widget-content" style="height: 250px;">				
								<div id="chat_main">
									<div id="chat_messages1">
										<div id="chat_messages">
											<ul style="margin: 0 0 0px 0px">

							</ul>
									
										</div>
									</div>		
								</div>

								<div class="down_inp_send_msg">
									<input type="text"  id="chat_text" placeholder="Zabranjen spam i vredjanje..."  onsubmit="Chat_Send()"  />
									<button onclick="Chat_Send()"> <i class="fa fa-chevron-right"></i> </button>
								</div>
							</div>
						</div>
					</div>
				<!-- News ticket -->
					<div class="span4">
						<div class="widget widget-nopad">
							<div class="widget-header"> 
								<i class="icon-list-alt"></i>
								<h3> Novi tiketi </h3>
								<div id="target-3"></div>
							</div>

							<div class="widget-content">
								<ul class="news-items">
																<?php 
																	if(mysql_num_rows($tiketresult) == 0) {
								?>
									<li style="width:100%;">
										<div class="news-item-detail">
											<a  class="news-item-title">
												Trenutno nema otvorenih tiketa
											</a>
							
										</div>
									</li>

							<?php
							}else {
										$count = 0;
							while($row = mysql_fetch_array($tiketresult)) {	

											$klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '".$row['user_id']."'");
											$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '".$row['server_id']."'");
											
											$drz = query_fetch_assoc("SELECT * FROM `tiketi_odgovori` WHERE `tiket_id` = '".$row['id']."'");
											$drz = explode("Drzava: <m>", $drz['odgovor']);
											
											if($server['igra'] == "1") $igra = 'game-cs.png';
											else if($server['igra'] == "2") $igra = 'game-samp.png';
											else if($server['igra'] == "4") $igra = 'game-cod4.png';
											else if($server['igra'] == "3") $igra = 'game-minecraft.png'; ?>
									<li style="width:100%;">
										<div class="news-item-date"> 
											<span class="news-item-day">14</span> 
											<span class="news-item-month">Apr</span> 
										</div>

										<div class="news-item-detail">
											<a href="tiket.php?id=<?php echo $row['id']; ?>" class="news-item-title">
												<?php echo $row['naslov']; ?>
											</a>
											<p class="news-item-preview" style="color:#bbb;">
											<?php echo $row['poruka']; ?>
											</p>
							
										</div>
									</li>
									<?php }}?>
								</ul>
							</div>
						</div>
					</div>

						<div class="span4">
						<div class="widget widget-nopad">
							<div class="widget-header"> 
								<i class="icon-list-alt"></i>
								<h3> Staff Online </h3>
								<div id="target-3"></div>
							</div>
<div class="widget-content">
						<div class="news-item-detail">
						<div id="onlinea">
							<ul class="news-items">
							
							</ul>
						</div>	
</div>
					</div>
</div>
				</div> <!-- /widget-content -->
					
			</div> <!-- /widget -->


				</div>
			</div>
		</div>
	</div>

<?php
include("assets/footer.php");
?>