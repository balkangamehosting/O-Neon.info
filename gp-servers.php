<?php
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
                        <img src="/img/icon/gp/gp-server.png" alt="" style="position:absolute;margin-left:20px;">
                        <h2>Serveri</h2>
                        <h3 style="font-size: 12px;">Lista svih vasih servera</h3>
                        <div class="space" style="margin-top: 60px;"></div>
                        
                        <div id="serveri">
                            <table>
                                <tbody>
                                    <tr>
                                        <th>Ime servera</th>
                                        <th>Vazi do</th>
                                        <th>Cena</th>
                                        <th>IP adresa</th>
                                        <th>Slotovi</th>
                                        <th>Status</th>
                                    </tr>
                                    <?php  
                                        $gp_obv = mysql_query("SELECT * FROM `serveri` WHERE `user_id` = '$_SESSION[userid]'");

                                        while($row = mysql_fetch_array($gp_obv)) { 

                                            $srw_id = htmlspecialchars(mysql_real_escape_string(addslashes($row['id'])));
                                            $naziv_servera = htmlspecialchars(mysql_real_escape_string(addslashes($row['name'])));
                                            $istice = htmlspecialchars(mysql_real_escape_string(addslashes($row['istice'])));
                                            $box_id = htmlspecialchars(mysql_real_escape_string(addslashes($row['box_id'])));
                                            $port = htmlspecialchars(mysql_real_escape_string(addslashes($row['port'])));
                                            $slotovi = htmlspecialchars(mysql_real_escape_string(addslashes($row['slotovi'])));
                                            $cena = htmlspecialchars(mysql_real_escape_string(addslashes($row['cena'])));
                                            $status = htmlspecialchars(mysql_real_escape_string(addslashes($row['status'])));
                                            $igra = htmlspecialchars(mysql_real_escape_string(addslashes($row['igra'])));

                                            $serverStatus = $status;  
                                            if ($serverStatus == "Aktivan") {
                                                $serverStatus = "<span style='color: green;'> Aktivan </span>";
                                            } else if($serverStatus == "Suspendovan") {
                                                $serverStatus = "<span style='color: red;'> Suspendovan </span>";
                                            } else {
                                                $serverStatus = "<span style='color: red;'> Neaktivan </span>";
                                            }

                                            if ($igra == "1") {
                                                $igra = "img/icon/gp/game/cs.ico";
                                            } else if($igra == "2") {
                                                $igra = "img/icon/gp/game/samp.jpg";
                                            } else if($igra == "3") {
                                                $igra = "img/icon/gp/game/mc.png";
                                            } else if($igra == "4") {
                                                $igra = "img/icon/gp/game/cod.png";
                                            } else if($igra == "5") {
                                                $igra = "img/icon/gp/game/csgo.jpg";
                                            } else {
                                                $igra = "img/icon/gp/game/not-fount.png";
                                            }

                                            $server_ip = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$box_id'"));
                                        ?>       
                                        <tr>
                                            <td>
                                                <img src="<?php echo $igra; ?>" style="width: 15px;">
                                                <a href="gp-info.php?id=<?php echo $srw_id; ?>"><?php echo $naziv_servera ?></a>
                                            </td>
                                            <td><?php echo $istice; ?></td>
                                            <td><?php echo $cena; ?> &euro;</td>
                                            <td class="ip"><?php echo $server_ip['ip'].':'.$port; ?></td>
                                            <td><?php echo $slotovi; ?></td>
                                            <td><div class="aktivan"><?php echo $serverStatus; ?></div></td>
                                        </tr>
                                    <?php } ?>                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="space" style="margin-bottom: 20px;"></div>
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