<?php
return function (\mysqli $database) {
    return [
        'opleiding' => 'HBO-informatica (voltijd)', // <!-- del>deeltijd</del>/-->
        'vak' => 'Programmeren 1',
        'les' => 'Blok 1 / Week 2 / Les 1',
        'Beginsituatie' => [
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
        ],
        'media' => [],
        'Introductie' => [
            "Activerende opening" => [
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
            ],
            "Focus" => [
                "inhoud" => "Visie, Leerdoelen, Programma, Afspraken",
                "werkvorm" => "presentatie",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "docent gecentreerd",
                "tijd" => "4",
                "intelligenties" => [
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ]
        ],
        'Kern' => [
            "Een nieuw Java-project uitvoeren in Eclipse" => [
                "Ervaren" => [
                    "inhoud" => [
                        "toon afbeelding van windows start knop",
                        "Wie heeft hier wel eens op geklikt?",
                        "Waarom?"
                    ],
                    "werkvorm" => "verhalen vertellen bij foto's",
                    "organisatievorm" => "plenair",
                    "werkvormsoort" => "ijsbreker",
                    "tijd" => "2",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ],
                "Reflecteren" => [
                    "inhoud" => [
                        "Wie kan bedenken wat de beste plek is voor het beginpunt van onze applicatie?",
                        "Link leggen naar het startpunt van de applicatie: main-method"
                    ],
                    "werkvorm" => "brainstormen",
                    "organisatievorm" => "plenair",
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
                    "inhoud" => "tonen hoe een project moet worden aangemaakt en uitgevoerd",
                    "werkvorm" => "demonstratie",
                    "organisatievorm" => "plenair",
                    "werkvormsoort" => "docentgecentreerd",
                    "tijd" => "3",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ],
                "Toepassen" => [
                    "inhoud" => [
                        "SIMPEL: 'Hello World'-project aanmaken en deze uitvoeren (eventueel met buurman/vrouw)",
                        "Help je buurman/vrouw als je dit al weet"
                    ],
                    "werkvorm" => "verwerkingsopdracht",
                    "organisatievorm" => "plenair/groepswerk",
                    "werkvormsoort" => "(individuele) werkopdracht",
                    "tijd" => "10",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ]
            ],
            "Gebruikmaken van een if-statement" => [
                "Ervaren" => [
                    "inhoud" => [
                        "toon afbeelding van red/blue pill (belangrijk onderdeel van 'The Matrix')"
                    ],
                    "werkvorm" => "metafoor",
                    "organisatievorm" => "plenair",
                    "werkvormsoort" => "ijsbreker",
                    "tijd" => "5",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ],
                "Reflecteren" => [
                    "inhoud" => [
                        "Wat is het effect van een keuze?: je neemt een alternatief pad",
                        "Is software rechtlijning? Volgt het altijd maar één route?",
                        "Kun je in code keuzes maken? Op basis waarvan?: condities"
                    ],
                    "werkvorm" => "brainstormen",
                    "organisatievorm" => "groepswerk",
                    "werkvormsoort" => "discussie",
                    "tijd" => "5",
                    "intelligenties" => [
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_LOGISCH_MATHEMATISCH,
                        \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                    ]
                ],
                "Conceptualiseren" => [
                    "inhoud" => [
                        "uitleggen booleans",
                        "uitleggen condities",
                        "uitleg theorie achter if-statements",
                        "benadrukken {} en programmeerstijl"
                    ],
                    "werkvorm" => "presentatie",
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
                        "BASIS: mbv if-statements een bal laten rollen/stuiteren",
                        "COMPLEX: bounceBox() method zelf implementeren (extra uitdaging)"
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
        ],
        'Afsluiting' => [
            "Huiswerk" => [
                "inhoud" => [
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
            ],
            "Evaluatie" => [
                "inhoud" => "Verzamelen feedback papiertjes",
                "werkvorm" => "nabespreking",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "ijsbreker",
                "tijd" => "3",
                "intelligenties" => [
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ],
            "Pakkend slot" => [
                "inhoud" => "Foto; gerelateerd aan de while loop",
                "werkvorm" => "presentatie",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "docentgecentreerd",
                "tijd" => "1",
                "intelligenties" => [
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                    \Teach\Interactors\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
                ]
            ]
        ]
    ];
};