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
        ]);
        
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

    }

//     public function testGenerateHTMLLayoutOnderdelen()
//     {
//         $object = new Fase("Kern");
        
//         $object->addOnderdeel(new Thema("Thema 1: zelf de motor reviseren"));
//         $html = $object->generateHTMLLayout();
//         $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
//         $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
//         $this->assertEquals("Kern", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        
//         $this->assertEquals('section', $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
//         $this->assertEquals("h3", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
//         $this->assertEquals("Thema 1: zelf de motor reviseren", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
//     }
}
