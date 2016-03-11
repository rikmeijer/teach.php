<?php
namespace Teach\Interactions\Web;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $media = [
            'filmfragment matrix',
            'countdown timer voor toepassingsfases (optioneel)'
        ];
        $leerdoelen = [
            "Zelfstandig eclipse installeren",
            "Java-code lezen en uitleggen wat er gebeurt"
        ];
        $contactmoment = new Lesplan\Beginsituatie('Blok 1 / Week 1 / Les 1', [
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
        $object = new Document("HBO-informatica (voltijd)", "Programmeren 1", $contactmoment, $introductie = new Lesplan\Fase('2', "Introductie"), $kern = new Lesplan\Fase('2', 'Kern'), $afsluiting = new Lesplan\Fase('2', "Afsluiting"));
        
        $html = $object->document(\Test\Helper::implementDocumenter());
        $this->assertEquals('fpLesplan Programmeren 1:HBO-informatica (voltijd)section2:Blok 1 / Week 1 / Les 1...3:Beginsituatie...: a:5:{i:0;a:2:{s:9:"doelgroep";s:25:"eerstejaars HBO-studenten";s:8:"ervaring";s:4:"geen";}i:1;a:1:{s:13:"groepsgrootte";s:11:"16 personen";}i:2;a:1:{s:4:"tijd";s:32:"van 08:45 tot 10:20 (95 minuten)";}i:3;a:1:{s:6:"ruimte";s:32:"beschikking over vaste computers";}i:4;a:1:{s:7:"overige";s:3:"nvt";}}...3:Media...ul: a:2:{i:0;s:19:"filmfragment matrix";i:1;s:49:"countdown timer voor toepassingsfases (optioneel)";}...3:Leerdoelen...<p>Na afloop van de les kan de student:</p>...ul: a:2:{i:0;s:31:"Zelfstandig eclipse installeren";i:1;s:43:"Java-code lezen en uitleggen wat er gebeurt";}section2:Introductiesection2:Kernsection2:Afsluiting', $html);
    }
}
