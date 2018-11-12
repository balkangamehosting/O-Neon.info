<?php
date_default_timezone_set("Europe/Belgrade");
// Token key: 88bb0088d970a67cc4d77126f177fad3 = || = GameHosterAutoRs  

$Rs_ID = md5($_GET['token']);

if ($Rs_ID == "88bb0088d970a67cc4d77126f177fad3") {

	//CONN/FUNC
	include_once("connect_db.php");
	include_once("server_process.php");
	//LGSL
	require './inc/libs/lgsl/lgsl_class.php';

	$srw_obv_rs = mysql_query("SELECT * FROM `serveri` WHERE `status` = 'Aktivan'");
	while($row = mysql_fetch_array($srw_obv_rs)) {
		$info = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$row[box_id]'"));
		
		$aRS_ID = $row['id'];
		$aRS_VR = $row['autorestart'];

		if ($aRS_VR == "-1") {
			//echo $row['name'].': '."Ova opcija je ugasena.";
		} else {
			$auto_rs_v = date("H");
			//echo $auto_rs_v;

			if ($aRS_VR == $auto_rs_v) {

				$auto_rs_pp = $row['auto_rs'];

				if ($auto_rs_pp == "") {
					$ppppp = mysql_query("UPDATE `serveri` SET `auto_rs` = '1' WHERE `id` = '$aRS_ID'");
				}

				if ($auto_rs_pp == "1") {
					
					$server_ip 		= $info['ip'];
					$ssh_port 		= $info['sshport'];
					$server_port    = $row['port'];
					$ftp_username 	= $row['username'];
					$ftp_password 	= $row['password'];
					$server_slot 	= $row['slotovi'];
					$server_mapa 	= $row['map'];
					$server_fps 	= $row['fps'];
					$server_igraa 	= $row['igra'];

					$server_kom 	= $row['komanda'];
					$server_kom 	= str_replace('{$ip}', $server_ip, $server_kom);
					$server_kom 	= str_replace('{$port}', $server_port, $server_kom);
					$server_kom 	= str_replace('{$slots}', $server_slot, $server_kom);
					$server_kom 	= str_replace('{$map}', $server_mapa, $server_kom);
					$server_kom 	= str_replace('{$fps}', $server_fps, $server_kom);

					if($row['igra'] == "2") {
						$ftp = ftp_connect($server_ip, $info['ftpport']);
						if (!$ftp) {
							$_SESSION['error'] = "No login ftp.";
							die();
						}
						if (ftp_login($ftp, $ftp_username, $ftp_password)){
							ftp_pasv($ftp, true);
							if (!empty($path)) {
								ftp_chdir($ftp, $path);
							} else ftp_chdir($ftp, './');
							    $folder = '_cache/panel_'.$ftp_username.'_samp_server.cfg';
							    $fajl = "ftp://$ftp_username:$ftp_password@$server_ip:$info[ftpport]/server.cfg";
							    $lines = file($fajl, FILE_IGNORE_NEW_LINES);
							
							    $bind = false;
							    $port = false;
							    $maxplayers = false;
							
			    				foreach ($lines as &$line) {
			    					
			    					$val = explode(" ", $line);
			    					
			    					if ($val[0] == "port") {
			    						$val[1] = $server_port;
			    						$line = implode(" ", $val);
			    						$port = true;
			    					}
			    					else if ($val[0] == "maxplayers") {
			    						$val[1] = $server_slot;
			    						$line = implode(" ", $val);
			    						$maxplayers = true;
			    					}
			    					else if ($val[0] == "bind") {
			    						$val[1] = $server_ip;
			    						$line = implode(" ", $val);
			    						$bind = true;
			    					}
			    				}
							    unset($line);
							
							if (!$fw = fopen(''.$folder.'', 'w+')) {
								$_SESSION['error'] = "Putanja se ne poklapa - Grska. SAMP";
								die();
							}
							foreach($lines as $line) {
								$fb = fwrite($fw,$line.PHP_EOL);
							}
							
							if (!$port) {
								fwrite($fw,"port $server_port".PHP_EOL);
							}
							if (!$maxplayers) {
								fwrite($fw,"maxplayers $server_slot".PHP_EOL);
							}
							if (!$bind) {
								fwrite($fw,"bind $server_ip".PHP_EOL);
							}
							
							$remote_file = ''.$path.'/server.cfg';
							if (!ftp_put($ftp, $remote_file, $folder, FTP_BINARY)) {
								$_SESSION['error'] = "Putanja se ne poklapa - SAMP.";
								die();
							}
							fclose($fw);
							unlink($folder);
						}
						ftp_close($ftp);
					}
					//Komanda za izvrsavanje
					$start_server = start_server($server_ip, $ssh_port, $ftp_username, $ftp_password, $server_kom, $server_igraa);

					if ($aRS_Server == "OK") {
						$ppppp = mysql_query("UPDATE `serveri` SET `auto_rs` = '0' WHERE `id` = '$aRS_ID'");
						echo "<br />";
						echo $row['name'].': '."Uspesno restartovan. ".date("h:i:s");
						echo "<br />";
					}
				}

			} else {
				$ppppp = mysql_query("UPDATE `serveri` SET `auto_rs` = '1' WHERE `id` = '$aRS_ID'");
				echo "<br />";
				echo $row['name'].': '."Ova opcija ce se upaliti u: ".$aRS_VR.'h';
				echo "<br />";
			}
		}
	}

} else {
	echo "<br/> Token nije tacan!";
	die();
}

?>