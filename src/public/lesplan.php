<?php
if (array_key_exists('contactmoment', $_GET) === false) {
    http_response_code(400);
    exit();
}

$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$lesplanLocator = $applicationBootstrap();

$lesplanDefinition = $lesplanLocator($_GET['contactmoment']);
if ($lesplanDefinition === null) {
    http_response_code(404);
    exit();
}

$HTMLfactory = new \Teach\Adapters\HTML\Factory();
$lesplanFactory = new \Teach\Interactors\Web\Lesplan\Factory();

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
print $HTMLfactory->makeHTMLFrom($lesplanFactory->createLesplan($lesplanDefinition));

?>
</body>
</html>