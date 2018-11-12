<?php
include 'connect_db.php';

if (is_login() == false) {
    $_SESSION['error'] = "Niste ulogovani.";
    header("Location: /home");
    die();
} else {
    /*$proveri_servere = mysql_num_rows(mysql_query("SELECT * FROM `serveri` WHERE `user_id` = '$_SESSION[userid]'"));
    if (!$proveri_servere) {
        $_SESSION['info'] = "Nemate kod nas servera.";
        header("Location: /home");
        die();
    }*/

    $proveri_usera = mysql_query("SELECT * FROM `klijenti` WHERE `klijentid` = '$_SESSION[userid]'");
    if (mysql_num_rows($proveri_usera) == 0) {
        $_SESSION['info'] = "Ovaj korisnik ne postoji...";
        header("Location: /home");
        die();
    }

    $uzmi_usera = mysql_fetch_array($proveri_usera);
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
                        <img src="/img/icon/gp/gp-user.png" alt="" style="position:absolute;">
                        <h2>Moj Profil</h2>
                        <h3 style="font-size: 12px;">Ovde mozete videti vase informacije!</h3>                       
                        
                        <div class="podForm" style="">
				    <label for="avatar">AVATAR </label>
				    <img src="<?php echo userAvatar($_SESSION['userid']); ?>" alt="" style="position:absolute;margin-left:5%;width:90px;height:90px;">
				    <br/>
					<br>
					<br>	
<br>
<br>
<br>			
                                    <label for="ime">IME </label>
                                    <input disabled type="text" name="ime" value="<?php echo $uzmi_usera['ime']; ?>" style="margin-left: 100px;">
                                    <br />

                                    <label for="prezime">PREZIME </label>
                                    <input disabled type="text" name="prezime" value="<?php echo $uzmi_usera['prezime']; ?>" style="margin-left: 63px;"> <br />
									
                                    <label for="email">EMAIL </label>
                                    <input disabled name="email" value="<?php echo $uzmi_usera['email']; ?>" style="margin-left: 81px;">
                                    <?php if (is_pin() == true) { ?>
                                        <!-- <span style="margin-left:10px;color:#bbb;cursor:pointer;" data-toggle="modal" data-target="#email-auth"> Zahtijev za promenu email adrese</span> -->
                                    <?php } ?>
                                    <br>
<br>
                                    <button onclick="location.href='/gp-settings.php'" style="padding: 5px 10px;background: #076ba6;color: #fff;cursor: pointer;font-size: 12px;font-weight: bold;border: 1px solid #fff;">IZMENI PROFIL</button>
                        </div>
                    </div>
                    <div class="space" style="margin-bottom: 20px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Php script :) -->

    <?php include('style/footer.php'); ?>

    <?php include('style/java.php'); ?>

</body>
</html>
