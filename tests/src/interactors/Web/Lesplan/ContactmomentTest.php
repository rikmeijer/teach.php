<?php
namespace Teach\Interactors\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class ContactmomentTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHTMLLayout()
    {
        $media = [
            'filmfragment matrix',
            'countdown timer voor toepassingsfases (optioneel)'
        ];
        $leerdoelen = [
            "Zelfstandig eclipse installeren",
            "Java-code lezen en uitleggen wat er gebeurt"
        ];
        
        $object = new Contactmoment('Blok 1 / Week 1 / Les 1', [
            'doelgroep' => [
                'beschrijving' => 'eerstejaars HBO-studenten',
                'ervaring' => 'geen', // <!-- del>veel</del>, <del>redelijk veel</del>, <del>weinig</del>, -->geen
                'grootte' => '16 personen'
            ],
            'starttijd' => '08:45',
            'eindtijd' => '10:20',
            'duur' => '95',
            'ruimte' => 'beschikking over vaste computers',
            'overige' => 'nvt',
            'media' => [
                'filmfragment matrix',
                'countdown timer voor toepassingsfases (optioneel)',
                'voorbeeld IKEA-handleiding + uitgewerkte pseudo-code',
                'rode en groene briefjes/post-its voor feedback',
                'presentatie',
                'voorbeeldproject voor aanvullende feedback'
            ]
            ], $media, $leerdoelen);
        
        $html = $object->generateLayout(new HTMLFactory());
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Blok 1 / Week 1 / Les 1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);

        $this->assertEquals('h3', $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("Beginsituatie", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    
        $this->assertEquals('table', $html[0][HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
    
        $row = $html[0][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("doelgroep", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("eerstejaars HBO-studenten", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
        $this->assertEquals("ervaring", $row[HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("geen", $row[HTMLFactory::CHILDREN][3][HTMLFactory::CHILDREN][0]);
    
        $row = $html[0][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][1];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("groepsgrootte", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("16 personen", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    
        $row = $html[0][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][2];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("tijd", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals('van 08:45 tot 10:20 (95 minuten)', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    
        $row = $html[0][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][3];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("ruimte", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals('beschikking over vaste computers', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    
        $row = $html[0][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][4];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("overige", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals('nvt', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
        
        $this->assertEquals('h3', $html[0][HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("Benodigde media", $html[0][HTMLFactory::CHILDREN][3][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("ul", $html[0][HTMLFactory::CHILDREN][4][HTMLFactory::TAG]);

        $this->assertEquals("li", $html[0][HTMLFactory::CHILDREN][4][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals('filmfragment matrix', $html[0][HTMLFactory::CHILDREN][4][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("li", $html[0][HTMLFactory::CHILDREN][4][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('countdown timer voor toepassingsfases (optioneel)', $html[0][HTMLFactory::CHILDREN][4][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);

        $this->assertEquals('h3', $html[0][HTMLFactory::CHILDREN][5][HTMLFactory::TAG]);
        $this->assertEquals("Leerdoelen", $html[0][HTMLFactory::CHILDREN][5][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("p", $html[0][HTMLFactory::CHILDREN][6][HTMLFactory::TAG]);
        $this->assertEquals("Na afloop van de les kan de student:", $html[0][HTMLFactory::CHILDREN][6][HTMLFactory::CHILDREN][0]);
        
        $this->assertEquals("ol", $html[0][HTMLFactory::CHILDREN][7][HTMLFactory::TAG]);
        
        $this->assertEquals("li", $html[0][HTMLFactory::CHILDREN][7][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals('Zelfstandig eclipse installeren', $html[0][HTMLFactory::CHILDREN][7][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("li", $html[0][HTMLFactory::CHILDREN][7][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('Java-code lezen en uitleggen wat er gebeurt', $html[0][HTMLFactory::CHILDREN][7][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    }

    public function testGenerateHTMLLayoutNoMedia()
    {
        $object = new Contactmoment('Blok 1 / Week 1 / Les 1', [
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
        ], [], []);
    
        $html = $object->generateLayout (new HTMLFactory());
    
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Blok 1 / Week 1 / Les 1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
    
        $this->assertEquals('h3', $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("Beginsituatie", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    
        $this->assertEquals('h3', $html[0][HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("Leerdoelen", $html[0][HTMLFactory::CHILDREN][3][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("p", $html[0][HTMLFactory::CHILDREN][4][HTMLFactory::TAG]);
    
    }
}
