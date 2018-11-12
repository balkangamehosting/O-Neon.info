<?php
include('./fnc/ostalo.php');

if (is_login() == false) {
    $_SESSION['error'] = "Niste ulogovani.";
    header("Location: /home");
    die();
} else {
    $bill_id = htmlspecialchars(mysql_real_escape_string(addslashes($_GET['id'])));

    if ($bill_id == "") {
        $_SESSION['error'] = "Ova narudzba ne postoji ili nemas ovlascenje za istu.";
        header("Location: gp-billing.php");
        die();
    }

    $billing_info = mysql_fetch_array(mysql_query("SELECT * FROM `billing` WHERE `id` = '$bill_id' AND `klijentid` = '$_SESSION[userid]'"));
    if (!$billing_info) {
        $_SESSION['error'] = "Ova narudzba ne postoji ili nemas ovlascenje za istu.";
        header("Location: gp-billing.php");
        die();
    }

    if ($billing_info['srw_name'] == "") {
        $billing_info['srw_name'] = "Narudzba!";
    }

    $iznos_sms = $billing_info['iznos'];
    $sms_iz = explode(".", $iznos_sms);
    if ($sms_iz == false) {
    	$izz_sms = $iznos_sms+1;
    } else {
    	$s_iz 	= $sms_iz[0]+1;
    	$s_iz1 	= $sms_iz[1];
    	$izz_sms = $s_iz.'.'.$s_iz1;
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

    <article>
    	<div id="server_info_infor">    
            <div id="server_info_infor">
                <div id="server_info_infor2">
                    <div class="space" style="margin-top: 20px;"></div>
                    <div class="gp-home">
                        <img src="/img/icon/gp/gp-server.png" alt="" style="position:absolute;margin-left:20px;">
                        <h2>Billing</h2>
                        <h3 style="font-size: 12px;">Lista svih vasih narudzba</h3>
                        <div class="space" style="margin-top: 90px;"></div>

                        <div class="supportAkcija">
                            <li>
                                <a href="/naruci" class="btn"><i class="fa fa-refresh"></i> Nova narudzba</a>
                            </li>
                        </div>
                        <div id="tiket_body">   
                            <div class="tiket_info">
                                
                                <div class="gleda">    
                                    Pregledava: <span class="autor" style="color: red">
                                        <a style="color: red">Admin, Support</a>
                                    </span>            
                                </div>

                                <div class="tiket_info_ab">
                                            
                                    <div class="tiket-button">
                                        <div class="tiket-button_a">
                                            <?php  
                                            $pay_status = $billing_info['status'];

                                            if ($pay_status == "0") { ?> 
                                                <button class="btn btn-large btn-info btn-support-ask">
                                                    Status: Na cekanju!
                                                </button>
                                            <?php } elseif ($pay_status == "1") { ?>
                                                <button class="btn btn-large btn-warning btn-support-ask">
                                                    Status: Razmatra se!
                                                </button>
                                            <?php } elseif ($pay_status == "2") { ?>
                                                <button class="btn btn-large btn-success btn-support-ask">
                                                    Status: Uplaceno!
                                                </button>
                                            <?php } elseif ($pay_status == "3") { ?>
                                                $pay_status = "<span style='color: red;'>Narudzba je lazna!</span>";
                                            <?php } elseif ($pay_status == "Na cekanju") { ?>
                                            	<button class="btn btn-large btn-info btn-support-ask">
                                                    Status: Na cekanju!
                                                </button>
                                            <?php } elseif ($pay_status == "Leglo") { ?>
                                            	<button class="btn btn-large btn-success btn-support-ask">
                                                    Status: Uplaceno!
                                                </button>
                                            <?php } elseif ($pay_status == "Nije leglo") { ?>
                                            	<button class="btn btn-large btn-warning btn-support-ask">
                                                    Status: Razmatra se!
                                                </button>
                                            <?php } ?>
                                        </div>

                                    </div>

                                </div>

                                <div class="tiket_info_b">   
                                    <div class="tiket-header">
                                        <h3>
                                            <span class="fa fa-info-circle" style="color:#076ba6;font-size:19px;"></span>
                                            <?php echo ispravi_text($billing_info['srw_name']); ?>
                                            <span style="float:right;margin-right:10px;">
                                                <?php echo ispravi_text($billing_info['vreme'].', '.$billing_info['datum']); ?>
                                            </span>
                                        </h3>
                                    </div>
                                    
                                    <div class="tiket-content">
                                        <div class="tiket_info_home">
                                            <div class="tiket_info_home_a">
                                                <li><img src="/img/a/<?php echo user_avatar($_SESSION['userid']); ?>" alt=""></li>
                                                <li><p><strong><?php echo ime_prezime($_SESSION['userid']); ?></strong></p></li>
                                            </div>
                                            
                                            <?php if ($pay_status == "0") { ?>
                                                <div class="tiket_info_home_p">
                                                    <p>
                                                        <strong><?php echo $billing_info['description']; ?> &euro;</strong>
                                                    </p>
                                                </div>
                                                
                                                <hr>
                                                
                                                <div class="bill_pay_">
                                                    <label for="billing_pay">UPLATI PREKO : </label>
                                                    <li>
                                                        <a href="/_buy/paypal.php?id=<?php echo $billing_info['id']; ?>&CatDescription=<?php echo $billing_info['srw_name']; ?>&payment=<?php echo $billing_info['iznos']; ?>&key=<?php echo md5(date("Y-m-d:").rand()); ?>">
                                                            <img src="./img/icon/pp_i.png" style="width:15px;height:20px;"> PayPal
                                                        </a>
                                                    </li>
                                                    <li><a href=""><span class="fa fa-bank"></span> Banka/Posta</a></li>
                                                    <li><a href="">Paysafecard</a></li>
                                                    <li>
                                                        <a href="">
                                                            <img src="./img/icon/p_coin.png" style="width:20px;height:20px;"> BitCoins</a>
                                                        </li>
                                                    <li><a href="https://www.paygol.com/pay?pg_serviceid=351195&pg_currency=EUR&pg_name=<?php echo $billing_info['srw_name']; ?>&pg_custom=&pg_price=<?php echo $izz_sms; ?>&pg_return_url=https://www.o-neon.info/_buy/sms.php?task=return&pg_cancel_url=https://www.o-neon.info/_buy/sms.php?task=cancel&pg_button.x=78&pg_button.y=95"><span class="fa fa-commenting-o"></span> SMS</a></li>
                                                </div>
                                            <?php } elseif ($pay_status == "1") { ?>
                                                <div class="tiket_info_home_p">
                                                    <p>
                                                        <strong><?php echo $billing_info['description']; ?> &euro;</strong>
                                                    </p>
                                                </div>
                                                
                                                <hr>
                                                
                                                <div class="bill_pay_">
                                                    <label for="billing_dokaz">DOKAZ : </label>
                                                    <li><a href="">SLIKA</a></li>
                                                    <li><a href="">NESTO DRUGO</a></li>

                                                    <hr>

                                                    <label for="billing_pay">UPLATI PREKO : </label>
                                                    <li><a href="/_buy/paypal.php?id=<?php echo $billing_info['id']; ?>&CatDescription=<?php echo $billing_info['srw_name']; ?>&payment=<?php echo $billing_info['iznos']; ?>&key=<?php echo md5(date("Y-m-d:").rand()); ?>">
                                                            <img src="./img/icon/pp_i.png" style="width:15px;height:20px;"> PayPal
                                                        </a></li>
                                                    <li><a href=""><span class="fa fa-bank"></span> Banka/Posta</a></li>
                                                    <li><a href="">Paysafecard</a></li>
                                                    <li><a href=""><span class="fa fa-bitcoin"></span> BitCoins</a></li>
                                                    <li><a href="https://www.paygol.com/pay?pg_serviceid=351195&pg_currency=EUR&pg_name=<?php echo $billing_info['srw_name']; ?>&pg_custom=&pg_price=<?php echo $izz_sms; ?>&pg_return_url=https://www.o-neon.info/_buy/sms.php?task=return&pg_cancel_url=https://www.o-neon.info/_buy/sms.php?task=cancel&pg_button.x=78&pg_button.y=95"><span class="fa fa-commenting-o"></span> SMS</a></li>
                                                </div>
                                            <?php } elseif ($pay_status == "2") { ?>
                                                <div class="tiket_info_home_p">
                                                    <p>
                                                        <strong><?php echo $billing_info['description']; ?> &euro;</strong>
                                                    </p>
                                                </div>
                                                
                                                <hr>
                                                
                                                <div class="bill_pay_">
                                                    <label for="billing_pay">
                                                        <h2 style="margin: 0; color: #54ff00;">Narudzba je aktivna!</h2>
                                                    </label>
                                                </div>
                                            <?php } else { ?>
                                                <div class="tiket_info_home_p">
                                                    <p>
                                                        <strong><?php echo $billing_info['description']; ?> &euro;</strong>
                                                    </p>
                                                </div>
                                                
                                                <hr>
                                                
                                                <div class="bill_pay_">
                                                    <label for="billing_pay">UPLATI PREKO : </label>
                                                    <li><a href="/_buy/paypal.php?id=<?php echo $billing_info['id']; ?>&CatDescription=<?php echo $billing_info['srw_name']; ?>&payment=<?php echo $billing_info['iznos']; ?>&key=<?php echo md5(date("Y-m-d:").rand()); ?>">
                                                            <img src="./img/icon/pp_i.png" style="width:15px;height:20px;"> PayPal
                                                        </a></li>
                                                    <li><a href="">Banka/Posta</a></li>
                                                    <li><a href="">Paysafecard</a></li>
                                                    <li><a href="">BitCoins</a></li>
                                                    <li><a href="https://www.paygol.com/pay?pg_serviceid=351195&pg_currency=EUR&pg_name=<?php echo $billing_info['srw_name']; ?>&pg_custom=&pg_price=<?php echo $izz_sms; ?>&pg_return_url=https://www.o-neon.info/_buy/sms.php?task=return&pg_cancel_url=https://www.o-neon.info/_buy/sms.php?task=cancel&pg_button.x=78&pg_button.y=95"><span class="fa fa-commenting-o"></span> SMS</a></li>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>

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

    <?php } ?>

    <!-- FOOTER -->
    
    <?php include('style/footer.php'); ?>   

    <?php include('style/java.php'); ?>

</body>
</html>