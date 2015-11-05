<?php
if (array_key_exists('lesplan', $_GET) === false) {
    http_response_code(400);
    exit();
}

$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$lesplanLocator = $applicationBootstrap();

$lesplanDefinition = $lesplanLocator($_GET['lesplan']);
if ($lesplanDefinition === null) {
    http_response_code(404);
    exit();
}

$HTMLfactory = new \Teach\Adapters\HTML\Factory();
$lesplanFactory = new \Teach\Adapters\Web\Lesplan\Factory();

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
$beginsituatie = $lesplanFactory->createBeginsituatie($lesplanDefinition['opleiding'], $lesplanDefinition['Beginsituatie']);
$introductie = $lesplanFactory->createFase('Introductie');
foreach ($lesplanDefinition['Introductie'] as $activiteitIdentifier => $activiteitDefinition) {
    $activiteit = $lesplanFactory->createActiviteit($activiteitIdentifier, $activiteitDefinition);
    $introductie->addOnderdeel($activiteit);
}

$kern = $lesplanFactory->createKern($lesplanDefinition['Kern']);

$afsluiting = $lesplanFactory->createFase('Afsluiting');
foreach ($lesplanDefinition['Afsluiting'] as $activiteitIdentifier => $activiteitDefinition) {
    $activiteit = $lesplanFactory->createActiviteit($activiteitIdentifier, $activiteitDefinition);
    $afsluiting->addOnderdeel($activiteit);
}
$lesplan = new \Teach\Adapters\Web\Lesplan($lesplanDefinition['vak'], $lesplanDefinition['les'], $beginsituatie, $lesplanDefinition['media'], array_keys($lesplanDefinition['Kern']), $introductie, $kern, $afsluiting);
print $HTMLfactory->makeHTMLFrom($lesplan);

?>
</body>
</html>