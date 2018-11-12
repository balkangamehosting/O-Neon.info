<?php
header('Content-Type: text/html; charset=utf-8');

include 'connect_db.php';

error_reporting(0);

if (is_login() == false) {
    $_SESSION['error'] = "Niste ulogovani.";
    header("Location: /home");
    die();
} else {
    $server_id = $_GET['id'];

    $server = mysql_fetch_array(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));
    
    if (!$server) {
        $_SESSION['error'] = "Taj server ne postoji ili nemas ovlascenje za isti.";
        header("Location: /gp-home.php");
        die();
    }

    $info = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$server[box_id]'"));

    if (isset($_GET['fajl'])) {
        $allow_ext = ['txt', 'cfg', 'sma', 'SMA', 'inf', 'ini', 'log', 'json', 'yml', 'properties'];
        
        $temp = explode(".", $_GET['fajl']);
        $ext = strtolower(end($temp));
        
        if(in_array($ext, $allow_ext) === false) {  
            $_SESSION['error'] = "Taj format nije podrzan."; 
            header("Location: gp-webftp.php?id=".$server_id."&path=/"); 
            die(); 
        }
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
                                <img src="/img/icon/gp/gp-web-ftp.png">
                            </div> 
                            <div style="margin-top:15px;color: #fff;">
                                <strong>WebFTP</strong>
                                <p>Direktan pristup fajlovima servera putem FTP protokola</p>
                            </div>
                        </div>
                        <div id="right_header">
                            <ul>
                                <?php
                                    $plugin_token = $_SERVER['REMOTE_ADDR'].'_p_'.randomSifra(100);
                                    $_SESSION['plugin_token'] = $plugin_token;
                                ?>
                                <form action="process.php?task=add_plugin" method="POST" enctype="multipart/form-data">
                                    <li>Upload fajla: <input type="file" name="file"> 
                                        <input type="hidden" name="plugin_token" value="<?php echo $plugin_token; ?>">
                                        <input type="hidden" name="lokacija" value="<?php echo $_GET['path']; ?>" />
                                        <input type="hidden" name="server_id" value="<?php echo $server_id; ?>" />
                                        <input type="submit" value="Upload" name="upload">
                                    </li>
                                </form>
                                <?php
                                    $folder_token = $_SERVER['REMOTE_ADDR'].'_p_'.randomSifra(100);
                                    $_SESSION['folder_token'] = $folder_token;
                                ?>
                                <form action="process.php?task=create_folder" method="POST">
                                    <li>Kreiraj folder: <input type="text" name="folder_name" style="width: 198px;"> 
                                        <input type="hidden" name="folder_token" value="<?php echo $folder_token; ?>">
                                        <input type="hidden" name="lokacija" value="<?php echo $_GET['path']; ?>" />
                                        <input type="hidden" name="server_id" value="<?php echo $server_id; ?>" />
                                        <input type="submit" name="folder" value="Napravi">
                                    </li>
                                </form> 
                                <?php
                                    $wget_token = $_SERVER['REMOTE_ADDR'].'_p_'.randomSifra(100);
                                    $_SESSION['wget_token'] = $wget_token;
                                ?>
                                <form action="process.php?task=wget_file" method="POST">
                                    <li>WGET file: <input type="text" name="wget_link" style="width: 215px;font-family: Tahoma, Verdana, Arial, sans-serif; font-weight: normal; font-size: 11px; line-height: 16px;  border: 1px solid #076ba6; color: #000;"> 
                                        <input type="hidden" name="wget_token" value="<?php echo $wget_token; ?>">
                                        <input type="hidden" name="lokacija" value="<?php echo $_GET['path']; ?>" />
                                        <input type="hidden" name="server_id" value="<?php echo $server_id; ?>" />
                                        <input type="submit" name="folder" value="WGET" style="width: 50px;">
                                    </li>
                                </form>                             
                            </ul>
                        </div>
                    </div>              
                    <div id="ftp_body">
                        
                        <?php 
                            if(isset($_GET['path'])) {
                                $lokacija = htmlspecialchars(mysql_real_escape_string(addslashes($_GET['path'])));
                            } 

                            if(isset($_GET['path'])) {
                                $path = $_GET['path'];
                                $back_link = dirname($path);

                                $ftp_path = substr($path, 1);
                                $breadcrumbs = preg_split('/[\/]+/', $ftp_path, 9); 
                                $breadcrumbs = str_replace("/", "", $breadcrumbs);

                                $ftp_pth = '';
                                if(($bsize = sizeof($breadcrumbs)) > 0) {
                                    $sofar = '';
                                    for($bi=0;$bi<$bsize;$bi++) {
                                        if($breadcrumbs[$bi]) {
                                            $sofar = $sofar . $breadcrumbs[$bi] . '/';

                                            $ftp_pth .= '<i class="fa fa-chevron-right"></i>
                                                        <a style="color: #FFF;" href="gp-webftp.php?id='.$server['id'].'&path=/'.$sofar.'">
                                                        <i class="fa fa-folder-open"></i> '.$breadcrumbs[$bi].'</a>';
                                        }
                                    }
                                }
                            } else {
                                header("Location: gp-webftp.php?id=".$server_id."&path=/");
                                die();
                            }

                            $ftp = ftp_connect($info['ip'], 21);
                            if(!$ftp) {
                                $_SESSION['error'] = "Ne mogu se spojiti sa FTP serverom, molimo prijavite nasoj podrsci ovaj problem.";
                                header("Location: /prijavi_error");
                                die();
                            }
                            
                            if (@ftp_login($ftp, $server['username'], $server['password'])) {
                                ftp_pasv($ftp, true);
                                if (!isset($_GET['fajl'])) {
                                    ftp_chdir($ftp, $path);
                                    $ftp_contents = ftp_rawlist($ftp, $path);
                                    $i = "0";

                                    foreach ($ftp_contents as $folder) {
                                        $broj = $i++;   
                                        $current = preg_split("/[\s]+/",$folder,9);

                                        $isdir = ftp_size($ftp, $current[8]);
                                        if (substr($current[0][0], 0 - 1) == "l"){
                                            $ext = explode(".", $current[8]);
                                            //print_r($ext);
                                            $xa = explode("->", $current[8]);
                                            
                                            $current[8] = $xa[0];
                                            
                                            $current[0] = "link";
                                            
                                            $current[4] = "link fajla";

                                            $current[5];
                                            
                                            $ftp_fajl[]=$current;

                                        } else {
                                            if ( substr( $current[0][0], 0 - 1 ) == "d" ) $ftp_dir[]=$current;
                                            else {
                                                $text = array( "txt", "cfg", "sma", "SMA", "CFG", "inf", "log", "rc", "ini", "yml", "json", "properties" );
                                                $ext = explode(".", $current[8]);
                                                if(!empty($ext[1])) if (in_array( $ext[1], $text )) $current[9] = $ext[1];
                                                
                                                $ftp_fajl[]=$current;
                                            }
                                        }   
                                    } 

                                } else {
                                    $filename = "ftp://$server[username]:$server[password]@$info[ip]:21".$lokacija."/$_GET[fajl]";
                                    $contents = file_get_contents($filename);
                                }
                                if(isset($_GET["path"])) {
                                    $old_path = ''.$_GET["path"].'/';
                                    $old_path = str_replace('//', '/', $old_path);
                                }
                            } else {
                                $_SESSION['error'] = "Ne mogu se spojiti sa FTP serverom, molimo prijavite nasoj podrsci ovaj problem.";
                                header("Location: gp-webftp.php?id=".$server_id);
                                die();
                            }

                            ftp_close($ftp);
                        ?>

                        <?php if(isset($_GET["path"])) { ?>
                            <div id="file_info">
                                <a style="color: #FFF;" href="gp-webftp.php?id=<?php echo $server_id; ?>">
                                    <i class="fa fa-home"></i> root
                                </a>
                                <?php echo $ftp_pth; if(isset($_GET['fajl'])) { ?>
                                    <i class="fa fa-caret-right"></i>
                                    <i class="fa fa-file"></i> 
                                <?php echo htmlspecialchars($_GET['fajl']); } ?>
                            </div>
                        <?php } else { ?>
                            <div id="file_info">
                                <a style="color: #FFF;" href="gp-webftp.php?id=<?php echo $server_id; ?>">
                                    <i class="fa fa-home"></i> root
                                </a>
                                <?php if(isset($_GET['fajl'])) { ?>  
                                    <i class="fa fa-caret-right"></i>
                                    <i class="fa fa-file"></i> 
                                <?php echo htmlspecialchars($_GET['fajl']); } ?>
                            </div>
                        <?php } ?>
                        
                        <?php if(!isset($_GET['fajl'])) { ?>
                            
                            <div id="webftp">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Ime fajla/foldera</th>
                                            <th>Veličina</th>
                                            <th>User</th>
                                            <th>Grupa</th>
                                            <th>Permisije</th>
                                            <th>Modifikovan</th>
                                            <th>Akcija</th>
                                        </tr>

                                        <?php
                                            $back_link = str_replace("\\", '/', $back_link);
                                            if($path != "/") {
                                        ?>
                                            <tr>
                                                <td colspan="7" style="cursor: pointer;" onClick="window.location='?id=<?php echo $server_id; ?><?php if ($back_link != "/") { ?>&path=<?php echo $back_link; } ?>'">
                                                <z><i class="icon-arrow-left"></i></z>  ...
                                                </td>
                                            </tr>
                                        <?php } foreach($ftp_dir as $x) { ?>
                                            <tr>
                                                <td>
                                                    <a style="color: #FFF;" href="gp-webftp.php?id=<?php echo $server_id; ?>&path=<?php echo $old_path."".$x[8]; ?>">
                                                        <i class='fa fa-folder-open' style="color: yellow;"></i>
                                                        <?php echo $x[8]; ?>
                                                    </a>
                                                </td>   

                                                <td>-</td>

                                                <td>
                                                    <?php echo $x[2]; ?>
                                                </td>

                                                <td>
                                                    <?php echo $x[3]; ?>
                                                </td>

                                                <td>
                                                    <?php echo $x[0]; ?>
                                                </td>

                                                <td>
                                                    <?php echo $x[5].' '.$x[6].' '.$x[7]; ?>
                                                </td>

                                                <td>
                                                    <?php if (is_pin() === true) { ?>
                                                        <form action="process.php?task=delete_folder" method="POST">
                                                            <a>
                                                                <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                                                                <input hidden type="text" name="file_location" value="<?php echo $_GET['path']; ?>">
                                                                <input hidden type="text" name="folder_name" value="<?php echo htmlspecialchars($x['8']); ?>">
                                                                <button><i class="fa fa-remove"></i></button>
                                                            </a>
                                                        </form>
                                                    <?php } else { ?>
                                                        <form>
                                                            <a>
                                                                <span style="padding:6px;color:#fff;cursor:pointer;" data-toggle="modal" data-target="#pin-auth">
                                                                    <i class="fa fa-remove"></i>
                                                                </span>
                                                            </a>
                                                        </form>
                                                    <?php } ?>
                                                    <form action="" method="POST" style="position: absolute;">
                                                        <a href="#">
                                                            <button id="iconweb"><i class="fa fa-edit"></i></button>
                                                        </a>
                                                    </form>          
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        
                                        <?php if(!empty($ftp_fajl)) { foreach($ftp_fajl as $x) { ?>
                                            <tr>
                                                <td>
                                                    <?php if(isset($x[9])) { ?>
                                                        <a href="gp-webftp.php?id=<?php echo $server_id; ?>&path=<?php echo $old_path; ?>&fajl=<?php echo $x[8]; ?>">
                                                            <i class='fa fa-file-text'></i>
                                                            <?php echo $x[8]; ?>
                                                        </a>
                                                    <?php } else { ?>
                                                        <i class='fa fa-file'></i>
                                                        <?php echo $x[8]; ?>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php

                                                        if($x[4] == "link fajla") echo $x[4];
                                                        else {          
                                                            if($x[4] < 1024) echo $x[4]." byte";
                                                            else if($x[4] < 1048576) echo round(($x[4]/1024), 0)." KB";
                                                            else echo round(($x[4]/1024/1024), 0)." MB";
                                                        }
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php echo $x[2]; ?>
                                                </td>

                                                <td>
                                                    <?php echo $x[3]; ?>
                                                </td>

                                                <td>
                                                    <?php echo $x[0]; ?>
                                                </td>

                                                <td>
                                                    <?php echo $x[5].' '.$x[6].' '.$x[7]; ?>
                                                </td>

                                                <td>
                                                    <?php if (is_pin() == false) { ?>
                                                        <form>
                                                            <a>
                                                                <span style="padding:6px;color:#fff;cursor:pointer;" data-toggle="modal" data-target="#pin-auth">
                                                                    <i class="fa fa-remove"></i>
                                                                </span>
                                                            </a>
                                                        </form>
                                                        <form style="position: absolute;">
                                                            <a>
                                                                <span style="padding:6px;color:#fff;cursor:pointer;" data-toggle="modal" data-target="#pin-auth">
                                                                    <i class="fa fa-edit"></i>
                                                                </span>
                                                            </a>
                                                        </form>
                                                    <?php } else { ?>
                                                        <?php if (strpos($x[8], '.zip')) { ?>
                                                            <?php include('style/file_ftp_zip.php'); ?>
                                                        <?php } elseif (strpos($x[8], '.rar')) { ?>
                                                            <?php include('style/file_ftp_rar.php'); ?>
                                                        <?php } elseif (strpos($x[8], '.tar')) { ?>
                                                            <?php include('style/file_ftp_tar.php'); ?>
                                                        <?php } else { ?>
                                                            <?php include('style/file_ftp_.php'); ?>
                                                        <?php } ?>  
                                                    <?php } ?>                              
                                                </td>
                                            </tr>
                                        <?php } } ?>

                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div id="ftp_sacuvajFile">
                                <div style="margin-top: 20px;"></div>
                                <?php
                                    $file_token = $_SERVER['REMOTE_ADDR'].'_p_'.randomSifra(100);
                                    $_SESSION['file_token'] = $file_token;
                                ?>
                                <form action="process.php?task=edit_file" method="POST">
                                    <input type="hidden" name="file_token" value="<?php echo $file_token; ?>">
                                    <input type="hidden" name="file" value="<?php echo htmlspecialchars($_GET['fajl']); ?>" />
                                    <input type="hidden" name="lokacija" value="<?php echo $lokacija; ?>" />
                                    <input type="hidden" name="server_id" value="<?php echo $server_id; ?>" />
                                    <textarea id="file_edit" name="file_text_edit" height="auto">
<?php echo $contents; ?>
                                    </textarea>
                                    <button type="submit" class="btn" style=""> Sačuvaj </button>
                                </form>     
                            </div>
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