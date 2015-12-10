<?php
namespace Teach\Interactors\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateActiviteit()
    {
        $object = new Factory();
        $layout = $object->createActiviteit("Activerende opening", [
            'inhoud' => '',
            'werkvorm' => "",
            'organisatievorm' => "plenair",
            'werkvormsoort' => "ijsbreker",
            'tijd' => "",
            'intelligenties' => [
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
            ]
        ])->generateLayout(new HTMLFactory());
        $this->assertEquals("Activerende opening", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
    }

    public function testCreateThema()
    {
        $object = new Factory();
        $layout = $object->createThema("Thema caption here", [
            "Activerende opening" => [
                'inhoud' => 'bla die bla',
                'werkvorm' => "",
                'organisatievorm' => "plenair",
                'werkvormsoort' => "ijsbreker",
                'tijd' => "",
                'intelligenties' => [
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
                ]
            ]
        ])->generateLayout(new HTMLFactory());
        $this->assertEquals("Thema caption here", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        
        $row = $layout[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][4];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("inhoud", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals('bla die bla', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    }

    public function testCreateFase()
    {
        $object = new Factory();
        $layout = $object->createFase("Kern")->generateLayout(new HTMLFactory());
        $this->assertEquals("Kern", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
    }

    public function testCreateKern()
    {
        $object = new Factory();
        $layout = $object->createKern([
            "Thema caption here" => [
                "Activerende opening" => [
                    'inhoud' => 'bla die bla',
                    'werkvorm' => "",
                    'organisatievorm' => "plenair",
                    'werkvormsoort' => "ijsbreker",
                    'tijd' => "",
                    'intelligenties' => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
                    ]
                ]
            ]
        ])->generateLayout(new HTMLFactory());
        $this->assertEquals("Kern", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        
        $this->assertEquals("Thema 1: Thema caption here", $layout[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        
        $row = $layout[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][4];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("inhoud", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals('bla die bla', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    }

    public function testCreateIntroductie()
    {
        $object = new Factory();
        $layout = $object->createIntroductie($object->createActiviteit("Activerende opening", [
            'inhoud' => 'Scené uit de matrix tonen waarop wordt gezegd: "I don\'t even see the code". Wie kent deze film? Een ervaren programmeur zal een vergelijkbaar gevoel hebben bij code: programmeren is een visualisatie kunnen uitdrukken in code en vice versa.',
            'werkvorm' => "film",
            'organisatievorm' => "plenair",
            'werkvormsoort' => "ijsbreker",
            'tijd' => "5",
            'intelligenties' => [
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
            ]
        ]), $object->createActiviteit("Focus", [
            "inhoud" => "Visie, Leerdoelen, Programma, Afspraken",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docent gecentreerd",
            "tijd" => "3",
            "intelligenties" => [
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
            ]
        ]), $object->createActiviteit("Voorstellen", [
            "inhoud" => "Voorstellen Docent",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docent gecentreerd",
            "tijd" => "2",
            "intelligenties" => [
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
            ]
        ]))->generateLayout(new HTMLFactory());
        $this->assertEquals("Introductie", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
    }

    public function testCreateAfsluiting()
    {
        $object = new Factory();
        $layout = $object->createAfsluiting(
            $object->createActiviteit("Huiswerk", [
                "inhoud" => [
                    "Challenge voor eerstvolgende les maken",
                    "Practicum opdrachten thuis afronden",
                    "Huiswerk maken als extra oefening"
                ],
                "werkvorm" => "presentatie",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "docentgecentreerd",
                "tijd" => "2",
                "intelligenties" => [
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ]),
            $object->createActiviteit("Evaluatie", [
                "inhoud" => "Verzamelen feedback papiertjes",
                "werkvorm" => "nabespreking",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "ijsbreker",
                "tijd" => "3",
                "intelligenties" => [
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ]),
            $object->createActiviteit("Pakkend slot", [
                "inhoud" => "Foto; gerelateerd aan keuzes/condities. Misschien foto van blauwe/rode pil Matrix.",
                "werkvorm" => "presentatie",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "docentgecentreerd",
                "tijd" => "1",
                "intelligenties" => [
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
                ]
            ])
        )->generateLayout(new HTMLFactory());
        $this->assertEquals("Afsluiting", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
    }
    
    public function testCreateLesplan()
    {
        $object = new Factory();
        
        $introductie = $object->createIntroductie($object->createActiviteit("Activerende opening", [
            'inhoud' => 'Scené uit de matrix tonen waarop wordt gezegd: "I don\'t even see the code". Wie kent deze film? Een ervaren programmeur zal een vergelijkbaar gevoel hebben bij code: programmeren is een visualisatie kunnen uitdrukken in code en vice versa.',
            'werkvorm' => "film",
            'organisatievorm' => "plenair",
            'werkvormsoort' => "ijsbreker",
            'tijd' => "5",
            'intelligenties' => [
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
            ]
        ]), $object->createActiviteit("Focus", [
            "inhoud" => "Visie, Leerdoelen, Programma, Afspraken",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docent gecentreerd",
            "tijd" => "3",
            "intelligenties" => [
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
            ]
        ]), $object->createActiviteit("Voorstellen", [
            "inhoud" => "Voorstellen Docent",
            "werkvorm" => "presentatie",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "docent gecentreerd",
            "tijd" => "2",
            "intelligenties" => [
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
            ]
        ]));
        $kernDefinition = [
            "Zelfstandig eclipse installeren" => [
                "Ervaren" => [
                    "inhoud" => "Tonen afbeeldingen van werkomgevingen: wie herkent de werkomgeving?",
                    "werkvorm" => "verhalen vertellen bij foto's",
                    "organisatievorm" => "plenair",
                    "werkvormsoort" => "ijsbreker",
                    "tijd" => "5",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_NATURALISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ],
                "Reflecteren" => [
                    "inhoud" => [
                        "5 minuten brainstormen om te reflecteren op de voorgaande afbeeldingen.",
                        "De uiteindelijke vraag om te beantwoorden: 'Hoe zou een werkplaats voor een programmeur eruit zien?'",
                        "Wat valt er op aan deze werkplaatsen?",
                        "Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.",
                        "Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?"
                    ],
                    "werkvorm" => "brainstormen",
                    "organisatievorm" => "plenair",
                    "werkvormsoort" => "discussie",
                    "tijd" => "5",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ],
                "Conceptualiseren" => [
                    "inhoud" => [
                        "Kort uitleggen wat IDE/eclipse is (programmeeromgeving]/waarvoor het wordt gebruikt.",
                        "Korte demo ter kennismaking",
                        "Wat zijn de randvoorwaarden van de installatie?"
                    ],
                    "werkvorm" => "presentatie (visueel ondersteunen, laatste sheet met randvoorwaarden open laten)",
                    "organisatievorm" => "plenair",
                    "werkvormsoort" => "docentgecentreerd",
                    "tijd" => "5",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ],
                "Toepassen" => [
                    "inhoud" => [
                        "Student installeert zelf eclipse",
                        "Aanvullende opdracht (capaciteit): importeren voorbeeldproject van blackboard of een nieuw project aanmaken",
                        "Na 10min controleren of dit bij iedereen is gelukt"
                    ],
                    "werkvorm" => "verwerkingsopdracht",
                    "organisatievorm" => "plenair",
                    "werkvormsoort" => "individuele werkopdracht",
                    "tijd" => "18",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
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
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ],
                "Reflecteren" => [
                    "inhoud" => "Studenten met buurman/vrouw overleggen hoeveel verschillende stappen er zijn bij het uitvoeren van een handleiding. Tijdens het uitvoeren van taken voeren wij onbewust veel contextgevoelige taken uit een computer kent dit niet.",
                    "werkvorm" => "brainstormen",
                    "organisatievorm" => "groepswerk",
                    "werkvormsoort" => "discussie",
                    "tijd" => "5",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ],
                "Conceptualiseren" => [
                    "inhoud" => "Tonen pseudo-code bij vorig recept of handleiding (bijv. IKEA handleiding)",
                    "werkvorm" => "demonstratie",
                    "organisatievorm" => "plenair",
                    "werkvormsoort" => "docentgecentreerd",
                    "tijd" => "10",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ],
                "Toepassen" => [
                    "inhoud" => [
                        "SIMPEL: uitleggen wat de code doet",
                        "BASIS: schrijven pseudo-code",
                        "COMPLEX: zelf code schrijven, als voorschot op volgende week (extra uitdaging)."
                    ],
                    "werkvorm" => "verwerkingsopdracht",
                    "organisatievorm" => "plenair",
                    "werkvormsoort" => "individuele werkopdracht",
                    "tijd" => "30",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
                    ]
                ]
            ]
        ];
        $kern = $object->createKern($kernDefinition);
        $afsluiting = $object->createAfsluiting(
            $object->createActiviteit("Huiswerk", [
                "inhoud" => [
                    "Challenge voor eerstvolgende les maken",
                    "Practicum opdrachten thuis afronden",
                    "Huiswerk maken als extra oefening"
                ],
                "werkvorm" => "presentatie",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "docentgecentreerd",
                "tijd" => "2",
                "intelligenties" => [
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ]),
            $object->createActiviteit("Evaluatie", [
                "inhoud" => "Verzamelen feedback papiertjes",
                "werkvorm" => "nabespreking",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "ijsbreker",
                "tijd" => "3",
                "intelligenties" => [
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ]),
            $object->createActiviteit("Pakkend slot", [
                "inhoud" => "Foto; gerelateerd aan keuzes/condities. Misschien foto van blauwe/rode pil Matrix.",
                "werkvorm" => "presentatie",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "docentgecentreerd",
                "tijd" => "1",
                "intelligenties" => [
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
                ]
            ])
        );
        $contactmoment = $object->createContactmoment([
            'doelgroep' => [
                'beschrijving' => 'eerstejaars HBO-studenten',
                'ervaring' => 'geen', // <!-- del>veel</del>, <del>redelijk veel</del>, <del>weinig</del>, -->geen
                'grootte' => '16 personen'
            ],
            'starttijd' => '08:45',
            'eindtijd' => '10:20',
            'duur' => '95',
            'ruimte' => 'beschikking over vaste computers',
            'overige' => 'nvt'
        ], [
            'filmfragment matrix',
            'countdown timer voor toepassingsfases (optioneel)',
            'voorbeeld IKEA-handleiding + uitgewerkte pseudo-code',
            'rode en groene briefjes/post-its voor feedback',
            'presentatie',
            'voorbeeldproject voor aanvullende feedback'
        ], array_keys($kernDefinition));
        
        $layout = $object->createLesplan('HBO-informatica (voltijd)', 'Programmeren 1', 'Blok 1 / Week 1 / Les 1', $contactmoment, $introductie, $kern, $afsluiting)->generateLayout(new HTMLFactory());
        
        $this->assertEquals('header', $layout[0][HTMLFactory::TAG]);
        $this->assertEquals("h1", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Lesplan Programmeren 1", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        ;
    }
}
