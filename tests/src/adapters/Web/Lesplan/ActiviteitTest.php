<?php
namespace Teach\Adapters\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class ActiviteitTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateFirstStep()
    {
        $object = new Activiteit("Reflecteren", $werkvorm = array(
                "inhoud" => "•	Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.
•	Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?",
                "werkvorm" => "brainstormen",
                "organisatievorm" => "plenair",
                "werkvormsoort" => "discussie",
                "tijd" => "5",
                "intelligenties" => array(
                    Activiteit::MI_VERBAAL_LINGUISTISCH,
                    Activiteit::MI_INTRAPERSOONLIJK,
                    Activiteit::MI_INTERPERSOONLIJK
                )
            ));
        $html = $object->generateHTMLLayout();
        $this->assertEquals('table', $html[0][HTMLFactory::TAG]);
        $this->assertEquals('two-columns', $html[0][HTMLFactory::ATTRIBUTES]['class']);
        $this->assertEquals("caption", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Reflecteren", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);

        $row = $html[0][HTMLFactory::CHILDREN][1];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("werkvorm", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("brainstormen", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TEXT]);
        
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
        $this->assertEquals("organisatievorm", $row[HTMLFactory::CHILDREN][2][HTMLFactory::TEXT]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("plenair", $row[HTMLFactory::CHILDREN][3][HTMLFactory::TEXT]);

        $row = $html[0][HTMLFactory::CHILDREN][2];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("tijd", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("5 minuten", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TEXT]);
        
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
        $this->assertEquals("soort werkvorm", $row[HTMLFactory::CHILDREN][2][HTMLFactory::TEXT]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("discussie", $row[HTMLFactory::CHILDREN][3][HTMLFactory::TEXT]);
        

        $row = $html[0][HTMLFactory::CHILDREN][3];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("intelligenties", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals("ul", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("meervoudige-intelligenties", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::ATTRIBUTES]['class']);

        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals(Activiteit::MI_VERBAAL_LINGUISTISCH, $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0][HTMLFactory::ATTRIBUTES]['id']);
        $this->assertEquals('selected', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0][HTMLFactory::ATTRIBUTES]['class']);
        $this->assertEquals('VL', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);

        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals(Activiteit::MI_LOGISCH_MATHEMATISCH, $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['id']);
        $this->assertEquals('LM', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);

        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
        $this->assertEquals(Activiteit::MI_VISUEEL_RUIMTELIJK, $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][2][HTMLFactory::ATTRIBUTES]['id']);
        $this->assertEquals('VR', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0]);

        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals(Activiteit::MI_MUZIKAAL_RITMISCH, $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][3][HTMLFactory::ATTRIBUTES]['id']);
        $this->assertEquals('MR', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][3][HTMLFactory::CHILDREN][0]);

        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][4][HTMLFactory::TAG]);
        $this->assertEquals(Activiteit::MI_LICHAMELIJK_KINESTHETISCH, $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][4][HTMLFactory::ATTRIBUTES]['id']);
        $this->assertEquals('LK', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][4][HTMLFactory::CHILDREN][0]);

        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][5][HTMLFactory::TAG]);
        $this->assertEquals(Activiteit::MI_NATURALISTISCH, $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][5][HTMLFactory::ATTRIBUTES]['id']);
        $this->assertEquals('N', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][5][HTMLFactory::CHILDREN][0]);

        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][6][HTMLFactory::TAG]);
        $this->assertEquals(Activiteit::MI_INTERPERSOONLIJK, $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][6][HTMLFactory::ATTRIBUTES]['id']);
        $this->assertEquals('selected', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][6][HTMLFactory::ATTRIBUTES]['class']);
        $this->assertEquals('IR', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][6][HTMLFactory::CHILDREN][0]);

        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][7][HTMLFactory::TAG]);
        $this->assertEquals(Activiteit::MI_INTRAPERSOONLIJK, $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][7][HTMLFactory::ATTRIBUTES]['id']);
        $this->assertEquals('selected', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][7][HTMLFactory::ATTRIBUTES]['class']);
        $this->assertEquals('IA', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][7][HTMLFactory::CHILDREN][0]);

        $row = $html[0][HTMLFactory::CHILDREN][4];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("inhoud", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals($werkvorm['inhoud'], $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    }
}
