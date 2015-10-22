<?php
$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$lesplanLocator = $applicationBootstrap();

$lesplan = $lesplanLocator('les1');

function renderActiviteit($naam, array $werkvorm)
{
    $fase = new \Teach\Adapters\Web\Lesplan\Activiteit($naam, $werkvorm);
    $factory = new \Teach\Adapters\HTML\Factory();
    print $factory->makeHTMLFrom($fase);
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Lesplan</title>
<link rel="stylesheet" type="text/css" href="lesplan.css">
</head>
<body>
 <header>
  <h1>Lesplan <?=htmlentities($lesplan['vak']);?></h1>
 </header>
 <section>
  <h2><?=htmlentities($lesplan['les']);?></h2>
  <h3>Beginsituatie</h3>
  <table class="two-columns">
   <tr>
    <th>doelgroep</th>
    <td><?=htmlentities($lesplan['Beginsituatie']['doelgroep']['beschrijving']);?></td>
    <th>opleiding</th>
    <td><?=htmlentities($lesplan['opleiding']);?>
    </td>
   </tr>
   <tr>
    <th>ervaring</th>
    <td><?=htmlentities($lesplan['Beginsituatie']['doelgroep']['ervaring']);?></td>
    <th>groepsgrootte</th>
    <td><?=htmlentities($lesplan['Beginsituatie']['doelgroep']['grootte']);?></td>
   </tr>
   <tr>
    <th>tijd</th>
    <td colspan="3">van <strong><?=htmlentities($lesplan['Beginsituatie']['starttijd']);?></strong> tot <strong><?=htmlentities($lesplan['Beginsituatie']['eindtijd']);?></strong> (<?=htmlentities($lesplan['Beginsituatie']['duur']);?>)</td>
   </tr>
   <tr>
    <th>ruimte</th>
    <td colspan="3"><?=htmlentities($lesplan['Beginsituatie']['ruimte']);?></td>
   </tr>
   <tr>
    <th>overige</th>
    <td colspan="3"><?=htmlentities($lesplan['Beginsituatie']['overige']);?></td>
   </tr>
  </table>
   <?php 
   if (count($lesplan['Beginsituatie']['media']) > 0) {
       ?>
      <h3>Benodigde media</h3>
      <ul><?php
        foreach ($lesplan['Beginsituatie']['media'] as $mediaIdentifier) {
            ?><li><?=htmlentities($mediaIdentifier  ); ?></li><?php
        }
        ?></ul>
       <?php
   }
   
   ?>
  <h3>Leerdoelen</h3>
  <p>Na afloop van de les kan de student:</p>
  <ol>
			<?php
foreach (array_keys($lesplan['Kern']) as $themaIdentifier) {
    ?><li><?=htmlentities($themaIdentifier); ?></li><?php
}
?>
		</ol>
 </section>
 <section>
  <h2>Introductie</h2>
		<?php
foreach ($lesplan['Introductie'] as $activiteitIdentifier => $activiteit) {
    renderActiviteit($activiteitIdentifier, $activiteit);
}
?>
    </section>
 <hr />
 <section>
  <h2>Kern</h2>
		<?php
$themaCounter = 1;
foreach ($lesplan['Kern'] as $themaIdentifier => $thema) {
    ?><section>
   <h3>Thema <?=$themaCounter;?>: <?=htmlentities($themaIdentifier);?></h3><?php
    foreach ($thema as $activiteitIdentifier => $activiteit) {
        renderActiviteit($activiteitIdentifier, $activiteit);
    }
    $themaCounter ++;
    ?></section><?php
}
?>    	
	</section>
 <hr />
 <section>
  <h2>Afsluiting</h2>
		<?php
foreach ($lesplan['Afsluiting'] as $activiteitIdentifier => $activiteit) {
    renderActiviteit($activiteitIdentifier, $activiteit);
}
?>
    </section>
</body>
</html>