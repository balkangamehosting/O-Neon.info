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
                                <img src="/img/icon/gp/gp-admin.png">
                            </div> 
                            <div style="margin-top:15px;color: #fff;">
                                <strong>Admini i slotovi</strong>
                                <p>Ovde mozete dodavati, brisati ili menjati trenutne admine i slotove na serveru.
                                <br/></p>
                            </div>
                        </div>
                    </div>
                    <div class="space" style="margin-top: 60px;"></div>
                    <div class="supportAkcija">
                        <li>
                            <a href="" class="btn" data-toggle="modal" data-target="#add-admin"><i class="fa fa-lock"></i> DODAJ ADMINA</a>
                        </li>
                    </div>              
                    <div id="plugin_body">
                        <?php  

                            $filename = "ftp://$server[username]:$server[password]@$info[ip]:21/cstrike/addons/amxmodx/configs/users.ini";
                            $contents = file_get_contents($filename);   

                            $fajla = explode("\n;", $contents);

                        ?>
                        <div id="serveri">
                            <table>
                                <tbody>
                                    <tr>
                                        <th>Nick/SteamID/IP</th>
                                        <th>Sifra (ako ima)</th>
                                        <th>Privilegije</th>
                                        <th>Vrsta</th>
                                        <th>Komentar</th>
                                        <th>Akcija</th>
                                    </tr>
                                    <?php 
                                        foreach($fajla as $sekcija) {
                                            $linije = explode("\n", $sekcija);
                                            array_shift($linije);
                                            
                                            foreach($linije as $linija) {
                                                $admin = explode('"',$linija);
                                                if(!empty($admin[1]) && !empty($admin[5])) { ?>
                                                    <tr>
                                                        <td><?php echo ispravi_text($admin[1]); ?></td>
                                                        <td><?php echo ispravi_text($admin[3]); ?></td>
                                                        <td><?php echo ispravi_text($admin[5]); ?></td>
                                                        <td><?php echo ispravi_text($admin[7]); ?></td>
                                                        <td><?php echo str_replace('//', '', ispravi_text($admin[8])); ?></td>
                                                        <td><!--- 
                                                            <div class="akcija_addmin">
                                                                <li>
                                                                    <form action="cpanel.php?task=login" method="GET">
                                                                        <input hidden type="text" name="cp_username" value="<?php echo ispravi_text($admin[1]); ?>">
                                                                        <input hidden type="text" name="cp_pw" value="<?php echo ispravi_text($admin[3]); ?>">
                                                                        <button>
                                                                            <span class="glyphicon glyphicon-log-in"></span>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <form action="cpanel.php?task=login" method="POST">
                                                                        <button>
                                                                            <span class="fa fa-remove"></span>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </div> -->
                                                            U izradi :/
                                                        </td>
                                                    </tr>
                                                <?php }
                                            }
                                        }
                                    ?>                            
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        <!-- ADD ADMIN (POPUP)-->
        <div class="modal fade" id="add-admin" role="dialog">
            <div class="modal-dialog">
                <div id="popUP"> 
                    <div class="popUP">
                        <?php
                            $admin_token = $_SERVER['REMOTE_ADDR'].'_p_'.randomSifra(100);
                            $_SESSION['admin_token'] = $admin_token;
                        ?>
                        <form action="process.php?task=add_admins" method="post" class="ui-modal-form" id="modal-pin-auth">
                            <input type="hidden" name="server_id" value="<?php echo $server['id']; ?>">
                            <input type="hidden" name="admin_token" value="<?php echo $admin_token; ?>">
                            <fieldset>
                                <h2>Dodavanje novog admina ili slota</h2>
                                <ul>
                                    <li>
                                        <label>Vrsta admina:</label>
                                        <select name="vrsta" id="vrsta" class="short" style="margin-left: 10px;width: 175px;padding: 3px;">
                                            <option value="nick_admin">Nick+Sifra</option>
                                            <option value="steam_admin">SteamID+Sifra</option>
                                            <option value="ip_admin">IP adresa+Sifra</option>
                                        </select>
                                    </li>
                                    <li>
                                        <label>Nick/Steam/IP:</label>
                                        <input type="text" name="nick" class="short" style="margin-left: 5px;">
                                    </li>
                                    <li>
                                        <label>Sifra:</label>
                                        <input type="text" name="sifra" class="short" style="margin-left: 67px;">
                                    </li>
                                    <li>
                                        <label>Privilegije:</label>
                                        <select name="privilegije" id="privilegije" class="short" style="margin-left: 31px;width: 175px;padding: 3px;">
                                            <option value="">Izaberi privilegiju</option>
                                            <option value="slot">Slot</option>
                                            <option value="slot_i">Slot+Imunitet</option>
                                            <option value="low_admin">Obican admin</option>
                                            <option value="ful_admin">Full admin</option>
                                            <option value="head">HEAD admin</option>
                                        </select>
                                        <br />
                                        <div id="custom"><p style="cursor: pointer;">Custom ?</p></div>
                                        <div id="panel" style="display: none;">
                                            *- "a" Imunity <br />
                                            *- "b" Slot <br />
                                            *- "c" amx_kick <br />
                                            *- "d" amx_ban i amx_unban <br />
                                            *- "e" amx_slay i amx_slap <br />
                                            *- "f" amx_map <br />
                                            *- "g" amx_cvar <br />
                                            *- "h" amx_cfg <br />
                                            *- "i" amx_chat i bela slova <br />
                                            *- "j" amx_vote i amx_votemap <br />
                                            *- "k" amx_cvar sv_password <br />
                                            *- "l" head admin <br />
                                            <label>Custom:</label>
                                            <input type="text" name="custom_flag" class="short" style="margin-left: 45px;">
                                        </div>
                                    </li>
                                    <li>
                                        <label>Komentar:</label>
                                        <input type="text" name="komentar" class="short" style="margin-left: 32px;">
                                    </li>
                                    <li style="text-align:center;">
                                        <button> 
                                            <span class="fa fa-check-square-o"></span> Dodaj admina
                                        </button>
                                        <button type="button" data-dismiss="modal" loginClose="close"> 
                                            <span class="fa fa-close"></span> Odustani 
                                        </button>
                                    </li>
                                </ul>
                            </fieldset>
                        </form>
                    </div>        
                </div>  
            </div>
        </div>
        <!-- KRAJ - ADD ADMIN (POPUP) -->
        
        <?php if (is_pin() == true) { ?>
            <!-- Generisi novu FTP sifru (POPUP)-->
            <div class="modal fade" id="ftp-pw" role="dialog">
                <div class="modal-dialog">
                    <div id="popUP"> 
                        <div class="popUP">
                            <?php
                                $get_pin_toket = $_SERVER['REMOTE_ADDR'].'_p_'.randomSifra(100);
                                $_SESSION['pin_token'] = $get_pin_toket;
                            ?>
                            <form action="process.php?task=new_ftp_pw" method="post" class="ui-modal-form" id="modal-pin-auth">
                                <input type="hidden" name="pin_token" value="<?php echo $get_pin_toket; ?>">
                                <fieldset>
                                    <h2>Generisi novu FTP lozniku</h2>
                                    <ul>
                                        <li>
                                            <p>Dali ste sigurni da zelite da promenite FTP password?</p>
                                            <p>FTP password mozete menjat kad god hocete.</p>
                                        </li>
                                        <li>
                                            <label>NEW FTP PASS PO ZELJI: </label>
                                            <input type="text" name="ftp_pw_kor" class="short">
                                            <label>NEW AUTOMATCKI FTP PASS: </label>
                                            <input type="text" name="ftp_pw_gen" value="<?php echo randomSifra(10); ?>" class="short">
                                        </li>
                                        <li style="text-align:center;">
                                            <button> <span class="fa fa-check-square-o"></span> Promeni</button>
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
        <?php } ?>

    <?php } ?>

    <!-- FOOTER -->
    
    <?php include('style/footer.php'); ?>   

    <?php include('style/java.php'); ?>
    <script> 
        $(document).ready(function(){
            $("#custom").click(function(){
                $("#panel").slideToggle(100);
            });
        });
    </script>

</body>
</html>