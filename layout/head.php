<?php error_reporting(0);

$parts = explode('/', __FILE__);
$filename = $parts[count($parts) - 1];

if (strpos($_SERVER["SCRIPT_URI"], $filename) !== false) {
	exit("illegal method");
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?></title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <link rel="manifest" href="ggs-network.de/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="GGS Network">
    <link rel="apple-touch-icon" href="https://ggs-network.de/image/chat/Icon.png" >
    <link rel="apple-touch-icon" sizes="76x76" href="https://ggs-network.de/image/chat/Icon.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://ggs-network.de/image/chat/Icon.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://ggs-network.de/image/chat/Icon.png">

    <link rel="icon" type="image/gif" href="https://ggs-network.de/image/chat/Icon.gif" />
</head>