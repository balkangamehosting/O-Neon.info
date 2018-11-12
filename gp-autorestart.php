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
                                <img src="/img/icon/gp/gp-config.png">
                            </div> 
                            <div style="margin-top:15px;color: #fff;">
                                <strong>Autorestart</strong>
                                <p>Ovde mozete podesiti vreme kada zelite da vam se server automatski restartuje svaki dan
                                <br/></p>
                            </div>
                        </div>
                    </div>              
                    <div id="plugin_body">
                        <form action="process.php?task=auto_rs_edit" method="POST">
                            <input type="hidden" name="server_id" value="<?php echo $server['id']; ?>" />
                            <select name="autorestart">
                                <option value="-1">DISABLED</option>
                                <option value="00">00:00</option>
                                <option value="01">01:00</option>
                                <option value="02">02:00</option>
                                <option value="03">03:00</option>
                                <option value="04">04:00</option>
                                <option value="05">05:00</option>
                                <option value="06">06:00</option>
                                <option value="07">07:00</option>
                                <option value="08">08:00</option>
                                <option value="09">09:00</option>
                                <option value="10">10:00</option>
                                <option value="11">11:00</option>
                                <option value="12">12:00</option>
                                <option value="13">13:00</option>
                                <option value="14">14:00</option>
                                <option value="15">15:00</option>
                                <option value="16">16:00</option>
                                <option value="17">17:00</option>
                                <option value="18">18:00</option>
                                <option value="19">19:00</option>
                                <option value="20">20:00</option>
                                <option value="21">21:00</option>
                                <option value="22">22:00</option>
                                <option value="23">23:00</option>
                            </select>
                            <button type="submit">
                                <i class="glyphicon glyphicon-ok"></i> SACUVAJ
                            </button>
                        </form>
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