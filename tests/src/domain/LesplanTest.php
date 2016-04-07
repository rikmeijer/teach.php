<?php
namespace Teach\Domain;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-10-14 at 13:44:20.
 */
class LesplanTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $factory = new Factory(new class implements \Teach\Interactions\Database {
            public function getBeginsituatie($identifier): array
           {
                return [
                    "opleiding" => 'HBO-informatica (voltijd)',
                    "lesplan_id" => "1",
                    "les" => "Week1a",
                    "vak" => "PROG1",
                    "doelgroep_grootte" => "16",
                    "doelgroep_ervaring" => "geen",
                    "doelgroep_beschrijving" => "eerstejaars HBO-studenten",
                    "starttijd" => "8:45",
                    "eindtijd" => "10:20",
                    "duur" => "95",
                    "beschikbaar" => "onbekend",
                    "ruimte" => "beschikking over vaste computers",
                    "opmerkingen" => "nvt",
                    "activerende_opening_id" => "opening",
                    "focus_id" => "focus",
                    "voorstellen_id" => "voorstellen",
                    "kennismaken_id" => null,
                    "terugblik_id" => null,
                    "huiswerk_id" => "huiswerk",
                    "evaluatie_id" => "evaluatie",
                    "pakkend_slot_id" => "slot"
                ];
            }
            
            public function getLeerdoelen($les_id): array
           {
                return [    
                    'Zelfstandig eclipse installeren',
                    'Java-code lezen en uitleggen wat er gebeurt'
                ];
            }
            
            public function getMedia($les_id): array
           {
                return [    
                    'filmfragment matrix',
                    'countdown timer voor toepassingsfases (optioneel)',
                    'voorbeeld IKEA-handleiding + uitgewerkte pseudo-code',
                    'rode en groene briefjes/post-its voor feedback',
                    'voorbeeldproject voor aanvullende feedback'
                ];
            }
            
            public function getActiviteit($id): array
           {
               switch ($id) {
                   case "opening":
                       return [
                           "inhoud" => [
                                'Scen� uit de matrix tonen waarop wordt gezegd: "I don\'t',
                    'even see the code". Wie kent deze film? Een ervaren programmeur',
                    'zal een vergelijkbaar gevoel hebben bij code: programmeren is een',
                    'visualisatie kunnen uitdrukken in code en vice versa.'
                           ],
                           "werkvorm" => "film",
                           "organisatievorm" => "plenair",
                           "werkvormsoort" => "ijsbreker",
                           "tijd" => "5",
                           "intelligenties" => ['VL','VR','IR','IA']
                       ];
                   case "focus":
                       return [
                           "inhoud" => [
                                'Visie, Leerdoelen, Programma, Afspraken'
                           ],
                           "werkvorm" => "presentatie",
                           "organisatievorm" => "plenair",
                           "werkvormsoort" => "docent gecentreerd",
                           "tijd" => "3",
                           "intelligenties" => ['VL','LM','IR']
                       ];
                   case "voorstellen":
                       return [
                           "inhoud" => [
                                'Voorstellen Docent'
                           ],
                           "werkvorm" => "presentatie",
                           "organisatievorm" => "plenair",
                           "werkvormsoort" => "docent gecentreerd",
                           "tijd" => "1",
                           "intelligenties" => ['VL','LM','IR']
                       ];
                       
                   case "t1_ervaren":
                       return [
                       "inhoud" => [
                            'Tonen afbeeldingen van werkomgevingen: wie herkent de',
                            'werkomgeving?'
                           ],
                           "werkvorm" => "verhalen vertellen bij foto's",
                           "organisatievorm" => "plenair",
                           "werkvormsoort" => "ijsbreker",
                           "tijd" => "5",
                           "intelligenties" => ['VL', 'VR', 'N','IR']
                           ];
                   case "t1_reflecteren":
                       return [
                       "inhoud" => [
                            '5 minuten brainstormen om te reflecteren op de voorgaande',
                            'afbeeldingen.',
                            'De uiteindelijke vraag om te beantwoorden: \'Hoe zou een werkplaats',
                            'voor een programmeur eruit zien?\'',
                            'Wat valt er op aan deze werkplaatsen?',
                            'Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.',
                            'Wie kan bedenken wat voor gereedschap erbij programmeren komt',
                            'kijken?'
                           ],
                           "werkvorm" => "brainstormen",
                           "organisatievorm" => "plenair",
                           "werkvormsoort" => "discussie",
                           "tijd" => "5",
                           "intelligenties" => ['VL', 'IR', 'IA']
                           ];
                   case "t1_conceptualiseren":
                       return [
                       "inhoud" => [
                            'Kort uitleggen wat IDE/eclipse is',
                            '(programmeeromgeving)/waarvoor het wordt gebruikt.',
                            'Korte demo ter kennismaking',
                            'Wat zijn de randvoorwaarden van de installatie?',
                            '!! Laatste sheet met randvoorwaarden open laten'
                           ],
                           "werkvorm" => "presentatie",
                           "organisatievorm" => "plenair",
                           "werkvormsoort" => "docent gecentreerd",
                           "tijd" => "5",
                           "intelligenties" => ['VL', 'VR', 'IR']
                           ];
                   case "t1_toepassen":
                       return [
                       "inhoud" => [
                            'Student installeert zelf eclipse',
                            'Aanvullende opdracht (capaciteit): importeren voorbeeldproject van blackboard',
                            'of een nieuw project aanmaken',
                            'Na 10min controleren of dit bij iedereen is gelukt'
                           ],
                           "werkvorm" => "verwerkingsopdracht",
                           "organisatievorm" => "plenair",
                           "werkvormsoort" => "individuele werkopdracht",
                           "tijd" => "15",
                           "intelligenties" => ['VL', 'IA']
                           ];


                       case "t2_ervaren":
                           return [
                           "inhoud" => [
                           'Achterhalen wie wel eens adhv van een recept/handleiding heeft',
                           'gewerkt.'
                               ],
                               "werkvorm" => "metafoor",
                               "organisatievorm" => "plenair",
                               "werkvormsoort" => "ijsbreker",
                               "tijd" => "5",
                               "intelligenties" => ['VL', 'IR']
                               ];
                       case "t2_reflecteren":
                           return [
                           "inhoud" => [
                           'Studenten met buurman/vrouw overleggen hoeveel verschillende',
                           'stappen er zijn bij het uitvoeren van een handleiding. Tijdens het',
                           'uitvoeren van taken voeren wij onbewust veel contextgevoelige taken',
                           'uit een computer kent dit niet.'
                               ],
                               "werkvorm" => "brainstormen",
                               "organisatievorm" => "groepswerk",
                               "werkvormsoort" => "discussie",
                               "tijd" => "5",
                               "intelligenties" => ['VL', 'LM', 'IR', 'IA']
                               ];
                       case "t2_conceptualiseren":
                           return [
                           "inhoud" => [
                           'Tonen pseudo-code bij vorig recept of handleiding (bijv. IKEA','handleiding)'
                               ],
                               "werkvorm" => "demonstratie",
                               "organisatievorm" => "plenair",
                               "werkvormsoort" => "docent gecentreerd",
                               "tijd" => "10",
                               "intelligenties" => ['VL', 'VR', 'IR']
                               ];
                       case "t2_toepassen":
                           return [
                           "inhoud" => [
                           'SIMPEL: uitleggen wat de code doet',
                                'BASIS: schrijven pseudo-code',
                                'COMPLEX: zelf code schrijven, als voorschot op volgende week (extra',
                                'uitdaging).'
                               ],
                               "werkvorm" => "verwerkingsopdracht",
                               "organisatievorm" => "plenair",
                               "werkvormsoort" => "individuele werkopdracht",
                               "tijd" => "30",
                               "intelligenties" => ['VL', 'IA']
                               ];
                   case "huiswerk":
                       return [
                           "inhoud" => [
                                'Challenge voor eerstvolgende les maken',
                                'Practicum opdrachten thuis afronden',
                                'Huiswerk maken als extra oefening'
                           ],
                           "werkvorm" => "presentatie",
                           "organisatievorm" => "plenair",
                           "werkvormsoort" => "docent gecentreerd",
                           "tijd" => "2",
                           "intelligenties" => ['VL','IR']
                       ];
                   case "evaluatie":
                       return [
                           "inhoud" => [
                                'Verzamelen feedback papiertjes'
                           ],
                           "werkvorm" => "nabespreking",
                           "organisatievorm" => "plenair",
                           "werkvormsoort" => "docent gecentreerd",
                           "tijd" => "3",
                           "intelligenties" => ['VL','IR']
                       ];
                   case "slot":
                       return [
                           "inhoud" => [
                                'Foto; gerelateerd aan keuzes/condities. Misschien foto van',
                                'blauwe/rode pil Matrix.'
                           ],
                           "werkvorm" => "presentatie",
                           "organisatievorm" => "plenair",
                           "werkvormsoort" => "docent gecentreerd",
                           "tijd" => "1",
                           "intelligenties" => ['VL', 'VR','IR']
                       ];
                   
                   default:
                       return [
                           "inhoud" => "",
                           "werkvorm" => "onbekend",
                           "organisatievorm" => "nvt",
                           "werkvormsoort" => "onbekend",
                           "tijd" => "0",
                           "intelligenties" => []
                       ];
               }
               
            }
            
            public function getKern($les_id): array
           {
                return [
                    'Zelfstandig eclipse installeren' => [
                        "ervaren_id" => 't1_ervaren',
                        "reflecteren_id" => 't1_reflecteren',
                        "conceptualiseren_id" => 't1_conceptualiseren',
                        "toepassen_id" => 't1_toepassen'
                    ],
                    'Java-code lezen en uitleggen wat er gebeurt' => [
                        "ervaren_id" => 't2_ervaren',
                        "reflecteren_id" => 't2_reflecteren',
                        "conceptualiseren_id" => 't2_conceptualiseren',
                        "toepassen_id" => 't2_toepassen'
                    ]
                ];
            }
        });
        
        $object = $factory->createLesplan('1');
        $html = $object->document(\Test\Helper::implementDocumenter());
        
        $expected = '<html><head><title>Lesplan PROG1</title></head><body>fpLesplan PROG1:HBO-informatica (voltijd)section2:Week1a...3:Beginsituatie...: a:5:{i:0;a:2:{s:9:"doelgroep";s:25:"eerstejaars HBO-studenten";s:8:"ervaring";s:4:"geen";}i:1;a:1:{s:13:"groepsgrootte";s:11:"16 personen";}i:2;a:1:{s:4:"tijd";s:32:"van 08:45 tot 10:20 (95 minuten)";}i:3;a:1:{s:6:"ruimte";s:32:"beschikking over vaste computers";}i:4;a:1:{s:7:"overige";s:3:"nvt";}}...3:Media...ul: a:5:{i:0;s:19:"filmfragment matrix";i:1;s:49:"countdown timer voor toepassingsfases (optioneel)";i:2;s:52:"voorbeeld IKEA-handleiding + uitgewerkte pseudo-code";i:3;s:46:"rode en groene briefjes/post-its voor feedback";i:4;s:42:"voorbeeldproject voor aanvullende feedback";}...3:Leerdoelen...<p>Na afloop van de les kan de student:</p>...ul: a:2:{i:0;s:31:"Zelfstandig eclipse installeren";i:1;s:43:"Java-code lezen en uitleggen wat er gebeurt";}section2:Introductie...Activerende opening: a:4:{i:0;a:2:{s:8:"werkvorm";s:4:"film";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"5 minuten";s:14:"soort werkvorm";s:9:"ijsbreker";}i:2;a:1:{s:14:"intelligenties";a:4:{i:0;s:2:"VL";i:1;s:2:"VR";i:2;s:2:"IR";i:3;s:2:"IA";}}i:3;a:1:{s:6:"inhoud";a:4:{i:0;s:55:"Scen� uit de matrix tonen waarop wordt gezegd: "I don\'t";i:1;s:63:"even see the code". Wie kent deze film? Een ervaren programmeur";i:2;s:65:"zal een vergelijkbaar gevoel hebben bij code: programmeren is een";i:3;s:53:"visualisatie kunnen uitdrukken in code en vice versa.";}}}...Focus: a:4:{i:0;a:2:{s:8:"werkvorm";s:11:"presentatie";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"3 minuten";s:14:"soort werkvorm";s:18:"docent gecentreerd";}i:2;a:1:{s:14:"intelligenties";a:3:{i:0;s:2:"VL";i:1;s:2:"LM";i:2;s:2:"IR";}}i:3;a:1:{s:6:"inhoud";a:1:{i:0;s:39:"Visie, Leerdoelen, Programma, Afspraken";}}}...Voorstellen: a:4:{i:0;a:2:{s:8:"werkvorm";s:11:"presentatie";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"1 minuten";s:14:"soort werkvorm";s:18:"docent gecentreerd";}i:2;a:1:{s:14:"intelligenties";a:3:{i:0;s:2:"VL";i:1;s:2:"LM";i:2;s:2:"IR";}}i:3;a:1:{s:6:"inhoud";a:1:{i:0;s:18:"Voorstellen Docent";}}}...Kennismaken: a:4:{i:0;a:2:{s:8:"werkvorm";s:8:"onbekend";s:15:"organisatievorm";s:3:"nvt";}i:1;a:2:{s:4:"tijd";s:9:"0 minuten";s:14:"soort werkvorm";s:8:"onbekend";}i:2;a:1:{s:14:"intelligenties";a:0:{}}i:3;a:1:{s:6:"inhoud";s:0:"";}}...Terugblik: a:4:{i:0;a:2:{s:8:"werkvorm";s:8:"onbekend";s:15:"organisatievorm";s:3:"nvt";}i:1;a:2:{s:4:"tijd";s:9:"0 minuten";s:14:"soort werkvorm";s:8:"onbekend";}i:2;a:1:{s:14:"intelligenties";a:0:{}}i:3;a:1:{s:6:"inhoud";s:0:"";}}section2:Kern...section3:Thema 1: Zelfstandig eclipse installeren...Ervaren: a:4:{i:0;a:2:{s:8:"werkvorm";s:29:"verhalen vertellen bij foto\'s";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"5 minuten";s:14:"soort werkvorm";s:9:"ijsbreker";}i:2;a:1:{s:14:"intelligenties";a:4:{i:0;s:2:"VL";i:1;s:2:"VR";i:2;s:1:"N";i:3;s:2:"IR";}}i:3;a:1:{s:6:"inhoud";a:2:{i:0;s:53:"Tonen afbeeldingen van werkomgevingen: wie herkent de";i:1;s:13:"werkomgeving?";}}}...Reflecteren: a:4:{i:0;a:2:{s:8:"werkvorm";s:12:"brainstormen";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"5 minuten";s:14:"soort werkvorm";s:9:"discussie";}i:2;a:1:{s:14:"intelligenties";a:3:{i:0;s:2:"VL";i:1;s:2:"IR";i:2;s:2:"IA";}}i:3;a:1:{s:6:"inhoud";a:8:{i:0;s:57:"5 minuten brainstormen om te reflecteren op de voorgaande";i:1;s:13:"afbeeldingen.";i:2;s:66:"De uiteindelijke vraag om te beantwoorden: \'Hoe zou een werkplaats";i:3;s:33:"voor een programmeur eruit zien?\'";i:4;s:37:"Wat valt er op aan deze werkplaatsen?";i:5;s:69:"Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.";i:6;s:61:"Wie kan bedenken wat voor gereedschap erbij programmeren komt";i:7;s:7:"kijken?";}}}...Conceptualiseren: a:4:{i:0;a:2:{s:8:"werkvorm";s:11:"presentatie";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"5 minuten";s:14:"soort werkvorm";s:18:"docent gecentreerd";}i:2;a:1:{s:14:"intelligenties";a:3:{i:0;s:2:"VL";i:1;s:2:"VR";i:2;s:2:"IR";}}i:3;a:1:{s:6:"inhoud";a:5:{i:0;s:33:"Kort uitleggen wat IDE/eclipse is";i:1;s:50:"(programmeeromgeving)/waarvoor het wordt gebruikt.";i:2;s:27:"Korte demo ter kennismaking";i:3;s:47:"Wat zijn de randvoorwaarden van de installatie?";i:4;s:47:"!! Laatste sheet met randvoorwaarden open laten";}}}...Toepassen: a:4:{i:0;a:2:{s:8:"werkvorm";s:19:"verwerkingsopdracht";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:10:"15 minuten";s:14:"soort werkvorm";s:24:"individuele werkopdracht";}i:2;a:1:{s:14:"intelligenties";a:2:{i:0;s:2:"VL";i:1;s:2:"IA";}}i:3;a:1:{s:6:"inhoud";a:4:{i:0;s:32:"Student installeert zelf eclipse";i:1;s:77:"Aanvullende opdracht (capaciteit): importeren voorbeeldproject van blackboard";i:2;s:29:"of een nieuw project aanmaken";i:3;s:50:"Na 10min controleren of dit bij iedereen is gelukt";}}}...section3:Thema 2: Java-code lezen en uitleggen wat er gebeurt...Ervaren: a:4:{i:0;a:2:{s:8:"werkvorm";s:8:"metafoor";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"5 minuten";s:14:"soort werkvorm";s:9:"ijsbreker";}i:2;a:1:{s:14:"intelligenties";a:2:{i:0;s:2:"VL";i:1;s:2:"IR";}}i:3;a:1:{s:6:"inhoud";a:2:{i:0;s:62:"Achterhalen wie wel eens adhv van een recept/handleiding heeft";i:1;s:8:"gewerkt.";}}}...Reflecteren: a:4:{i:0;a:2:{s:8:"werkvorm";s:12:"brainstormen";s:15:"organisatievorm";s:10:"groepswerk";}i:1;a:2:{s:4:"tijd";s:9:"5 minuten";s:14:"soort werkvorm";s:9:"discussie";}i:2;a:1:{s:14:"intelligenties";a:4:{i:0;s:2:"VL";i:1;s:2:"LM";i:2;s:2:"IR";i:3;s:2:"IA";}}i:3;a:1:{s:6:"inhoud";a:4:{i:0;s:60:"Studenten met buurman/vrouw overleggen hoeveel verschillende";i:1;s:66:"stappen er zijn bij het uitvoeren van een handleiding. Tijdens het";i:2;s:67:"uitvoeren van taken voeren wij onbewust veel contextgevoelige taken";i:3;s:31:"uit een computer kent dit niet.";}}}...Conceptualiseren: a:4:{i:0;a:2:{s:8:"werkvorm";s:12:"demonstratie";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:10:"10 minuten";s:14:"soort werkvorm";s:18:"docent gecentreerd";}i:2;a:1:{s:14:"intelligenties";a:3:{i:0;s:2:"VL";i:1;s:2:"VR";i:2;s:2:"IR";}}i:3;a:1:{s:6:"inhoud";a:2:{i:0;s:61:"Tonen pseudo-code bij vorig recept of handleiding (bijv. IKEA";i:1;s:12:"handleiding)";}}}...Toepassen: a:4:{i:0;a:2:{s:8:"werkvorm";s:19:"verwerkingsopdracht";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:10:"30 minuten";s:14:"soort werkvorm";s:24:"individuele werkopdracht";}i:2;a:1:{s:14:"intelligenties";a:2:{i:0;s:2:"VL";i:1;s:2:"IA";}}i:3;a:1:{s:6:"inhoud";a:4:{i:0;s:34:"SIMPEL: uitleggen wat de code doet";i:1;s:28:"BASIS: schrijven pseudo-code";i:2;s:67:"COMPLEX: zelf code schrijven, als voorschot op volgende week (extra";i:3;s:11:"uitdaging).";}}}section2:Afsluiting...Huiswerk: a:4:{i:0;a:2:{s:8:"werkvorm";s:11:"presentatie";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"2 minuten";s:14:"soort werkvorm";s:18:"docent gecentreerd";}i:2;a:1:{s:14:"intelligenties";a:2:{i:0;s:2:"VL";i:1;s:2:"IR";}}i:3;a:1:{s:6:"inhoud";a:3:{i:0;s:38:"Challenge voor eerstvolgende les maken";i:1;s:35:"Practicum opdrachten thuis afronden";i:2;s:33:"Huiswerk maken als extra oefening";}}}...Evaluatie: a:4:{i:0;a:2:{s:8:"werkvorm";s:12:"nabespreking";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"3 minuten";s:14:"soort werkvorm";s:18:"docent gecentreerd";}i:2;a:1:{s:14:"intelligenties";a:2:{i:0;s:2:"VL";i:1;s:2:"IR";}}i:3;a:1:{s:6:"inhoud";a:1:{i:0;s:30:"Verzamelen feedback papiertjes";}}}...Pakkend slot: a:4:{i:0;a:2:{s:8:"werkvorm";s:11:"presentatie";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"1 minuten";s:14:"soort werkvorm";s:18:"docent gecentreerd";}i:2;a:1:{s:14:"intelligenties";a:3:{i:0;s:2:"VL";i:1;s:2:"VR";i:2;s:2:"IR";}}i:3;a:1:{s:6:"inhoud";a:2:{i:0;s:58:"Foto; gerelateerd aan keuzes/condities. Misschien foto van";i:1;s:23:"blauwe/rode pil Matrix.";}}}</body></html>';
        
        $this->assertEquals($expected, $html);
    }
}
