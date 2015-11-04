<?php
namespace Teach\Adapters\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class BeginsituatieTest extends \PHPUnit_Framework_TestCase
{

    public function testGenerateHTMLLayout()
    {
        $object = new Beginsituatie([
            'doelgroep' => [
                'beschrijving' => 'eerstejaars HBO-studenten',
                'ervaring' => 'geen', // <!-- del>veel</del>, <del>redelijk veel</del>, <del>weinig</del>, -->geen
                'grootte' => '16 personen'
            ],
            'starttijd' => '08:45',
            'eindtijd' => '10:20',
            'duur' => '95 minuten',
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
        $html = $object->generateHTMLLayout();
        $this->assertEquals('h3', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("Beginsituatie", $html[0][HTMLFactory::TEXT]);
        
        $this->assertEquals('table', $html[1][HTMLFactory::TAG]);
        $this->assertEquals('two-columns', $html[1][HTMLFactory::ATTRIBUTES]['class']);
    }
}
