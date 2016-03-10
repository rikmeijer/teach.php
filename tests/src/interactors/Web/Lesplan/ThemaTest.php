<?php
namespace Teach\Interactions\Web\Lesplan;

class ThemaTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $object = new Thema("Thema 1: zelf de motor reviseren");
        $object->addActiviteit($activiteit = new Activiteit("Reflecteren", $werkvorm = array(
            "inhoud" => "• Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.
    • Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?",
            "werkvorm" => "brainstormen",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "discussie",
            "tijd" => "5",
            "intelligenties" => array(
                Activiteit::MI_VERBAAL_LINGUISTISCH,
                Activiteit::MI_INTRAPERSOONLIJK,
                Activiteit::MI_INTERPERSOONLIJK
            )
        )));
        
        $html = $object->document(\Test\Helper::implementDocumenter());
        $this->assertEquals('section3:Thema 1: zelf de motor reviseren...Reflecteren: a:4:{i:0;a:2:{s:8:"werkvorm";s:12:"brainstormen";s:15:"organisatievorm";s:7:"plenair";}i:1;a:2:{s:4:"tijd";s:9:"5 minuten";s:14:"soort werkvorm";s:9:"discussie";}i:2;a:1:{s:14:"intelligenties";a:3:{i:0;s:2:"VL";i:1;s:2:"IR";i:2;s:2:"IA";}}i:3;a:1:{s:6:"inhoud";s:152:"• Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.
    • Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?";}}', $html);
    }
}
