<head>
	<meta charset="UTF-8">
    <title>GameHoster.biz & Boostcsgroup GmbH</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="keywords" content="gamehosting,gameserver,cs1.6,cs,gta,mc">
    <meta name="author" content="Muhamed Skoko (Kevia)">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	
    <link rel="shortcut icon" href="../img/logo/logo.png"> <!-- LOGO, ICON -->

    <!-- CSS Povezivanje -->
    <link href="../css/style.css?<?php echo time(); ?>" rel="stylesheet" media="all">
    <link href="../css/mobile.css?<?php echo time(); ?>" rel="stylesheet" media="all">
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="all">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" media="all">
</head>

<?php $lan = $_GET['lan'];
if($lan == "en") {
    $dodatni_link = "?lan=en";
} elseif($lan == "de") {
    $dodatni_link = "?lan=de";
} else {
    $dodatni_link = "";
}
?>