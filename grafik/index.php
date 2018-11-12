<?php

$ipAdr = $_GET['ip'];
$ipPor = $_GET['port'];
$baner = $_GET['baner'];
$apilink = json_decode(@file_get_contents('http://api.gametracker.rs/demo/json/server_info/'.$ipAdr.':'.$ipPor));

$greska = $apilink->apiError;

if ($greska == "1") {
	$txt = "Pogledajte dali je vas server dodat na";
	$txt2 = "GameTracker.rs!";
	$im = imagecreatetruecolor(350, 150);
	$bg = imagecolorallocate($im, 0,  16,  28);
	$fg = imagecolorallocate($im, 255, 255, 255);
	imagefill($im, 0, 0, $bg);
	imagestring($im, 5, 5, 30,  $txt, $fg);
	imagestring($im, 20, 100, 50,  $txt2, $fg);
	header("Cache-Control: no-cache, must-revalidate");
	header('Content-type: image/png');
	imagepng($im);
	imagedestroy($im);
} else {
	require_once('classes/gtapi.php');
	$gtapi = new kevia_gt_api($ipAdr, $ipPor);

	//$gtapi->GraficonInBanner();

	//echo $gtapi->gt_platyer();
if($baner=="false")
{
		echo $gtapi->GTBigGraficonPlayer();
}
if($baner=="true")
{
		echo $gtapi->GTBaner();
}

	//echo $gtapi->GetServerHostedMap();
	//echo $gtapi->GetCurrentMapImage();

}

?>