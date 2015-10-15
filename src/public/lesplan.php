<?php
$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$applicationBootstrap();

$onderdelen = array(
    'Introductie' => array(
        "Activerende opening" => array(
            'inhoud' => 'Scené uit de matrix tonen waarop wordt gezegd: "I don\'t even see the code". Wie kent deze film? Een ervaren programmeur zal een vergelijkbaar gevoel hebben bij code: programmeren is een visualisatie kunnen uitdrukken in code en vice versa.',
            'werkvorm' => "film",
            'organisatievorm' => "plenair",
            'werkvormsoort' => "ijsbreker",
            'tijd' => "5",
            'intelligenties' => array(
                MI_VERBAAL_LINGUISTISCH,
                MI_VISUEEL_RUIMTELIJK,
                MI_INTERPERSOONLIJK,
                MI_INTRAPERSOONLIJK
            )
        ),
        "Focus" => array(
            "inhoud" => "Visie, Leerdoelen, Programma, Afspraken",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docent gecentreerd",
            "tijd" => "4",
            "intelligenties" => array(
                MI_VERBAAL_LINGUISTISCH,
                MI_LOGISCH_MATHEMATISCH,
                MI_INTERPERSOONLIJK
            )
        ),
        "Voorstellen" => array(
            "inhoud" => "Voorstellen Docent",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docent gecentreerd",
            "tijd" => "4",
            "intelligenties" => array(
                MI_VERBAAL_LINGUISTISCH,
                MI_LOGISCH_MATHEMATISCH,
                MI_INTERPERSOONLIJK
            )
        )
    ),
    'Kern' => array(
        "Zelfstandig eclipse installeren" => array(
            "Ervaren" => array(
                "inhoud" => "Tonen afbeeldingen van werkomgevingen: wie herkent de werkomgeving?",
                "werkvorm" => "verhalen vertellen bij foto's",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "ijsbreker",
                "tijd" => "5",
                "intelligenties" => array(
                    MI_VERBAAL_LINGUISTISCH,
                    MI_VISUEEL_RUIMTELIJK,
                    MI_NATURALISTISCH,
                    MI_INTERPERSOONLIJK
                )
            ),
            "Reflecteren" => array(
                "inhoud" => "•	Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.
•	Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?",
                "werkvorm" => "brainstormen",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "discussie",
                "tijd" => "5",
                "intelligenties" => array(
                    MI_VERBAAL_LINGUISTISCH,
                    MI_INTRAPERSOONLIJK,
                    MI_INTERPERSOONLIJK
                )
            ),
            "Conceptualiseren" => array(
                "inhoud" => "•	Kort uitleggen wat IDE/eclipse is (programmeeromgeving)/waarvoor het wordt gebruikt. 
•	Korte demo ter kennismaking
•	Wat zijn de randvoorwaarden van de installatie?",
                "werkvorm" => "presentatie (visueel ondersteunen, laatste sheet met randvoorwaarden open laten)",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "docentgecentreerd",
                "tijd" => "5",
                "intelligenties" => array(
                    MI_VERBAAL_LINGUISTISCH,
                    MI_VISUEEL_RUIMTELIJK,
                    MI_INTERPERSOONLIJK
                )
            ),
            "Toepassen" => array(
                "inhoud" => "•	Student installeert zelf eclipse
•	Aanvullende opdracht (capaciteit): importeren voorbeeldproject van blackboard of een nieuw project aanmaken
•	Na 10min controleren of dit bij iedereen is gelukt",
                "werkvorm" => "verwerkingsopdracht",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "individuele werkopdracht",
                "tijd" => "15",
                "intelligenties" => array(
                    MI_VERBAAL_LINGUISTISCH,
                    MI_INTRAPERSOONLIJK
                )
            )
        ),
        "Java-code lezen en uitleggen wat er gebeurt" => array(
            "Ervaren" => array(
                "inhoud" => "Achterhalen wie wel eens adhv van een recept/handleiding heeft gewerkt.",
                "werkvorm" => "metafoor",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "ijsbreker",
                "tijd" => "5",
                "intelligenties" => array(
                    MI_VERBAAL_LINGUISTISCH,
                    MI_INTERPERSOONLIJK
                )
            ),
            "Reflecteren" => array(
                "inhoud" => "Studenten met buurman/vrouw overleggen hoeveel verschillende stappen er zijn bij het uitvoeren van een handleiding. Tijdens het uitvoeren van taken voeren wij onbewust veel contextgevoelige taken uit een computer kent dit niet.",
                "werkvorm" => "brainstormen",
                "organisatievorm" => "groepswerk",
                "werkvormsoort" => "discussie",
                "tijd" => "5",
                "intelligenties" => array(
                    MI_VERBAAL_LINGUISTISCH,
                    MI_LOGISCH_MATHEMATISCH,
                    MI_INTRAPERSOONLIJK,
                    MI_INTERPERSOONLIJK
                )
            ),
            "Conceptualiseren" => array(
                "inhoud" => "Tonen pseudo-code bij vorig recept of handleiding (bijv. IKEA handleiding)",
                "werkvorm" => "demonstratie",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "docentgecentreerd",
                "tijd" => "10",
                "intelligenties" => array(
                    MI_VERBAAL_LINGUISTISCH,
                    MI_VISUEEL_RUIMTELIJK,
                    MI_INTERPERSOONLIJK
                )
            ),
            "Toepassen" => array(
                "inhoud" => "Studenten voeren SIMPEL (waarin zij moeten uitleggen wat de code doet) en BASIS (schrijven pseudo-code) opdrachten uit. Eventueel COMPLEX (zelf code schrijven) als voorschot op volgende week.",
                "werkvorm" => "verwerkingsopdracht",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "individuele werkopdracht",
                "tijd" => "30",
                "intelligenties" => array(
                    MI_VERBAAL_LINGUISTISCH,
                    MI_INTRAPERSOONLIJK
                )
            )
        )
    ),
    'Afsluiting' => array(
        "Huiswerk" => array(
            "inhoud" => "-	Challenge voor eerstvolgende les maken
-	Practicum opdrachten thuis afronden
-	Huiswerk maken als extra oefening",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docentgecentreerd",
            "tijd" => "2",
            "intelligenties" => array(
                MI_VERBAAL_LINGUISTISCH,
                MI_INTERPERSOONLIJK
            )
        ),
        "Evaluatie" => array(
            "inhoud" => "Verzamelen feedback papiertjes",
            "werkvorm" => "nabespreking",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "ijsbreker",
            "tijd" => "3",
            "intelligenties" => array(
                MI_VERBAAL_LINGUISTISCH,
                MI_INTERPERSOONLIJK
            )
        ),
        "Pakkend slot" => array(
            "inhoud" => "Foto",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docentgecentreerd",
            "tijd" => "1",
            "intelligenties" => array(
                MI_VERBAAL_LINGUISTISCH,
                MI_VISUEEL_RUIMTELIJK,
                MI_INTRAPERSOONLIJK
            )
        )
    )
);

function renderFase($naam, array $werkvorm)
{
    $beschikbareIntelligenties = array(
        MI_VERBAAL_LINGUISTISCH => "VL",
        MI_LOGISCH_MATHEMATISCH => "LM",
        MI_VISUEEL_RUIMTELIJK => "VR",
        MI_MUZIKAAL_RITMISCH => "MR",
        MI_LICHAMELIJK_KINESTHETISCH => "LK",
        MI_NATURALISTISCH => "N",
        MI_INTERPERSOONLIJK => "IR",
        MI_INTRAPERSOONLIJK => "IA"
    );
    
    ?>
<table class="two-columns">
 <caption><?=htmlentities($naam); ?></caption>
 <tr>
  <th>werkvorm</th>
  <td><?=htmlentities($werkvorm['werkvorm']); ?></td>
  <th>organisatievorm</th>
  <td><?=htmlentities($werkvorm['organisatievorm']); ?></td>
 </tr>
 <tr>
  <th>tijd</th>
  <td><?=htmlentities($werkvorm['tijd']); ?> minuten</td>
  <th>soort werkvorm</th>
  <td><?=htmlentities($werkvorm['werkvormsoort']); ?></td>
 </tr>
 <tr>
  <th>intelligenties</th>
  <td colspan="3">
   <ul class="meervoudige-intelligenties">
					<?php
    foreach ($beschikbareIntelligenties as $beschikbareIntelligentieIdentifier => $beschikbareIntelligentie) {
        $selected = in_array($beschikbareIntelligentieIdentifier, $werkvorm['intelligenties']);
        ?><li
     id="<?= htmlentities($beschikbareIntelligentieIdentifier); ?>"
     <?=($selected ? ' class="selected"' : '');?>
    ><?=htmlentities($beschikbareIntelligentie); ?></li><?php
    }
    ?>
				</ul>
  </td>
 </tr>
 <tr>
  <th>inhoud</th>
  <td colspan="3"><?=htmlentities($werkvorm['inhoud']); ?></td>
 </tr>
</table>
<?php
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
  <h1>Lesplan programmeren</h1>
 </header>
 <section>
  <h2>Blok 1 / Week 1 / Les 1</h2>
  <h3>Beginsituatie</h3>
  <table class="two-columns">
   <tr>
    <th>doelgroep</th>
    <td>eerstejaars HBO-studenten</td>
    <th>opleiding</th>
    <td>HBO-informatica (<del>deeltijd</del>/voltijd)
    </td>
   </tr>
   <tr>
    <th>ervaring</th>
    <td><del>veel</del>, <del>redelijk veel</del>, <del>weinig</del>,
     geen</td>
    <th>groepsgrootte</th>
    <td>ca. 16 personen</td>
   </tr>
   <tr>
    <th>tijd</th>
    <td>van <strong>8:45</strong> tot <strong>10:20</strong> (45
     minuten)
    </td>
    <th>ruimte</th>
    <td>beschikking over vaste computers</td>
   </tr>
   <tr>
    <th>overige</th>
    <td colspan="3">nvt</td>
   </tr>
  </table>
  <h3>Benodigde media</h3>
  <ul>
   <li>filmfragment matrix</li>
   <li>rode en groene briefjes/post-its voor feedback</li>
   <li>presentatie</li>
   <li>voorbeeldproject voor aanvullende feedback</li>
  </ul>
  <h3>Leerdoelen</h3>
  <p>Na afloop van de les kan de student:</p>
  <ol>
			<?php
foreach (array_keys($onderdelen['Kern']) as $themaIdentifier) {
    ?><li><?=htmlentities($themaIdentifier); ?></li><?php
}
?>
		</ol>
 </section>
 <section>
  <h2>Introductie</h2>
		<?php
foreach ($onderdelen['Introductie'] as $faseIdentifier => $fase) {
    renderFase($faseIdentifier, $fase);
}
?>
    </section>
 <hr />
 <section>
  <h2>Kern</h2>
		<?php
$themaCounter = 1;
foreach ($onderdelen['Kern'] as $themaIdentifier => $thema) {
    ?><section>
   <h3>Thema <?=$themaCounter;?>: <?=htmlentities($themaIdentifier);?></h3><?php
    foreach ($thema as $faseIdentifier => $fase) {
        renderFase($faseIdentifier, $fase);
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
foreach ($onderdelen['Afsluiting'] as $faseIdentifier => $fase) {
    renderFase($faseIdentifier, $fase);
}
?>
    </section>
</body>
</html>