<?php  
	// IP&PORT
	$ip = "31.172.80.47";
	$port = "22";

	// User&PW
	$ssh_user = "root";
	$ssh_pw = "jebemtimater1992:p#";
	
	// connect SSH
	if(!$conn = ssh2_connect($ip, $port)){
		return "Ne mogu se spojiti na server";
	} else {

		if(!ssh2_auth_password($conn, $ssh_user, $ssh_pw)){
			return "Netacni podatci za prijavu";
		} else {  	    
			$stream = ssh2_exec($conn, "cd /home");
			$stream = ssh2_exec($conn, "cd ms");
			$stream = ssh2_exec($conn, "cd app");
			$stream = ssh2_exec($conn, "./run.sh");
			echo "Uspesno.";
			return TRUE;
		}
	}

?>