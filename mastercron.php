<?php
//MASTER CRON PROVERA 2 DANA IZBACUJE SERVER SA BOOSTA
//ROOT
include 'connect_db.php';

$masterserveriq = $mdb->query("SELECT * FROM `t2`");
$br = 0;
while($row = mysqli_fetch_array($masterserveriq)) {
$vremeboosta = htmlspecialchars(mysqli_real_escape_string($mdb, addslashes($row['vreme'])));
$vrmbst = new DateTime($vremeboosta);
$istice = $vrmbst->modify('+2 day')->format('Y-m-d H:i:s');

if(strtotime($istice)<strtotime($vremeboosta))
{
	$querystr = "DELETE FROM `t2` WHERE `ipport`='$row[ipport]'";
	if($mdb->query($querystr)=== TRUE)
	{
	$br++;			
	}
}
	echo "Uspešno obrisano sa master servera ". $br. " servera";

}
?>