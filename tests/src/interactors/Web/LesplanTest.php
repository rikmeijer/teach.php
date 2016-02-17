<?php
namespace Teach\Interactors\Web;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class LesplanTest extends \PHPUnit_Framework_TestCase
{
    public function testProvideTemplateVariables()
    {
        $media = [
            'filmfragment matrix',
            'countdown timer voor toepassingsfases (optioneel)'
        ];
        $leerdoelen = [
            "Zelfstandig eclipse installeren",
            "Java-code lezen en uitleggen wat er gebeurt"
        ];
        $contactmoment = new Lesplan\Contactmoment([
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
        ], $media, $leerdoelen);
        $object = new Lesplan("HBO-informatica (voltijd)", "Programmeren 1", 'Blok 1 / Week 1 / Les 1', $contactmoment, new Lesplan\Fase("Introductie"), new Lesplan\Fase('Kern'), new Lesplan\Fase("Afsluiting"));
        
        
        $variables = $object->provideTemplateVariables([
            "title",
            "subtitle",        
            "contactmomentTitle",
            "contactmoment"
        ]);
        
        $this->assertEquals("Lesplan Programmeren 1", $variables["title"]);
        $this->assertEquals("HBO-informatica (voltijd)", $variables["subtitle"]);
        $this->assertEquals("Blok 1 / Week 1 / Les 1", $variables["contactmomentTitle"]);
        $this->assertEquals($contactmoment, $variables["contactmoment"]);
    }
    
    
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

        $contactmoment = new Lesplan\Contactmoment([
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
        ], $media, $leerdoelen);
        $object = new Lesplan("HBO-informatica (voltijd)", "Programmeren 1", 'Blok 1 / Week 1 / Les 1', $contactmoment, new Lesplan\Fase("Introductie"), new Lesplan\Fase('Kern'), new Lesplan\Fase("Afsluiting"));
        
        $html = $object->generateLayout(new HTMLFactory());
        $this->assertEquals('header', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Lesplan Programmeren 1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("HBO-informatica (voltijd)", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);

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
