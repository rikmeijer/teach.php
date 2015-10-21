<?php
namespace Teach\Adapters\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

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
        //$this->assertEquals("5 minuten", $row[HTMLFactory::CHILDREN][1][HTMLFactory::TEXT]);
    }
}
