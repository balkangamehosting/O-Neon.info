<?php
include 'connect_db.php';
require("fnc/pagination.class.php");

if (is_login() == false) {
    $_SESSION['error'] = "Niste ulogovani.";
    header("Location: /home");
    die();
} else {
    $server_id = $_GET['id'];
    $proveri_server = mysql_num_rows(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));

    $server = mysql_fetch_array(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));
    $server_ip = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$server[box_id]'"));
	
	$ss_ip = $server_ip['ip'];
	$ss_port = $server['port'];
	$fullip = $ss_ip.":".$ss_port;
	$boostovaniserveri = $mdb->query("SELECT * FROM `t2` WHERE `ipport`= '$fullip'");
	
    if (!$proveri_server) {
        $_SESSION['error'] = "Taj server ne postoji ili nemas ovlascenje za isti.";
        header("Location: /gp-home.php");
        die();
    }

    $info = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$server[box_id]'"));

    if ($server['slotovi'] <= 25) {
        $_SESSION['info'] = "Samo serveri sa 26 ili vise slotova mogu da koriste ovu opciju.";
        header("Location: gp-info.php?id=".$server['id']);
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
                                <i id="ib" class="fa fa-cog fa fa-spin fa fa-4x" style="color: #fff;"></i>
                            </div> 
                            <div style="margin-top:15px;color: #fff;">
                                <strong>Boost</strong>
                                <p>Ovde mozete bostovati vas server svakih 2 dana free!
                                <br/></p>
                            </div>
                        </div>
                    </div>              
                    <div id="plugin_body">
                        <form action="process.php?task=boost_server" method="POST">
                            <input type="hidden" name="server_id" value="<?php echo $server_id; ?>" />
                            <button type="submit" style="width: 300px; padding: 10px; float: right; margin-top: -60px;">
                                <i class="fa fa-gamepad" style="font-size: 20px;"></i> BOOSTUJ SERVER
                            </button>
                        </form>
                    </div>
                </div>
				
				<div id="serveri">
                            <table>
                                <tbody>
                                    <tr>
                                        <th>IP SERVERA</th>
                                        <th>VREME BOOSTA</th>
										<th>ISTICE BOOST</th>
                                    </tr>
                                    <?php
                                        error_reporting(0);  
										$queryelem = $mdb->query("SELECT * FROM `t2` WHERE `ipport`='$fullip'");
                                        $numberOfElements = mysqli_num_rows($queryelem);
                                        $currentPage = $_GET['page'];

                                        $elementsPerPage = 15;
                                        $paginationWidth = 9;
                                        $data = Pagination::load($numberOfElements, $currentPage, $elementsPerPage, $paginationWidth);

                                        $start = ($data['currentPage']-1) * intval($elementsPerPage);
                                        $limit = intval($elementsPerPage);
                                        $data_query = $mdb->query("SELECT * FROM `t2` WHERE `ipport`= '$fullip' LIMIT {$start}, {$limit}");
                                    
                                        while($row = mysqli_fetch_array($data_query)) { 

                                            $ipsrv = htmlspecialchars(mysqli_real_escape_string($mdb, addslashes($row['ipport'])));
											$vremeboosta = htmlspecialchars(mysqli_real_escape_string($mdb, addslashes($row['vreme'])));
											$vrmbst = new DateTime($vremeboosta);
											$istice = $vrmbst->modify('+2 day')->format('Y-m-d H:i:s');
                                        ?>  
                                            <tr>
                                                <td><?php echo $ipsrv; ?></td>
                                                <td><?php echo $vremeboosta; ?></td>
												<td><?php echo $istice; ?></td>
                                            </tr>
                                    <?php } ?>                               
                                </tbody>
                            </table>
                            <br />
                            <div class="pagg">
                                <?php  
                                    if($data['previousEnabled']) {
                                        echo '<a class="prev_page" href="?page=' . ($currentPage-1) . '">«</a>';
                                    } else { 
                                        echo '<span class="prev disabled">«</span>';
                                    }

                                    foreach ($data['numbers'] as $number) {
                                        echo '<a class="pages active" href="?page=' . $number . '">' .  $number . '</a>';
                                        echo '&nbsp;&nbsp;';
                                    }

                                    if ($data['nextEnabled']) {
                                        echo '<a class="next_page" href="?page=' . ($currentPage+1) . '">»</a>';
                                    } else {
                                        echo '<span class="next disabled">»</span>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="space" style="margin-bottom: 20px;"></div>
				
            </div>
        </div>
    </div>

    <!-- Php script :) -->

    <?php include('style/footer.php'); ?>

    <?php include('style/pin_provera.php'); ?>

    <?php include('style/java.php'); ?>

</body>
</html>
