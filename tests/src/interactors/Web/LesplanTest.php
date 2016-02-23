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
        $object = new Lesplan("HBO-informatica (voltijd)", "Programmeren 1", 'Blok 1 / Week 1 / Les 1', $contactmoment, $introductie = new Lesplan\Fase("Introductie"), $kern = new Lesplan\Fase('Kern'), $afsluiting = new Lesplan\Fase("Afsluiting"));
        
        $variables = $object->provideTemplateVariables([
            "title",
            "subtitle",        
            "contactmomentTitle",
            "contactmoment",
            "introductie",
            "kern",
            "afsluiting",
        ]);
        
        $this->assertEquals("Lesplan Programmeren 1", $variables["title"]);
        $this->assertEquals("HBO-informatica (voltijd)", $variables["subtitle"]);
        $this->assertEquals("Blok 1 / Week 1 / Les 1", $variables["contactmomentTitle"]);
        $this->assertEquals($contactmoment, $variables["contactmoment"]);
        $this->assertEquals($introductie, $variables["introductie"]);
        $this->assertEquals($kern, $variables["kern"]);
        $this->assertEquals($afsluiting, $variables["afsluiting"]);
    }
}
