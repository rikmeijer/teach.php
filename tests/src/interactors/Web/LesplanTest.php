<?php
namespace Teach\Interactors\Web;

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
        $media = [
            'filmfragment matrix',
            'countdown timer voor toepassingsfases (optioneel)'
        ];
        $leerdoelen = [
            "Zelfstandig eclipse installeren",
            "Java-code lezen en uitleggen wat er gebeurt"
        ];

        $contactmoment = new Lesplan\Contactmoment('Blok 1 / Week 1 / Les 1', $beginsituatie, $media, $leerdoelen);
        $object = new Lesplan("Programmeren 1", $contactmoment, new Lesplan\Fase("Introductie"), new Lesplan\Fase('Kern'), new Lesplan\Fase("Afsluiting"));
        
        $html = $object->generateLayout(new HTMLFactory());
        $this->assertEquals('header', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Lesplan Programmeren 1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);

        $this->assertEquals('section', $html[1][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Blok 1 / Week 1 / Les 1", $html[1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);

        $this->assertEquals('section', $html[2][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[2][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Introductie", $html[2][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        
        $this->assertEquals('section', $html[3][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[3][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Kern", $html[3][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        
        $this->assertEquals('section', $html[4][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[4][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Afsluiting", $html[4][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
    }
}
