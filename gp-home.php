<?php
header('Content-Type: text/html; charset=utf-8');

include 'connect_db.php';

if (is_login() == false) {
	$_SESSION['error'] = "Niste ulogovani.";
    header("Location: /home");
    die();
} else {
    $proveri_servere = mysql_num_rows(mysql_query("SELECT * FROM `serveri` WHERE `user_id` = '$_SESSION[userid]'"));
    if (!$proveri_servere) {
        $_SESSION['info'] = "Nemate kod nas servera.";
        header("Location: /home");
        die();
    }
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
                <li><a href="client_process.php?task=logout">Logout</a></li> 
            </div>
        </div>

        <div id="server_info_infor">    
            <div id="server_info_infor">
                <div id="server_info_infor2">
                    <div class="space" style="margin-top: 20px;"></div>
                    <div class="gp-home">
                        
                        <div class="gp-home-right">
                            <img src="/img/icon/gp/gp-user.png" alt="" style="position: absolute;">
                            <h2>Dobrodosao u Gpanel</h2>
                            <?php  
                                $nadji = mysql_fetch_array(mysql_query("SELECT * FROM `klijenti` WHERE `klijentid` = '$_SESSION[userid]'"));
                            ?>
                            <h3><?php echo $nadji['username']; ?></h3>
                            <div class="space" style="margin-top: 60px;"></div>
                            <div class="gp-logo">
                                <a href="/home"><img src="img/icon/logo/logo.png" alt=""></a>
                            </div>
                        </div>

                        <div class="gp-home">
                            <div class="div-gp">
                                <?php  
                                    $gp_obv = mysql_query("SELECT * FROM `obavestenja` WHERE `vrsta` = '1' ORDER BY `id` DESC LIMIT 3");

                                    while($row = mysql_fetch_array($gp_obv)) { 

                                        $naslov = htmlspecialchars(mysql_real_escape_string(addslashes($row['naslov'])));
                                        $poruka = $row['poruka'];
                                        $datum = htmlspecialchars(mysql_real_escape_string(addslashes($row['datum'])));

                                    ?>
                                    <div class="gp-obv-ispis" style="max-width: 550px;">
                                        <p class="gp-obv-naslov">
                                            <i class="glyphicon glyphicon-chevron-right" style="font-size: 10px;"></i> 
                                            <?php echo $datum; ?> - <?php echo htmlspecialchars(mysql_real_escape_string(addslashes($naslov))); ?>
                                        </p>
                                        <p class="gp-obv-text"><?php echo $poruka; ?></p>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="space" style="margin-bottom: 40px;"></div>
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