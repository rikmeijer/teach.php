<?php
$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$applicationBootstrap();

$url = 'http://' . $_SERVER['SERVER_ADDR'] . '/feedback.php';
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="refresh" content="2">
<title>Feedback</title>

<style>
body { font-family: arial, sans-serif;}
</style>
</head>
<body>
<center>
<h1>Feedback-o-meter (eduroam only)</h1>
<img src="/rating.php" width="500" height="100" style="margin: 25px 0;"/></br>
<img src="/qr.php?data=<?php print htmlentities(rawurlencode($url));?>" width="400" height="400" />
<p><?php print htmlentities($url); ?></p>
</center>
</body>
</html>