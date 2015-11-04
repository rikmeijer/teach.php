<?php
namespace Teach\Adapters\Web;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class LesplanTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHTMLLayout()
    {
        $beginsituatie = new Lesplan\Beginsituatie('HBO-informatica (voltijd)', [
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
        $object = new Lesplan("Programmeren 1", 'Blok 1 / Week 1 / Les 1', $beginsituatie, [
            'filmfragment matrix',
            'countdown timer voor toepassingsfases (optioneel)'
        ], new Lesplan\Fase("Introductie"), [
            "Zelfstandig eclipse installeren" => new Lesplan\Thema("Thema 1: Zelfstandig eclipse installeren"), 
            "Java-code lezen en uitleggen wat er gebeurt" => new Lesplan\Thema("Thema 2: Java-code lezen en uitleggen wat er gebeurt")
        ], new Lesplan\Fase("Afsluiting"));
        
        $html = $object->generateHTMLLayout();
        $this->assertEquals('header', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Lesplan Programmeren 1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);

        $this->assertEquals('section', $html[1][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Blok 1 / Week 1 / Les 1", $html[1][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);

        $this->assertEquals('h3', $html[1][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("Beginsituatie", $html[1][HTMLFactory::CHILDREN][1][HTMLFactory::TEXT]);
        
        $this->assertEquals('h3', $html[1][HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("Benodigde media", $html[1][HTMLFactory::CHILDREN][3][HTMLFactory::TEXT]);
        $this->assertEquals("ul", $html[1][HTMLFactory::CHILDREN][4][HTMLFactory::TAG]);

        $this->assertEquals("li", $html[1][HTMLFactory::CHILDREN][4][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals('filmfragment matrix', $html[1][HTMLFactory::CHILDREN][4][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        $this->assertEquals("li", $html[1][HTMLFactory::CHILDREN][4][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('countdown timer voor toepassingsfases (optioneel)', $html[1][HTMLFactory::CHILDREN][4][HTMLFactory::CHILDREN][1][HTMLFactory::TEXT]);

        $this->assertEquals('h3', $html[1][HTMLFactory::CHILDREN][5][HTMLFactory::TAG]);
        $this->assertEquals("Leerdoelen", $html[1][HTMLFactory::CHILDREN][5][HTMLFactory::TEXT]);
        $this->assertEquals("p", $html[1][HTMLFactory::CHILDREN][6][HTMLFactory::TAG]);
        $this->assertEquals("Na afloop van de les kan de student:", $html[1][HTMLFactory::CHILDREN][6][HTMLFactory::TEXT]);
        
        $this->assertEquals("ol", $html[1][HTMLFactory::CHILDREN][7][HTMLFactory::TAG]);

        $this->assertEquals("li", $html[1][HTMLFactory::CHILDREN][7][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals('Zelfstandig eclipse installeren', $html[1][HTMLFactory::CHILDREN][7][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        $this->assertEquals("li", $html[1][HTMLFactory::CHILDREN][7][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('Java-code lezen en uitleggen wat er gebeurt', $html[1][HTMLFactory::CHILDREN][7][HTMLFactory::CHILDREN][1][HTMLFactory::TEXT]);
        

        $this->assertEquals('section', $html[2][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[2][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Introductie", $html[2][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        
        $this->assertEquals('section', $html[3][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[3][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Kern", $html[3][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        
        $this->assertEquals('section', $html[3][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("h3", $html[3][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Thema 1: Zelfstandig eclipse installeren", $html[3][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        
        $this->assertEquals('section', $html[3][HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
        $this->assertEquals("h3", $html[3][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Thema 2: Java-code lezen en uitleggen wat er gebeurt", $html[3][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);


        $this->assertEquals('section', $html[4][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[4][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Afsluiting", $html[4][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    }

    public function testGenerateHTMLLayoutNoMedia()
    {
        $beginsituatie = new Lesplan\Beginsituatie('HBO-informatica (voltijd)', [
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
        $object = new Lesplan("Programmeren 1", 'Blok 1 / Week 1 / Les 1', $beginsituatie, [], new Lesplan\Fase("Introductie"), [], new Lesplan\Fase("Afsluiting"));
    
        $html = $object->generateHTMLLayout();
        $this->assertEquals('header', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Lesplan Programmeren 1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    
        $this->assertEquals('section', $html[1][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Blok 1 / Week 1 / Les 1", $html[1][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    
        $this->assertEquals('h3', $html[1][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("Beginsituatie", $html[1][HTMLFactory::CHILDREN][1][HTMLFactory::TEXT]);
    
        $this->assertEquals('h3', $html[1][HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("Leerdoelen", $html[1][HTMLFactory::CHILDREN][3][HTMLFactory::TEXT]);
        $this->assertEquals("p", $html[1][HTMLFactory::CHILDREN][4][HTMLFactory::TAG]);
    
    }
}
