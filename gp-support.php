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
                        <img src="/img/icon/gp/gp-supp.png" alt="" style="position:absolute;">
                        <h2>Podrška</h2>
                        <h3 style="font-size: 12px;">
                            Dobrodosli u O-Neon.info Support panel
                            <br/>Ovde možete otvarati nove tikete ukoliko vam treba pomoć ili podrška oko servera.
                        </h3>
                        <div class="space" style="margin-top: 60px;"></div>

                        <div class="supportAkcija">
                            <li>
                                <a href="gp-newtiket.php" class="btn">Novi tiket</a>
                            </li>
                            <li>
                                <a href="gp-support.php" class="btn">Arhiva</a>
                            </li>
                        </div>
                        
                        <div id="serveri">
                            <table>
                                <tbody>
                                    <tr>
                                        <th>ID Tiketa</th>
                                        <th>Ime tiketa</th>
                                        <th>Datum</th>
                                        <th>Server</th>
                                        <th>Broj poruka</th>
                                        <th>Status</th>
                                    </tr>
                                    <?php  
                                        $gp_supp = mysql_query("SELECT * FROM `tiketi` WHERE `user_id` = '$_SESSION[userid]'");

                                        $broj_poruka = mysql_num_rows($gp_supp);

                                        while($row = mysql_fetch_array($gp_supp)) { 

                                            $srw_id = htmlspecialchars(mysql_real_escape_string(addslashes($row['server_id'])));
                                            $status = htmlspecialchars(mysql_real_escape_string(addslashes($row['status'])));
                                            $datum = htmlspecialchars(mysql_real_escape_string(addslashes($row['datum'])));
                                            $naslov = htmlspecialchars(mysql_real_escape_string(addslashes($row['naslov'])));

                                            if($status == 1){
                                                $status = 'Otvoren';
                                            }elseif($status == 4){
                                                $status = 'Pročitan';
                                            }elseif($status == 3){
                                                $status = 'Zaključan';
                                            }elseif($status == 2){
                                                $status = 'Odgovoren';
                                            }

                                            $ss_ip = mysql_fetch_array(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$srw_id'"));
                                            $server_ip = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$ss_ip[box_id]'"));
                                    ?>       
                                        <tr>
                                            <td><a href="gp-tiket.php?id=<?php echo $row['id']; ?>">#<?php echo $row['id']; ?></a></td>
                                            <td><a href="gp-tiket.php?id=<?php echo $row['id']; ?>"><?php echo $naslov; ?></a></td>
                                            <td><?php echo $datum; ?></td>
                                            <td class="ip">
                                                <a href="gp-info.php?id=<?php echo $srw_id; ?>">
                                                    <?php echo $server_ip['ip'].':'.$ss_ip['port']; ?>    
                                                </a>
                                            </td>
                                            <td><?php echo $broj_poruka; ?></td>
                                            <td><?php echo $status; ?></td>
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