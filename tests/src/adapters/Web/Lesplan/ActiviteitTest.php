<?php
namespace Teach\Adapters\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class ActiviteitTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHTMLLayout()
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
        $html = $object->generateLayout (new HTMLFactory());
        $this->assertEquals('table', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("caption", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Reflecteren", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);

        $row = $html[0][HTMLFactory::CHILDREN][1];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("werkvorm", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("brainstormen", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
        
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
        $this->assertEquals("organisatievorm", $row[HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("plenair", $row[HTMLFactory::CHILDREN][3][HTMLFactory::CHILDREN][0]);

        $row = $html[0][HTMLFactory::CHILDREN][2];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("tijd", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("5 minuten", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
        
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
        $this->assertEquals("soort werkvorm", $row[HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][3][HTMLFactory::TAG]);
        $this->assertEquals("discussie", $row[HTMLFactory::CHILDREN][3][HTMLFactory::CHILDREN][0]);
        

        $row = $html[0][HTMLFactory::CHILDREN][3];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("intelligenties", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals("ul", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertCount(3, $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN]);
        
        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals('VL', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]); // CHILDREN][0]);

        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('IR', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]); // CHILDREN][0]);

        $this->assertEquals("li", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
        $this->assertEquals('IA', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0]); // CHILDREN][0]);

        $row = $html[0][HTMLFactory::CHILDREN][4];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("inhoud", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals($werkvorm['inhoud'], $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    }

    public function testGenerateHTMLLayoutWithArrayAsContent()
    {
        $object = new Activiteit("Reflecteren", $werkvorm = array(
            "inhoud" => [
                "Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.",
                "Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?"
            ],
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
        $html = $object->generateLayout (new HTMLFactory());
        
        $row = $html[0][HTMLFactory::CHILDREN][4];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("inhoud", $row[HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        
        $this->assertEquals('ul', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals('li', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        $this->assertEquals('li', $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?", $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    }
}
