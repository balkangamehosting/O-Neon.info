<?php 

	error_reporting(0); 

	$url = htmlspecialchars(mysql_real_escape_string(addslashes($_GET['l'])));

	if ($url == "") {
		echo "Netacan parametar... <br /> Primer: rdr.php?l=http://vas_sajt";
	} else {
		header('Location:'.$url);
	}

?>