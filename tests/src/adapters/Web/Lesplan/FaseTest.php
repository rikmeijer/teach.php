<?php
namespace Teach\Adapters\Web\Lesplan;

class FaseTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateFirstStep()
    {
        $object = new Fase("Reflecteren", array(
                "inhoud" => "•	Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.
•	Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?",
                "werkvorm" => "brainstormen",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "discussie",
                "tijd" => "5",
//                 "intelligenties" => array(
//                     MI_VERBAAL_LINGUISTISCH,
//                     MI_INTRAPERSOONLIJK,
//                     MI_INTERPERSOONLIJK
//                 )
            ));
        $html = $object->generateFirstStep();
        $this->assertEquals('table', $html[0][0]);
        $this->assertEquals('two-columns', $html[0][1]['class']);
        $this->assertEquals("caption", $html[0][2][0][0]);
        $this->assertEquals("Reflecteren", $html[0][2][0][1]);

        $this->assertEquals("tr", $html[0][2][1][0]);
        $this->assertEquals("th", $html[0][2][1][2][0][0]);
        $this->assertEquals("werkvorm", $html[0][2][1][2][0][1]);
        $this->assertEquals("td", $html[0][2][1][2][1][0]);
        $this->assertEquals("brainstormen", $html[0][2][1][2][1][1]);
    }
}
