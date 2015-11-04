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
$lesplan = new \Teach\Adapters\Web\Lesplan('Lesplan ' . $lesplanDefinition['vak'], $lesplanDefinition['les']);
print $HTMLfactory->makeHTMLFrom($lesplan);
?>
 <section>
  <h2><?=htmlentities($lesplanDefinition['les']);?></h2>
  <?php 
  $beginsituatie = new \Teach\Adapters\Web\Lesplan\Beginsituatie($lesplanDefinition['opleiding'], $lesplanDefinition['Beginsituatie']);
    print $HTMLfactory->makeHTMLFrom($beginsituatie);
if (count($lesplanDefinition['media']) > 0) {
    ?>
      <h3>Benodigde media</h3>
  <ul><?php
    foreach ($lesplanDefinition['media'] as $mediaIdentifier) {
        ?><li><?=htmlentities($mediaIdentifier); ?></li><?php
    }
    ?></ul>
       <?php
}

?>
  <h3>Leerdoelen</h3>
  <p>Na afloop van de les kan de student:</p>
  <ol>
			<?php
foreach (array_keys($lesplanDefinition['Kern']) as $themaIdentifier) {
    ?><li><?=htmlentities($themaIdentifier); ?></li><?php
}
?>
		</ol>
 </section>
<?php
$introductie = $lesplanFactory->createFase('Introductie');
foreach ($lesplanDefinition['Introductie'] as $activiteitIdentifier => $activiteitDefinition) {
    $activiteit = $lesplanFactory->createActiviteit($activiteitIdentifier, $activiteitDefinition);
    $introductie->addOnderdeel($activiteit);
}
print $HTMLfactory->makeHTMLFrom($introductie);

$kern = $lesplanFactory->createFase('Kern');
$themaCounter = 1;
foreach ($lesplanDefinition['Kern'] as $themaIdentifier => $themaDefinition) {
    $thema = $lesplanFactory->createThema('Thema ' . $themaCounter . ': ' . $themaIdentifier);
    foreach ($themaDefinition as $activiteitIdentifier => $activiteitDefinition) {
        $thema->addActiviteit($lesplanFactory->createActiviteit($activiteitIdentifier, $activiteitDefinition));
    }
    $kern->addOnderdeel($thema);
    $themaCounter ++;
}
print $HTMLfactory->makeHTMLFrom($kern);

$afsluiting = $lesplanFactory->createFase('Afsluiting');
foreach ($lesplanDefinition['Introductie'] as $activiteitIdentifier => $activiteitDefinition) {
    $activiteit = $lesplanFactory->createActiviteit($activiteitIdentifier, $activiteitDefinition);
    $afsluiting->addOnderdeel($activiteit);
}
print $HTMLfactory->makeHTMLFrom($afsluiting);

?>
</body>
</html>