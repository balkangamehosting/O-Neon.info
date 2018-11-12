<!-- NAVIGACIJA - MENI -->
<?php

$lan = $_GET['lan'];
if($lan == "en") {
    $dodatni_link = "?lan=en";
} elseif($lan == "de") {
    $dodatni_link = "?lan=de";
} else {
    $dodatni_link = "";
}

?>
    <nav>
        <ul><?php include ('jezik.php'); ?>
            <a href="/home<?php echo $dodatni_link;?>"><li class="<?php echo $jedan;?>"><?php echo $li_pocetna;?></a></li>
            <a href="/gp-home.php<?php echo $dodatni_link;?>"><li class="<?php echo $dva;?>"><?php echo $li_gamepanel;?></a></li>
            <a href="http://forum.gamehoster.biz/"><li class="<?php echo $tri;?>"><?php echo $li_forum;?></a></li>
            <a href="/naruci<?php echo $dodatni_link;?>"><li class="<?php echo $cetiri;?>"><?php echo $li_naruci;?></a></li>
            <a href="/info<?php echo $dodatni_link;?>"><li class="<?php echo $pet;?>"><?php echo $li_onama;?></a></li>
            <a href="/kontakt<?php echo $dodatni_link;?>"><li class="<?php echo $sest;?>"><?php echo $li_kontakt;?></a></li>
            <a href="http://boostbalkan.com/"><li class="<?php echo $sedam;?>"><?php echo $li_boostbalkan;?></a></li>
        </ul>
        <?php if (is_login() == false) { ?>
            <div id="reg">
                <a href="#"><?php echo $li_registruj;?></a>
            </div>
        <?php } else { ?>
            <div id="reg">
                <a href="#"><?php echo $li_mojprofil;?></a>
            </div>
        <?php } ?>
    </nav>
<?php if($gppp == "1"){?>
    <div id="ServerBox">
        <div id="server_info_menu">
            <div class="sNav">
                <li><a href="gp-home.php<?php echo $dodatni_link;?>"><?php echo $li_vesti_nav;?></a></li>
                <li><a href="gp-servers.php<?php echo $dodatni_link;?>"><?php echo $li_serveri;?></a></li>
                <li><a href="gp-billing.php<?php echo $dodatni_link;?>"><?php echo $li_billing;?></a></li>
                <li><a href="gp-support.php<?php echo $dodatni_link;?>"><?php echo $li_podrska;?></a></li>
                <li><a href="gp-settings.php<?php echo $dodatni_link;?>"><?php echo $li_podesavanja;?></a></li>
                <li><a href="gp-iplog.php<?php echo $dodatni_link;?>"><?php echo $li_iplog;?></a></li>
                <li><a href="client_process.php?task=logout"><?php echo $li_logout;?></a></li> 
            </div>
        </div>
<?php } ?>
