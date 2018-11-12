<?php
include('./fnc/ostalo.php');

if (is_login() == false) {
    $_SESSION['error'] = "Niste ulogovani.";
    header("Location: /home");
    die();
} else {
    /*$tiket_id = htmlspecialchars(mysql_real_escape_string(addslashes($_GET['id'])));

    if ($tiket_id == "") {
        $_SESSION['error'] = "Ovaj tiket ne postoji.";
        header("Location: gp-support.php");
        die();
    }

    $tiket_info = mysql_fetch_array(mysql_query("SELECT * FROM `tiketi` WHERE `id` = '$tiket_id' AND `user_id` = '$_SESSION[userid]'"));
    if (!$tiket_info) {
        $_SESSION['error'] = "Ovaj tiket ne postoji ili nemas ovlascenje za isti.";
        header("Location: gp-support.php");
        die();
    }*/
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
                            Dobrodosli u GameHoster.biz Support panel
                            <br/>Ovde možete otvarati nove tikete ukoliko vam treba pomoć ili podrška oko servera.
                        </h3>
                        <div class="space" style="margin-top: 60px;"></div>

                        <div class="supportAkcija">
                            <li>
                                <a href="gp-newtiket.php" class="btn"><i class="fa fa-refresh"></i> Novi tiket</a>
                            </li>
                        </div>
                        <div id="tiket_body">   
                            <div class="tiket_info">
                                <div class="tiket_info_c">
                                    <div class="tiket-header">
                                        <h3>
                                            <span class="fa fa-info-circle" style="color:#076ba6;font-size:19px;"></span>
                                            Potrebna vam je pomoc? -Otvorite novi tiket!
                                        </h3>
                                    </div>
                                    
                                    <div class="tiket-content">
                                        <div class="tiket_info_home">
                                            
                                            <div class="tiket_info_home_a">
                                                <li><img src="/img/a/<?php echo user_avatar($_SESSION['userid']); ?>" alt=""></li>
                                                <li><p><strong><?php echo ime_prezime($_SESSION['userid']); ?></strong></p></li>
                                            </div>
                                            
                                            <div class="tiket_info_home_c_o">
                                                <form action="process.php?task=add_tiket" method="POST" autocomplete="off">
                                                    
                                                    <select name="server_id" id="server_id">
                                                    <?php  
                                                        $server_id_p = mysql_query("SELECT * FROM `serveri` WHERE `user_id` = '$_SESSION[userid]'");
                                                        while($row = mysql_fetch_array($server_id_p)) {
                                                            $server_name_p = ispravi_text_sql($row['name']);
                                                    ?>
                                                        <option value="<?php echo $row['id'] ?>"><?php echo $server_name_p; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                    <br/>
                                                    <input type="text" name="tiket_naslov" placeholder="Naslov" required="">

                                                    <textarea name="tiket_text" class="odgovor" placeholder="Napisite vas problem..."></textarea>
                                                    <button>POSALJI</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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