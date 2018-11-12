<?php  

require("fnc/pagination.class.php");
// Link: http://pastebin.com/fELH1mpj

$info = $_GET['info'];

if ($info == "") { ?>
	<!-- Informacije -->
<div id="cards_container2">
	<?php 
	    $z_link	= explode("=", $_SERVER['REQUEST_URI']);

	    if ($z_link[1] == "") {
	    	header("Location: ?page=1");
	    }

		$numberOfElements = mysql_num_rows(mysql_query("SELECT * FROM `vesti` ORDER BY id DESC"));
		$currentPage = $z_link[1];

		$elementsPerPage = 8;
		$paginationWidth = 4;
		$data = Pagination::load($numberOfElements, $currentPage, $elementsPerPage, $paginationWidth);

		$start = ($data['currentPage']-1) * intval($elementsPerPage);
		$limit = intval($elementsPerPage);
		$data_query = mysql_query("SELECT * FROM `vesti` ORDER BY id DESC LIMIT {$start}, {$limit}");
		while($row = mysql_fetch_array($data_query)) { 
	        $info_id 		= htmlspecialchars(mysql_real_escape_string(addslashes($row['id'])));
	        $poruka 		= $row['poruka'];
	        $naslov 		= htmlspecialchars(mysql_real_escape_string(addslashes($row['naslov'])));
	        $link_slike 	= htmlspecialchars(mysql_real_escape_string(addslashes($row['l_slika'])));
	        $admin_id 		= htmlspecialchars(mysql_real_escape_string(addslashes($row['admin_id'])));
	        $vreme 			= htmlspecialchars(mysql_real_escape_string(addslashes($row['vreme'])));

	        $naslov_link 	= mysql_real_escape_string($row['naslov']);

	        if(strlen($naslov) > 19){ 
				$naslov = substr($naslov,0,19); 
				$naslov .= "..."; 
			}

			if(strlen($poruka) > 40){ 
				$poruka = substr($poruka,0,40); 
				$poruka .= "..."; 
			}
	    ?>  
			<div class="card">
				<div class="top_card">
					<span style="color: #076ba6;"><i class="glyphicon glyphicon-link"></i></span> Info: <?php echo $naslov; ?>
				</div>
				<div class="card_img">
					<img src="<?php echo $link_slike; ?>" >
					<div class="bottom_img">
						<p><?php echo $poruka ?></p>
					</div>
				</div>
				<div class="buttons_container">
					<a class="info_page" href="/info/<?php echo $naslov_link; ?>" style="width: 100%">Vise Info</a>
				</div>
			</div>
	<?php } ?>
</div>

    <div class="pagg" style="margin: 10px;">
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

<?php } else {

	$uzmi_link = $_GET['info'];


	$proveri_link = mysql_query("SELECT * FROM `vesti` WHERE `naslov` = '$uzmi_link'");

	if (mysql_num_rows($proveri_link) == 0) {
		$_SESSION['error'] = "Nema informacija.";
		header("Location: /info");
		die();
	} else {
		$dodajpregled = mysql_query("UPDATE `vesti` SET views = views + 1 WHERE `naslov` = '$uzmi_link'");
		$dobar_link = mysql_fetch_array($proveri_link);
		$pregleda = $dobar_link['views'];
		$Naslov = ispravi_text($dobar_link['naslov']);
		$Poruka = $dobar_link['poruka'];
		$Slika 	= ispravi_text($dobar_link['l_slika']);
		$Adm_ID = ispravi_text($dobar_link['admin_id']);
		$Vreme 	= ispravi_text($dobar_link['vreme']);
	    $admin = mysql_fetch_array(mysql_query("SELECT * FROM `admin` WHERE `id` = '$Adm_ID'"));
	?> 
	
		<div id="tiket_body">   
        	<div class="tiket_info">
				<div class="gleda">    
                    <span class="autor" style="color: red">
                        <?php echo $pregleda ?> pregleda
                    </span>            
                </div>

        		<div class="tiket_info_ab">
					<div class="tiket-button">
                       	<div class="tiket-button_a">
                        	<form action="process.php?task=like_post" method="POST">
		                        <button class="btn btn-large btn-info btn-support-ask" style="padding:10px;border-bottom:2px solid#0e89d2;">
		                        	<img src="/img/icon/like_icon.png" style="width:20px;height:20px;">
		                            LIKE POST
		                            <img src="/img/icon/like_icon.png" style="width:20px;height:20px;">
		                        </button>
		                    </form>
		                    <form action="process.php?task=send_view" method="POST">
		                        <button class="btn btn-large btn-danger btn-support-ask" style="padding:10px;border-bottom:2px solid red;">
		                        	<img src="/img/icon/dislike_icon.png" style="width:20px;height:20px;">
		                            UNLIKE POST
		                            <img src="/img/icon/dislike_icon.png" style="width:20px;height:20px;">
		                        </button>
		                    </form>
		                </div>
		            </div>
                </div>

				<div class="tiket_info_b">   
                    <div class="tiket-header">
                        <h3>
                            <span class="fa fa-info-circle" style="color:#076ba6;font-size:19px;"></span>
                        	
                        	<span style="color:#fff;font-size:18px;">
                        		<?php echo $Naslov; ?>
                        	</span>

                            <span style="color:#fff;font-size:15px;float:right;margin-right:10px;">
                                <?php echo $Vreme; ?>
                            </span>
                        </h3>
                    </div>

					<div class="tiket-content">
                                        
                        <div class="tiket_info_home">
                            <div class="tiket_info_home_a">
                                <li><img src="/admin/avatari/<?php echo $admin['avatar'] ?>"></li>
                                <li><p><strong style="color:red;"><?php echo adminIme($Adm_ID); ?></strong></p></li>
                            </div>
                            
                            <div class="tiket_info_home_p">
                                <p>
                                    <strong><?php echo $Poruka; ?></strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>

	<?php } ?>

<?php } ?>