<?php
namespace Teach\Adapters\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class BeginsituatieTest extends \PHPUnit_Framework_TestCase
{

    public function testGenerateHTMLLayout()
    {
        $object = new Beginsituatie('HBO-informatica (voltijd)', [
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
        ]);
        $html = $object->generateLayout (new HTMLFactory());
        $this->assertEquals('h3', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("Beginsituatie", $html[0][HTMLFactory::CHILDREN][0]);
        
        $this->assertEquals('table', $html[1][HTMLFactory::TAG]);
        
        $row = $html[1][HTMLFactory::CHILDREN][0];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("doelgroep", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("eerstejaars HBO-studenten", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
        $this->assertEquals("opleiding", $row[HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("HBO-informatica (voltijd)", $row[HTMLFactory::CHILDREN][3][HTMLFactory::CHILDREN][0]);

        $row = $html[1][HTMLFactory::CHILDREN][1];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("ervaring", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("geen", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
        $this->assertEquals("groepsgrootte", $row[HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("16 personen", $row[HTMLFactory::CHILDREN][3][HTMLFactory::CHILDREN][0]);
        
        $row = $html[1][HTMLFactory::CHILDREN][2];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("tijd", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals('van 08:45 tot 10:20 (95 minuten)', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);

        $row = $html[1][HTMLFactory::CHILDREN][3];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("ruimte", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals('beschikking over vaste computers', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
        
        $row = $html[1][HTMLFactory::CHILDREN][4];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("overige", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals('nvt', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    }
}
