<?php  
/****************************************************************
 * Gamehoster.biz | Support (Admin Panel) extension for Chrome
 * Version 1.0
 * @author Muhamed Skoko - dev.kevia@gmail.com
 ***************************************************************/
include('../../public_html/connect_db.php');

/* Admin Panel Login */

if (isset($_GET['task']) && $_GET['task'] == "login") {

	$username = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['username'])));
	$password = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['password'])));

	if ($username == ""||$password == "") {
		echo "false";
		return false;
	}

	$pass = md5($password);

	$kveri = mysql_query("SELECT * FROM `admin` WHERE `username` = '$username' AND `password` = '$pass'");
	if (mysql_num_rows($kveri)) {

		$user = mysql_fetch_array($kveri);

		echo $username = $user['username'];

		$log_msg = "Support [APP] Uspesan login.";
		$v_d = date('d.m.Y, H:i:s');
		$ip = get_client_ip();

		mysql_query("INSERT INTO `logovi` (`id`, `clientid`, `message`, `name`, `ip`, `vreme`, `adminid`) VALUES (NULL, NULL, '$log_msg', '$log_msg', '$ip', '$v_d', '$user[id]');");
        
        echo "true";
		return true;
		die();
	} else {
		echo "false";
		return false;
		die();
	}

}

/* Tiket ROW */

if (isset($_GET['task']) && $_GET['task'] == "get_tiket_row") {
	$kveri = mysql_query("SELECT * FROM `tiketi` WHERE `status` = '1'");
	if (mysql_num_rows($kveri)) {
		$rokaj = mysql_fetch_array($kveri);
		
		echo mysql_num_rows($kveri);

		//echo $rokaj['naslov'];
		//echo $rokaj['poruka'];
		return true;
	} else {
		echo "0";
		return false;
	}
}

?>