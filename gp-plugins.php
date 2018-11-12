<?php
include 'connect_db.php';

if (is_login() == false) {
    $_SESSION['error'] = "Niste ulogovani.";
    header("Location: /home");
    die();
} else {
    $server_id = $_GET['id'];
    $proveri_server = mysql_num_rows(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));

    $server = mysql_fetch_array(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));
    
    if (!$proveri_server) {
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
                                <img src="/img/icon/gp/gp-plugins.png">
                            </div> 
                            <div style="margin-top:15px;color: #fff;">
                                <strong>Plugini</strong>
                                <p>Ovde mozete instalirati ili obrisati neki plugin sa vaseg servera</p>
                            </div>
                        </div>
                    </div>              
                    <div id="plugin_body">
                        <?php  
                            $gp_plugins = mysql_query("SELECT * FROM `plugins`");

                            while($row = mysql_fetch_array($gp_plugins)) { 

                                $plugin_id = htmlspecialchars(addslashes($row['id']));
                                $ime = htmlspecialchars(addslashes($row['ime']));
                                $deskripcija = htmlspecialchars(addslashes($row['deskripcija']));
                                $prikaz = htmlspecialchars(addslashes($row['prikaz']));
                                $text = htmlspecialchars(addslashes($row['text']));

                                $plugin_instaliran = "ftp://$server[username]:$server[password]@$info[ip]:21/cstrike/addons/amxmodx/configs/{$row['prikaz']}";

                                if (file_exists($plugin_instaliran)) { ?>
                                    <li>
                                        <p><strong><?php echo $ime; ?></strong></p>

                                        <p><?php echo nl2br($deskripcija); ?></p>
                                        <form action="process.php?task=del_ins_plugin" method="POST">
                                            <input hidden type="text" name="server_id" value="<?php echo $server_id; ?>">
                                            <input hidden type="text" name="plugin_id" value="<?php echo $plugin_id; ?>">
                                            <button>DELETE <i class="fa fa-remove"></i></button>
                                        </form>                            
                                    </li>
                                <?php } else { ?>
                                    <li>
                                        <p><strong><?php echo $ime; ?></strong></p>

                                        <p><?php echo nl2br($deskripcija); ?></p>
                                        <form action="process.php?task=install_plugin" method="POST">
                                            <input hidden type="text" name="server_id" value="<?php echo $server_id; ?>">
                                            <input hidden type="text" name="plugin_id" value="<?php echo $plugin_id; ?>">
                                            <button>INSTALL <i class="glyphicon glyphicon-ok"></i></button>
                                        </form>                            
                                    </li>
                                <?php } ?>

                        <?php } ?>
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