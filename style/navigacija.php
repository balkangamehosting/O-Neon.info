<nav>
	<ul>
		<li class="selected"><a href="/home">Početna</a></li>
		<li><a href="/gp-home.php">Game Panel</a></li>
		<li><a href="http://forum.o-neon.info">Forum</a></li>
		<li><a href="/naruci">Naruci</a></li>
		<li><a href="/info/">Vesti</a></li>
                <li><a href="https://www.facebook.com/O-neoninfo-Game-Web-Hosting-698776627149957/">Kontakt</a></li>
	</ul>
	<?php if (is_login() == false) { ?>
		<div id="reg">
			<a href="/create_user_acc.php">REGISTRUJ SE</a>
		</div>
	<?php } else { ?>
		<div id="reg">
			<a href="/mojprofil.php">MOJ PROFIL</a>
		</div>
	<?php } ?>
</nav>