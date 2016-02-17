<?php
if (array_key_exists('contactmoment', $_GET) === false) {
    http_response_code(400);
    exit();
}

$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$lesplanLocator = $applicationBootstrap();

/** @var $lesplan \Teach\Entities\Contactmoment */
$lesplan = $lesplanLocator($_GET['contactmoment']);
if ($lesplan === null) {
    http_response_code(404);
    exit();
}

$HTMLfactory = new \Teach\Adapters\HTML\Factory();

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Lesplan</title>
<link rel="stylesheet" type="text/css" href="lesplan.css">
</head>
<body>
<?php
print $HTMLfactory->makeHTMLFrom($lesplan);

?>
</body>
</html>