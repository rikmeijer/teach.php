<?php
$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$applicationBootstrap();

$lesplan = [
    'opleiding' => 'HBO-informatica (voltijd]', // <!--  del>deeltijd</del>/-->
    'vak' => 'Programmeren 1',
    'les' => 'Blok 1 / Week 1 / Les 1',
    'Beginsituatie' => [
        'doelgroep' => [
            'beschrijving' => 'eerstejaars HBO-studenten',
            'ervaring' => 'geen', // <!--  del>veel</del>, <del>redelijk veel</del>, <del>weinig</del>, -->geen
            'grootte' => '16 personen'
        ],
        'starttijd' => '08:45',
        'eindtijd' => '10:20',
        'duur' => '95 minuten',
        'ruimte' => 'beschikking over vaste computers',
        'overige' => 'nvt',
        'media' => [
            'filmfragment matrix',
            'rode en groene briefjes/post-its voor feedback',
            'presentatie',
            'voorbeeldproject voor aanvullende feedback',
        ]
    ],
    'Introductie' => [
        "Activerende opening" => [
            'inhoud' => 'Scené uit de matrix tonen waarop wordt gezegd: "I don\'t even see the code". Wie kent deze film? Een ervaren programmeur zal een vergelijkbaar gevoel hebben bij code: programmeren is een visualisatie kunnen uitdrukken in code en vice versa.',
            'werkvorm' => "film",
            'organisatievorm' => "plenair",
            'werkvormsoort' => "ijsbreker",
            'tijd' => "5",
            'intelligenties' => [
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
            ]
        ],
        "Focus" => [
            "inhoud" => "Visie, Leerdoelen, Programma, Afspraken",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docent gecentreerd",
            "tijd" => "4",
            "intelligenties" => [
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
            ]
        ],
        "Voorstellen" => [
            "inhoud" => "Voorstellen Docent",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docent gecentreerd",
            "tijd" => "4",
            "intelligenties" => [
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
            ]
        ]
    ],
    'Kern' => [
        "Zelfstandig eclipse installeren" => [
            "Ervaren" => [
                "inhoud" => "Tonen afbeeldingen van werkomgevingen: wie herkent de werkomgeving?",
                "werkvorm" => "verhalen vertellen bij foto's",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "ijsbreker",
                "tijd" => "5",
                "intelligenties" => [
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_NATURALISTISCH,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ],
            "Reflecteren" => [
                "inhoud" => "•	Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.
•	Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?",
                "werkvorm" => "brainstormen",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "discussie",
                "tijd" => "5",
                "intelligenties" => [
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ],
            "Conceptualiseren" => [
                "inhoud" => "•	Kort uitleggen wat IDE/eclipse is (programmeeromgeving]/waarvoor het wordt gebruikt. 
•	Korte demo ter kennismaking
•	Wat zijn de randvoorwaarden van de installatie?",
                "werkvorm" => "presentatie (visueel ondersteunen, laatste sheet met randvoorwaarden open laten]",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "docentgecentreerd",
                "tijd" => "5",
                "intelligenties" => [
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ],
            "Toepassen" => [
                "inhoud" => "•	Student installeert zelf eclipse
•	Aanvullende opdracht (capaciteit]: importeren voorbeeldproject van blackboard of een nieuw project aanmaken
•	Na 10min controleren of dit bij iedereen is gelukt",
                "werkvorm" => "verwerkingsopdracht",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "individuele werkopdracht",
                "tijd" => "15",
                "intelligenties" => [
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
                ]
            ]
        ],
        "Java-code lezen en uitleggen wat er gebeurt" => [
            "Ervaren" => [
                "inhoud" => "Achterhalen wie wel eens adhv van een recept/handleiding heeft gewerkt.",
                "werkvorm" => "metafoor",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "ijsbreker",
                "tijd" => "5",
                "intelligenties" => [
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ],
            "Reflecteren" => [
                "inhoud" => "Studenten met buurman/vrouw overleggen hoeveel verschillende stappen er zijn bij het uitvoeren van een handleiding. Tijdens het uitvoeren van taken voeren wij onbewust veel contextgevoelige taken uit een computer kent dit niet.",
                "werkvorm" => "brainstormen",
                "organisatievorm" => "groepswerk",
                "werkvormsoort" => "discussie",
                "tijd" => "5",
                "intelligenties" => [
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ],
            "Conceptualiseren" => [
                "inhoud" => "Tonen pseudo-code bij vorig recept of handleiding (bijv. IKEA handleiding]",
                "werkvorm" => "demonstratie",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "docentgecentreerd",
                "tijd" => "10",
                "intelligenties" => [
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ],
            "Toepassen" => [
                "inhoud" => "Studenten voeren SIMPEL (waarin zij moeten uitleggen wat de code doet] en BASIS (schrijven pseudo-code] opdrachten uit. Eventueel COMPLEX (zelf code schrijven] als voorschot op volgende week.",
                "werkvorm" => "verwerkingsopdracht",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "individuele werkopdracht",
                "tijd" => "30",
                "intelligenties" => [
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
                ]
            ]
        ]
    ],
    'Afsluiting' => [
        "Huiswerk" => [
            "inhoud" => "-	Challenge voor eerstvolgende les maken
-	Practicum opdrachten thuis afronden
-	Huiswerk maken als extra oefening",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docentgecentreerd",
            "tijd" => "2",
            "intelligenties" => [
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
            ]
        ],
        "Evaluatie" => [
            "inhoud" => "Verzamelen feedback papiertjes",
            "werkvorm" => "nabespreking",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "ijsbreker",
            "tijd" => "3",
            "intelligenties" => [
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
            ]
        ],
        "Pakkend slot" => [
            "inhoud" => "Foto",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docentgecentreerd",
            "tijd" => "1",
            "intelligenties" => [
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
            ]
        ]
    ]
];

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