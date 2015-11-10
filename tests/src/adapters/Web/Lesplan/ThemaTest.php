<?php
namespace Teach\Adapters\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class ThemaTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHTMLLayout()
    {
        $object = new Thema("Thema 1: zelf de motor reviseren");
        $html = $object->generateLayout (new HTMLFactory());
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h3", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Thema 1: zelf de motor reviseren", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    }
    

    public function testGenerateHTMLLayoutActiviteiten()
    {
        $object = new Thema("Thema 1: zelf de motor reviseren");
        
        $object->addActiviteit(new Activiteit("Reflecteren", $werkvorm = array(
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
            )));
        $html = $object->generateLayout (new HTMLFactory());
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h3", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Thema 1: zelf de motor reviseren", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        
        $row = $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][4];
        $this->assertEquals("tr", $row[HTMLFactory::TAG]);
        $this->assertEquals("th", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("inhoud", $row[HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        $this->assertEquals("td", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals('3', $row[HTMLFactory::CHILDREN][1][HTMLFactory::ATTRIBUTES]['colspan']);
        $this->assertEquals($werkvorm['inhoud'], $row[HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0]);
    }
}
