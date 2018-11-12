<?php
include('fnc/ostalo.php');

if (is_login() == false) {
    $_SESSION['error'] = "Niste ulogovani.";
    header("Location: /home");
    die();
} else {
    $server_id = ispravi_text($_GET['id']);
    $server = mysql_fetch_array(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));
    
    if (!$server) {
        $_SESSION['error'] = "Taj server ne postoji ili nemas ovlascenje za isti.";
        header("Location: /gp-home.php");
        die();
    }

    $info = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$server[box_id]'"));
}

?>
<!DOCTYPE html>
<html>
<?php include('style/head.php'); ?>
<body>
    <!-- Error script -->
    <?php include('style/err_script.php'); ?>
    
    <!-- HEADER BOX -->

    <?php include('style/header.php'); ?>

    <!-- LOGIN BOX --> 

    <?php include('style/login_provera.php'); ?>

    <div id="space" style="margin-top: 200px;"></div>

    <!-- NAV BOX -->

    <?php include('style/navigacija.php'); ?>

    <div id="ServerBox">
        <div id="server_info_menu">
            <div class="sNav">
                <li><a href="gp-home.php">Vesti</a></li>
                <li><a href="gp-servers.php">Serveri</a></li>
                <li><a href="gp-billing.php">Billing</a></li>
                <li><a href="gp-support.php">Podrška</a></li>
                <li><a href="gp-settings.php">Podešavanja</a></li>
                <li><a href="gp-iplog.php">IP Log</a></li>
                <li><a href="logout.php">Logout</a></li> 
            </div>
        </div>

        <div id="server_info_infor">

            <div id="server_info_infor2">
                <div id="ftp_header">
                    <div id="left_header">
                        <div style="margin-top:15px;color: #fff;">
                            <strong><?php echo $server['name']; ?></strong>
                        </div>
                    </div>
                    <div id="right_header">
                        <div class="info_buttn">
                            <!-- stop/start/restart/reinstall/kill -->
                            <?php include('style/s_s_r_r_k.php'); ?>
                        </div>
                    </div>
                </div>
                <!-- Server meni precice -->
                <div class="space" style="margin-top: 20px;"></div>
                <?php include('style/server_nav_precice.php'); ?>

                <div id="ftp_container">
                    <div id="ftp_header">
                        <div id="left_header">
                            <div>
                                <img src="/img/icon/gp/gp-konzola.png">
                            </div> 
                            <div style="margin-top:15px;color: #fff;">
                                <strong>Konzola</strong>
                                <p>Ovde mozete slati komande koje ce biti izvrsene na serveru.
                                <br/>Konzola se refresuje automatcki svakih 5sec.</p>
                            </div>
                        </div>
                    </div>              
                    <div id="console_body">
                        <div id="konzolaajax" serverid="<?php echo $server_id; ?>">
                            <div style="margin-top: 20px;"></div>
<pre style="width: 100%;height: 550px;background: none;color: #fff;">
    <?php
        if(!($con = ssh2_connect($info['ip'], $info['sshport']))) { 
            return "error";
        } else {
            if(!ssh2_auth_password($con, $server['username'], $server['password'])) {
                return "error";
            } else {
                $stream = ssh2_exec($con,'tail -n 1000 screenlog.0'); 
                stream_set_blocking($stream, true );

                while ($line=fgets($stream)){ 
                    if (!preg_match("/rm log.log/", $line) || !preg_match("/Creating bot.../", $line)){
                        $resp .= $line; 
                    }
                } 

                if(empty($resp)){ 
                    $result_info = "Could not load console log";
                } else { 
                    $result_info = $resp;
                }
            }
        }

        $result_info = str_replace("/home", "", $result_info);
        $result_info = str_replace("/home", "", $result_info);  
        $result_info = str_replace(">", "", $result_info);

        if($server['igra'] == "2") {
			$filename = "ftp://$server[username]:$server[password]@$info[ip]:21/server_log.txt";
			$text .= file_get_contents($filename);
			echo $text;
        } 
	else if($server['igra'] == "3") {
			$filename = "ftp://$server[username]:$server[password]@$info[ip]:21/logs/latest.log";
			$text .= file_get_contents($filename);
			echo $text;

	}
	else

	 {
			$text .= htmlspecialchars($result_info);
			echo $text;
        }
    ?>
</pre>
                            
                            <?php if ($server['igra'] == "1") {
                                $rcon_provera = cscfg('rcon_password', $server['id']);
                                if(!$rcon_provera == "") { ?>
                                    <form action="process.php?task=console_rcon_com" method="POST">
                                        <input hidden="" type="text" name="server_id" value="<?php echo $server['id']; ?>" required="">
                                        <input type="text" name="komanda" placeholder="amx_map <mapname>" required="" style="background: none;border: 1px solid #ccc;padding: 5px 10px;border-radius: 2px;color: #fff;width: 250px;">
                                        <button style="background: none;padding: 5px 10px;border: 1px solid #ccc;border-radius: 2px;color: #fff;">></button>
                                    </form>
                                    <p style="color:#ccc;"><span style="color:red;">(napomena)</span> koristite input bez zagrada, navodnika i html znakova jer u suprotnom skripta nece raditi kako treba!</p>
                                <?php }
                            } ?>
                            <?php if ($server['igra'] == "3") { ?>
                                    <form action="process.php?task=console_rcon_com_mc" method="POST">
                                        <input hidden="" type="text" name="server_id" value="<?php echo $server['id']; ?>" required="">
                                        <input type="text" name="komanda" placeholder="amx_map <mapname>" required="" style="background: none;border: 1px solid #ccc;padding: 5px 10px;border-radius: 2px;color: #fff;width: 250px;">
                                        <button style="background: none;padding: 5px 10px;border: 1px solid #ccc;border-radius: 2px;color: #fff;">></button>
                                    </form>
                                    <p style="color:#ccc;"><span style="color:red;">(napomena)</span> koristite input bez zagrada, navodnika i html znakova jer u suprotnom skripta nece raditi kako treba!</p>
                                <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Php script :) -->

    <?php include('style/footer.php'); ?>

    <?php include('style/pin_provera.php'); ?>

    <?php include('style/java.php'); ?>

</body>
</html>