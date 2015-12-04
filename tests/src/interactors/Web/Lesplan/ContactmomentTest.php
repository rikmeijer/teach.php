<?php
namespace Teach\Interactors\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class ContactmomentTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHTMLLayout()
    {
        $beginsituatie = new Beginsituatie('HBO-informatica (voltijd)', [
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
        ]);
        $media = [
            'filmfragment matrix',
            'countdown timer voor toepassingsfases (optioneel)'
        ];
        $leerdoelen = [
            "Zelfstandig eclipse installeren",
            "Java-code lezen en uitleggen wat er gebeurt"
        ];
        
        $object = new Contactmoment('Blok 1 / Week 1 / Les 1', $beginsituatie, $media, $leerdoelen);
        
        $html = $object->generateLayout(new HTMLFactory());
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Blok 1 / Week 1 / Les 1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);

        $this->assertEquals('h3', $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("Beginsituatie", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
        
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
        $beginsituatie = new Beginsituatie('HBO-informatica (voltijd)', [
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
        ]);
        $object = new Contactmoment('Blok 1 / Week 1 / Les 1', $beginsituatie, [], []);
    
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