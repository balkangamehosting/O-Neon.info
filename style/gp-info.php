<?php
include 'connect_db.php';
include('style/jezik.php');

if (is_login() == false) {
    $_SESSION['error'] = "$li_error_nistelog";
    header("Location: /home");
    die();
} else {
    $server_id = $_GET['id'];
    $proveri_server = mysql_num_rows(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));

    $server = mysql_fetch_array(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));
    $server_ip = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$server[box_id]'"));

    if (!$proveri_server) {
        $_SESSION['error'] = "$li_error_nemaservera";
        header("Location: /gp-home.php");
        die();
    }
}

//LGSL - SERVER INFO
require './inc/libs/lgsl/lgsl_class.php';

$ss_ip = $server_ip['ip'];
$ss_port = $server['port'];
$info = mysql_fetch_array(mysql_query("SELECT * FROM `lgsl` WHERE ip='$ss_ip' AND q_port='$ss_port' AND c_port='$ss_port'"));

if($server['igra'] == "1") { $igras = "halflife"; }
else if($server['igra'] == "2") { $igras = "samp"; }
else if($server['igra'] == "4") { $igras = "callofduty4"; }
else if($server['igra'] == "3") { $igras = "minecraft"; }
else if($server['igra'] == "5") { $igras = "mta"; }

if($server['igra'] == "5") {
    $serverl = lgsl_query_live($igras, $info['ip'], NULL, $server['port']+123, NULL, 's');
} else {
    $serverl = lgsl_query_live($igras, $info['ip'], NULL, $server['port'], NULL, 's');
}
if(@$serverl['b']['status'] == '1') {
    $server_onli = "<span style='color:#54ff00;'>$li_serverstatus_online</span>"; 
} else {
    if ($server['startovan'] == "1") {
        $server_onli = "<span style='color:red;'>$li_serverstatus_offline</span>";
    } else {
        $server_onli = "<span style='color:red;'>$li_serverstatus_stopiran</span>";
    }
}
$server_mapa = @$serverl['s']['map'];
$server_name = @$serverl['s']['name'];
$server_play = @$serverl['s']['players'].'/'.@$serverl['s']['playersmax'];

if ($server_name == "") {
    $server_name = "n/a";
}
if ($server_mapa == "") {
    $server_mapa = "n/a";
}

?>
<!DOCTYPE html>
<html>
<?php include('style/head.php'); ?>
<body>
    <!-- Error script -->
    <?php if(isset($_SESSION['ok'])) { echo "<div id='msg_bar_ok'><p>$_SESSION[ok]</p></div>"; ?>
        <script>
            setTimeout(function(){
                if ($('#msg_bar_ok').length > 0) {
                    $('#msg_bar_ok').remove();
                }
            }, 3000);
        </script>
    <?php unset($_SESSION['ok']); } elseif(isset($_SESSION['error'])) { echo "<div id='msg_bar_error'><p>$_SESSION[error]</p></div>"; ?>
        <script>
            setTimeout(function(){
                if ($('#msg_bar_error').length > 0) {
                    $('#msg_bar_error').remove();
                }
            }, 3000);
        </script>
    <?php unset($_SESSION['error']); } elseif(isset($_SESSION['info'])) { echo "<div id='msg_bar_info'><p>$_SESSION[info]</p></div>"; ?>
        <script>
            setTimeout(function(){
                if ($('#msg_bar_info').length > 0) {
                    $('#msg_bar_info').remove();
                }
            }, 6000);
        </script>
    <?php unset($_SESSION['info']); } ?>
    <!-- header -->
   <?php include('style/header.php'); ?>

    <!-- header2 --> 

    <section>

        <li style="text-align:left; position: absolute;display: block;">
            <a href="/index.php"><img src="/img/icon/logo/logo.png" alt="LOGO"></a>
        </li>

        <?php if (is_login() == false) { ?>
            <div class="login_form">
                <ul style="width:100%;">
                    <form action="/process.php?task=login" method="POST">
                        <li class="inline" style="float:right;display:block;">
                            <ul class="inline">
                                <li style="display:block;">
                                    <span class="inline" id="span_for_name">
                                        <div class="none">
                                            <img src="/img/icon/katanac-overlay.png" style="width:33px;position:absolute;margin:3px -18px;">
                                            <img src="/img/icon/user-icon-username.png" style="width:11px;margin:9px -9px;position:absolute;">
                                        </div>
                                    </span>
                                    <input type="email" name="email" placeholder="email">
                                </li>
                                <li style="display:block;">
                                    <span class="inline" id="span_for_pass">
                                        <div class="none">
                                            <img src="/img/icon/katanac-overlay.png" style="width:33px;position:absolute;margin:3px -18px;">
                                            <img src="/img/icon/katanac-pw.png" style="width:9px;margin:9px -9px;position:absolute;">
                                        </div>
                                    </span>
                                    <input type="password" name="pass" placeholder="password">
                                </li>
                                
                                <div id="loginBox">
                                    <li><a href="">DEMO</a></li>
                                    <li><button>LOGIN <img src="/img/icon/KATANAC-submit.png" style="width: 7px;"></button></li>
                                </div>

                            </ul>
                        </li>
                    </form>
                </ul>
            </div>
        <?php } ?>
    </section>

    <div id="space" style="margin-top: 200px;"></div>

    <!-- NAVIGACIJA - MENI -->

    <nav>
        <ul>
            <li class="selected"><a href="/home">Početna</a></li>
            <li><a href="/gp-home.php">Game Panel</a></li>
            <li><a href="http://forum.gamehoster.biz/">Forum</a></li>
            <li><a href="/naruci">Naruci</a></li>
            <li><a href="/info">O nama</a></li>
            <li><a href="/kontakt">Kontakt</a></li>
            <li><a href="http://boostbalkan.com/">BoostBalkan.com</a></li>
        </ul>
        <?php if (is_login() == false) { ?>
            <div id="reg">
                <a href="#">REGISTRUJ SE</a>
            </div>
        <?php } else { ?>
            <div id="reg">
                <a href="#">MOJ PROFIL</a>
            </div>
        <?php } ?>
    </nav>

    <div id="ServerBox">
        <div id="server_info_menu">
            <div class="sNav">
                <li><a href="gp-home.php">Vesti</a></li>
                <li><a href="gp-servers.php">Serveri</a></li>
                <li><a href="gp-billing.php">Billing</a></li>
                <li><a href="gp-support.php">Podrška</a></li>
                <li><a href="gp-settings.php">Podešavanja</a></li>
                <li><a href="gp-iplog.php">IP Log</a></li>
                <li><a href="/logout.php">Logout</a></li> 
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
                            <?php if ($server['startovan'] == "1") { ?>
                                <li>
                                    <form action="process.php?task=restart_server" method="POST">
                                        <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                                        <button class="restart_btn" style="background:none;border:none;">
                                            <i class="fa fa-refresh" style="font-size: 15px;"></i> Restart
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="process.php?task=stop_server" method="POST">
                                        <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                                        <button href="" class="stop_btn" style="background:none;border:none;">
                                            <i class="fa fa-power-off" style="font-size: 15px;"></i> Stop
                                        </button>
                                    </form>
                                </li> 
                            <?php } else { ?>
                                <li>
                                    <form action="process.php?task=start_server" method="POST">
                                        <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                                        <button href="" class="start_btn" style="background:none;border:none;">
                                            <i class="fa fa-caret-right" style="font-size: 20px;"></i> Start
                                        </button>
                                    </form>
                                </li> 
                                
                                <?php if (is_pin() == false) { ?>
                                    <li>
                                        <button class="restart_btn" style="background:none;border:none;" data-toggle="modal" data-target="#pin-auth">
                                            <i class="fa fa-refresh" style="font-size: 15px;"></i> Reinstall
                                        </button>
                                    </li>
                                <?php } else { ?>
                                    <li>
                                        <form action="process.php?task=reinstall_server" method="POST">
                                            <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                                            <button class="restart_btn" style="background:none;border:none;">
                                                <i class="fa fa-refresh" style="font-size: 15px;"></i> Reinstall
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="process.php?task=obrisi_sve" method="POST">
                                            <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                                            <button class="kill_btn" style="background:none;border:none;">
                                                <i class="fa fa-power-off" style="font-size: 15px;"></i> Kill
                                            </button>
                                        </form>
                                    </li>
                                <?php } ?>
                            <?php } ?> 
                        </div>
                    </div>
                </div>
                
                <div class="space" style="margin-top: 20px;"></div>
    
                <?php if ($server['igra'] == "1") { ?>

                    <li><a href="gp-info.php?id=<?php echo $server['id']; ?>">Server</a></li>
                    <li><a href="gp-config.php?id=<?php echo $server['id']; ?>">Podesavanje</a></li>
                    <li><a href="gp-admins.php?id=<?php echo $server['id']; ?>">Admini i slotovi</a></li>
                    <li><a href="gp-webftp.php?id=<?php echo $server['id']; ?>">WebFTP</a></li>
                    <li><a href="gp-plugins.php?id=<?php echo $server['id']; ?>">Plugini</a></li>
                    <li><a href="gp-mods.php?id=<?php echo $server['id']; ?>">Modovi</a></li>
                    <li><a href="gp-console.php?id=<?php echo $server['id']; ?>">Konzola</a></li>
                    <li><a href="gp-boost.php?id=<?php echo $server['id']; ?>">Boost</a></li>
                    <li><a href="gp-autorestart.php?id=<?php echo $server['id']; ?>">Autorestart</a></li>
                        
                <?php } else if ($server['igra'] == "2") { ?>

                    <li><a href="gp-info.php?id=<?php echo $server['id']; ?>">Server</a></li>
                    <li><a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/&fajl=server.cfg">Podesavanje</a></li>
                    <li><a href="gp-webftp.php?id=<?php echo $server['id']; ?>">WebFTP</a></li>
                    <li><a href="gp-mods.php?id=<?php echo $server['id']; ?>">Modovi</a></li>
                    <li><a href="gp-console.php?id=<?php echo $server['id']; ?>">Konzola</a></li>
                    <li><a href="gp-autorestart.php?id=<?php echo $server['id']; ?>">Autorestart</a></li>
                   
                <?php } else if ($server['igra'] == "3") { ?>

                    <li><a href="gp-info.php?id=<?php echo $server['id']; ?>">Server</a></li>
                    <li><a href="gp-config.php?id=<?php echo $server['id']; ?>">Podesavanje</a></li>
                    <li><a href="gp-admins.php?id=<?php echo $server['id']; ?>">Admini i slotovi</a></li>
                    <li><a href="gp-webftp.php?id=<?php echo $server['id']; ?>">WebFTP</a></li>
                    <li><a href="gp-plugins.php?id=<?php echo $server['id']; ?>">Plugini</a></li>
                    <li><a href="gp-mods.php?id=<?php echo $server['id']; ?>">Modovi</a></li>
                    <li><a href="gp-console.php?id=<?php echo $server['id']; ?>">Konzola</a></li>
                    <li><a href="gp-boost.php?id=<?php echo $server['id']; ?>">Boost</a></li>
                    <li><a href="gp-autorestart.php?id=<?php echo $server['id']; ?>">Autorestart</a></li>
                   
                <?php } else if ($server['igra'] == "4") { ?>
                    <li><a href="gp-info.php?id=<?php echo $server['id']; ?>">Server</a></li>
                    <li><a href="gp-config.php?id=<?php echo $server['id']; ?>">Podesavanje</a></li>
                    <li><a href="gp-admins.php?id=<?php echo $server['id']; ?>">Admini i slotovi</a></li>
                    <li><a href="gp-webftp.php?id=<?php echo $server['id']; ?>">WebFTP</a></li>
                    <li><a href="gp-plugins.php?id=<?php echo $server['id']; ?>">Plugini</a></li>
                    <li><a href="gp-mods.php?id=<?php echo $server['id']; ?>">Modovi</a></li>
                    <li><a href="gp-console.php?id=<?php echo $server['id']; ?>">Konzola</a></li>
                    <li><a href="gp-boost.php?id=<?php echo $server['id']; ?>">Boost</a></li>
                    <li><a href="gp-autorestart.php?id=<?php echo $server['id']; ?>">Autorestart</a></li>
                <?php } else if ($server['igra'] == "5") { ?>
                    <li><a href="gp-info.php?id=<?php echo $server['id']; ?>">Server</a></li>
                    <li><a href="gp-config.php?id=<?php echo $server['id']; ?>">Podesavanje</a></li>
                    <li><a href="gp-admins.php?id=<?php echo $server['id']; ?>">Admini i slotovi</a></li>
                    <li><a href="gp-webftp.php?id=<?php echo $server['id']; ?>">WebFTP</a></li>
                    <li><a href="gp-plugins.php?id=<?php echo $server['id']; ?>">Plugini</a></li>
                    <li><a href="gp-mods.php?id=<?php echo $server['id']; ?>">Modovi</a></li>
                    <li><a href="gp-console.php?id=<?php echo $server['id']; ?>">Konzola</a></li>
                    <li><a href="gp-boost.php?id=<?php echo $server['id']; ?>">Boost</a></li>
                    <li><a href="gp-autorestart.php?id=<?php echo $server['id']; ?>">Autorestart</a></li>
                <?php } ?>

                <div class="server_infoInfo">
                    <h5>Informacije o serveru</h5>
                    <div class="SrwInfo_Info">
                        
                        <label style="color: #bbb;font-size: 12px;">Ime servera:</label>
                        <?php  
                            if (is_pin() == false) {
                                $provera_pin = "#pin-auth"; 
                            } else {
                                $provera_pin = "#edit_name";
                            }
                        ?>
                        <span>
                            <strong style="color: #0ba3fd;">
                                <?php echo $server['name']; ?>
                                <button style="background:none;border:none;color:#fff;" type="button" data-toggle="modal" data-target="<?php echo $provera_pin; ?>"><span class="fa fa-edit"></span></button>
                            </strong>
                        </span> <br/>

                        <label style="color: #bbb;font-size: 12px;">Datum isteka:</label>
                        <span>
                            <strong style="color: #0ba3fd;">
                                <?php echo $server['istice']; ?>
                                <a href="produzi.php?id=<?php echo $server['id']; ?>" style="background:none;border:none;color:#fff;"><span class="fa fa-edit"></span></a>
                            </strong>
                        </span> <br/>

                        <label style="color: #bbb;font-size: 12px;">Igra:</label>
                        <span><strong style="color: #0ba3fd;"><?php echo gp_igra($server['igra']); ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 12px;">Lokacija:</label>
                        <span>
                            <strong style="color: #0ba3fd;">
                                <?php echo gp_lokacija($server_ip['ip']); ?> 
                                <i class="fa fa-chevron-right" style="font-size: 12px;"></i>
                                <img src="img/icon/country/<?php echo gp_lokacija($server_ip['ip']); ?>.png">
                            </strong>
                        </span> <br/>

                        <label style="color: #bbb;font-size: 12px;">IP adresa:</label>
                        <span><strong style="color: #0ba3fd;"><?php echo $server_ip['ip'].':'.$server['port']; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 12px;">GP-Status:</label>
                        <?php
                            $serverStatus = $server['status'];  
                            if ($serverStatus == "Aktivan") {
                                $serverStatus = "<span style='color: #54ff00;'> Aktivan </span>";
                            } else if($serverStatus == "Suspendovan") {
                                $serverStatus = "<span style='color: #ffd800;'> Suspendovan </span>";
                            } else {
                                $serverStatus = "<span style='color: red;'> Neaktivan </span>";
                            }
                        ?> 
                        <span><strong style="color: #0ba3fd;"><?php echo $serverStatus; ?></strong></span>
                     </div>

                    <h5 class="server-activity">Grafik online igraca</h5>
                    <div id="chart"></div>
                </div>

                <div class="server_infoInfo2">
                    <h5 class="pc-icon">FTP informacije</h5>
                    <div class="ServerInfoFTP">
                        <label style="color: #bbb;font-size: 11px;">FTP IP:</label>
                        <span><strong style="color: #0ba3fd;font-size: 13px;"><?php echo $server_ip['ip']; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 11px;">FTP Port:</label>
                        <span><strong style="color: #0ba3fd;font-size: 13px;">21</strong></span> <br/>

                        <label style="color: #bbb;font-size: 11px;">FTP User:</label>
                        <span><strong style="color: #0ba3fd;font-size: 13px;"><?php echo $server['username']; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 11px;">FTP PW:</label>
                        <span>
                            <strong style="color: #0ba3fd;font-size: 13px;">
                                <?php if (is_pin() == false) { ?>
                                   [SAKRIVENA] Klikni ovde da je prikazes ------
                                   <i class="fa fa-chevron-right" style="font-size: 12px;"></i>
                                <?php } else { echo $server['password']; } ?>    
                            </strong>
                        </span> <br/>

                        <div class="prikaziFTPpW">
                            <?php if (is_pin() == false) { ?>
                            <a style="cursor: pointer;" type="button" data-toggle="modal" data-target="#pin-auth">Prikazi FTP sifru</a>
                            <?php } else { ?> 
                            <a style="cursor: pointer;" type="button" data-toggle="modal" data-target="#ftp-pw">Promeni FTP sifru</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                
                <div class="server_infoInfo3">
                    <h5 class="pc-icon">Server Status <button style="background: none; border:none;"><i class="fa fa-refresh"></i></button></h5>
                    <div class="ServerInfoFTP">
                        <label style="color: #bbb;font-size: 12px;">Server status:</label>
                        <span><strong style="color: #0ba3fd;"><?php echo $server_onli; ?></strong></span> <br/>
                        <?php if ($server['startovan'] == "1") {
                            if (@$serverl['b']['status'] == '0') { ?>
                                <label style="color: #bbb;font-size: 12px;">Moguce resenje:</label>
                                <span><strong style="color: #0ba3fd;">Izbacite zadnji plugin koji ste dodali.</strong></span> <br/> 
                        <?php } } ?> 
                        <label style="color: #bbb;font-size: 12px;">Ime servera:</label>
                        <span><strong style="color: #0ba3fd;"><?php echo $server_name; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 12px;">Mapa:</label>
                        <span><strong style="color: #0ba3fd;"><?php echo $server_mapa; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 12px;">Igraci:</label>
                        <span><strong style="color: #0ba3fd;"><?php echo $server_play; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 12px;">Rank:</label>
                        <span><strong style="color: #0ba3fd;"><?php echo $server['rank']; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 12px;">MOD:</label>
                        <span><strong style="color: #0ba3fd;"><?php echo mod_ime($server['modovi']); ?></strong></span> <br/>
                    </div>
                </div>

                <div class="grafik" style="margin: -20px 0px 20px 0px;">
                    <img src="/grafik/index.php?ip=<?php echo $server_ip['ip'].'&port='.$server['port']; ?>" alt="GRAFIK" style="width: 350px;height: 150px;">

                </div>

                <?php  
                    if ($server['igra'] == "1") { ?>
                        <ul class="ServerInfoPrecice">
                            <li class="selectFTP">
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>" >Web FTP</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/configs/" >Configs</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/plugins/" >Plugins</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/&fajl=server.cfg" >server.cfg</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/configs/&fajl=users.ini" >users.ini</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/configs/&fajl=plugins.ini" >plugins.ini</a>
                            </li>  
                        </ul>
                    <?php } elseif($server['igra'] == "2") { ?>
                        <ul class="ServerInfoPrecice">
                            <li class="selectFTP">
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>">Web FTP</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/scriptfiles" style="font-size: 10px;">SCRIPTFILES</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/&fajl=server.cfg" style="font-size: 10px;">SERVER.CFG</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/&fajl=server_log.txt" style="font-size: 10px;">SERVER_LOG.TXT</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/gamemodes" style="font-size: 10px;">GAMEMODES</a>
                            </li> 
                        </ul>
                    <?php } elseif($server['igra'] == "3") { ?>
                        <ul class="ServerInfoPrecice">
                            <li class="selectFTP">
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>" >Web FTP</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>" >SERVER.PROPERTIES</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>" >PLUGINS</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>" >LOGS</a>
                            </li>
                        </ul>
                    <?php } elseif($server['igra'] == "4") { ?>
                        <ul class="ServerInfoPrecice">
                            <li class="selectFTP">
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>" >Web FTP</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/configs/" >Configs</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/plugins/" >Plugins</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike&file=server.cfg" >server.cfg</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/configs&file=users.ini" >users.ini</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/configs&file=plugins.ini" >plugins.ini</a>
                            </li>  
                        </ul>
                    <?php } elseif($server['igra'] == "5") { ?>
                        <ul class="ServerInfoPrecice">
                            <li class="selectFTP">
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>" >Web FTP</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/configs/" >Configs</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/plugins/" >Plugins</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike&file=server.cfg" >server.cfg</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/configs&file=users.ini" >users.ini</a>
                            </li>
                            <li>
                                <a href="gp-webftp.php?id=<?php echo $server['id']; ?>&path=/cstrike/addons/amxmodx/configs&file=plugins.ini" >plugins.ini</a>
                            </li>  
                        </ul>
                <?php } ?>

            </div>
        </div>
    </div>

	<?php 
		include('footer.php');
	?>

    <?php if (is_login() == true) { ?>
        <!-- PIN (POPUP)-->
        <div class="modal fade" id="pin-auth" role="dialog">
            <div class="modal-dialog">
                <div id="popUP"> 
                    <div class="popUP">
                        <?php
                            $get_pin_toket = $_SERVER['REMOTE_ADDR'].'_p_'.randomSifra(100);
                            $_SESSION['pin_token'] = $get_pin_toket;
                        ?>
                        <form action="process.php?task=un_lock_pin" method="post" class="ui-modal-form" id="modal-pin-auth">
                            <input type="hidden" name="pin_token" value="<?php echo $get_pin_toket; ?>">
                            <fieldset>
                                <h2>PIN Code zastita</h2>
                                <ul>
                                    <li>
                                        <p>Vas account je zasticen sa PIN kodom !</p>
                                        <p>Da biste pristupili ovoj opciji, potrebno je da ga unesete u box ispod.</p>
                                    </li>
                                    <li>
                                        <label>PIN KOD:</label>
                                        <input type="password" name="pin" value="" maxlength="5" class="short">
                                    </li>
                                    <li style="text-align:center;">
                                        <button> <span class="fa fa-check-square-o"></span> Otkljucaj</button>
                                        <button type="button" data-dismiss="modal" loginClose="close"> <span class="fa fa-close"></span> Odustani </button>
                                    </li>
                                </ul>
                            </fieldset>
                        </form>
                    </div>        
                </div>  
            </div>
        </div>
        <!-- KRAJ - PIN (POPUP) -->
        
        <?php if (is_pin() == true) { ?>
            <!-- Generisi novu FTP sifru (POPUP)-->
            <div class="modal fade" id="ftp-pw" role="dialog">
                <div class="modal-dialog">
                    <div id="popUP"> 
                        <div class="popUP">
                            <?php
                                $get_pin_toket = $_SERVER['REMOTE_ADDR'].'_p_'.randomSifra(100);
                                $_SESSION['pin_token'] = $get_pin_toket;

                                $get_new_pw = randomSifra(8);
                                $_SESSION['get_new_pw'] = $get_new_pw;
                            ?>
                            <form action="process.php?task=new_ftp_pw" method="post" class="ui-modal-form" id="modal-pin-auth">
                                <input hidden type="text" name="pin_token" value="<?php echo $get_pin_toket; ?>">
                                <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                                <fieldset>
                                    <h2>Generisi novu FTP lozniku</h2>
                                    <ul>
                                        <li>
                                            <p>Dali ste sigurni da zelite da promenite FTP password?</p>
                                            <p>FTP password mozete menjat kad god hocete.</p>
                                        </li>
                                        <li>
                                            <label>FTP PASS PO ZELJI: </label>
                                            <input type="text" name="ftp_pw_kor" maxlength="8" class="short" placeholder="Za auto pw ostavite prazno" style="width: 200px;"> (max 8 karaktera) <br />
                                            <label>AUTO FTP PW: </label>
                                            <input disabled type="text" name="ftp_pw_gen" value="<?php echo $_SESSION['get_new_pw']; ?>" class="short">
                                        </li>
                                        <li style="text-align:center;">
                                            <button><span class="fa fa-check-square-o"></span> Promeni</button>
                                            <button type="button" data-dismiss="modal" loginClose="close"> <span class="fa fa-close"></span> Odustani </button>
                                        </li>
                                    </ul>
                                </fieldset>
                            </form>
                        </div>        
                    </div>  
                </div>
            </div>
            <!-- KRAJ - Generisi novu FTP sifru (POPUP) -->

            <!-- Promeni ime servera (POPUP)-->
            <div class="modal fade" id="edit_name" role="dialog">
                <div class="modal-dialog">
                    <div id="popUP"> 
                        <div class="popUP">
                            <?php
                                $get_pin_toket = $_SERVER['REMOTE_ADDR'].'_p_'.randomSifra(100);
                                $_SESSION['pin_token'] = $get_pin_toket;
                            ?>
                            <form action="process.php?task=edit_name_p" method="post" class="ui-modal-form" id="modal-pin-auth">
                                <input type="hidden" name="pin_token" value="<?php echo $get_pin_toket; ?>">
                                <input type="hidden" name="server_id" value="<?php echo $server['id']; ?>">
                                <fieldset>
                                    <h2>Promena imena</h2>
                                    <ul>
                                        <li>
                                            <p>Ovo ce promeniti ime samo u panelu!</p>
                                            <p>Promena nece biti aktivna na serveru!</p>
                                        </li>
                                        <li>
                                            <label>Ime:</label>
                                            <input type="text" name="ime_servera" class="short">
                                        </li>
                                        <li style="text-align:center;">
                                            <button> <span class="fa fa-check-square-o"></span> Sacuvaj</button>
                                            <button type="button" data-dismiss="modal" loginClose="close"> <span class="fa fa-close"></span> Odustani </button>
                                        </li>
                                    </ul>
                                </fieldset>
                            </form>
                        </div>        
                    </div>  
                </div>
            </div>
            <!-- KRAJ - Promeni ime servera (POPUP) -->
        <?php } ?>

    <?php } ?>

    <!-- JAVA :) -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
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