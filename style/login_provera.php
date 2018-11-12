<section>
	<li style="text-align:left; position: absolute;display: block;">
		<a href="/index.php"><img src="/img/icon/logo/logo.png" alt="LOGO"></a>
	</li>

	<?php if (is_login() == false) { ?>
		<div class="login_form">
			<ul style="width:100%;">
				<form action="/process.php?task=login" method="POST" autocomplete="off">
					<li class="inline" style="float:right;display:block;">
						<ul class="inline">
							<li style="display:block;">
								<span class="inline" id="span_for_name">
									<div class="none">
										<img src="/img/icon/katanac-overlay.png" style="width:33px;position:absolute;margin:3px -18px;">
										<img src="/img/icon/user-icon-username.png" style="width:11px;margin:9px -9px;position:absolute;">
									</div>
								</span>
								<input type="email" name="email" placeholder="email" required autocomplete="email">
							</li>
							<li style="display:block;">
								<span class="inline" id="span_for_pass">
									<div class="none">
										<img src="/img/icon/katanac-overlay.png" style="width:33px;position:absolute;margin:3px -18px;">
										<img src="/img/icon/katanac-pw.png" style="width:9px;margin:9px -9px;position:absolute;">
									</div>
								</span>
								<input type="password" name="pass" placeholder="password" required>
							</li>
							
							<div id="loginBox">
								<li><a href="demo_login.php?email=demo@o-neon.info&pass=demo1337">DEMO</a></li>
								<li><button>LOGIN <img src="/img/icon/KATANAC-submit.png" style="width: 7px;"></button></li>
							</div>
		
						</ul>
					</li>
				</form>
			</ul>
<div style="float: right;margin: 100px -190px;">
<span class="glyphicon glyphicon-earphone" style="color: white;">
</span> <a href="ts3server://ts.o-neon.info" style="color: white;">TS.O-NEON.INFO</a>
</div>		
</div>
	<?php } else { ?>
		<div class="login_form">
			<ul style="width:100%;">
				<li class="inline" style="float:right;display:block;background:#061721;padding:10px;width:330px;">
					<div class="av" style="position: absolute;">
						<img src="<?php echo userAvatar($_SESSION['userid']); ?>" style="width:90px;height:90px;">
					</div>

					<ul class="inline" style="margin-left:60px;">
						<li style="display:block;">
							<span class="fa fa-user" style="color:#bbb;"></span> 
							<span style="color: #fff;"><?php echo userIme($_SESSION['userid']); ?></span>
						</li>
						<li style="display:block;">
							<span class="fa fa-send" style="color:#bbb;"></span> 
							<span style="color: #fff;"><?php echo userEmail($_SESSION['userid']); ?></span>
						</li>
						<li style="display:block;">
							<span class="fa fa-mail-forward" style="color:#bbb;"></span> 
							<span style="color: #fff;"><?php echo get_client_ip(); ?></span>
						</li>
						<li style="display:block;">
							<span class="fa fa-calendar" style="color:#bbb;"></span> 
							<span style="color: #fff;"><?php echo lastLogin($_SESSION['userid']); ?></span>
						</li>
						<br />
						<div id="loginBox" style="margin-left:-100px;">
							<li><a href="/gp-settings.php">EDIT</a></li>
							<li><a href="/gp-billing.php">BILLING</a></li>
							<li><a href="/client_process.php?task=logout">LOGOUT</a></li>
						</div>
					</ul>
				</li>
			</ul>
		</div>
	<?php } ?>
</section>