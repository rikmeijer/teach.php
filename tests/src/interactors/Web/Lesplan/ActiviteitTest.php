<?php
namespace Teach\Interactors\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class ActiviteitTest extends \PHPUnit_Framework_TestCase
{
    public function testProvideTemplateVariablesOnderdelen()
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
        
        $variables = $object->provideTemplateVariables([
            "title",
            "inhoud",
            "werkvorm",
            "organisatievorm",
            "werkvormsoort",
            "tijd",
            "intelligenties",
        ]);

        $this->assertEquals("Reflecteren", $variables["title"]);
        $this->assertEquals("•	Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.
•	Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?", $variables["inhoud"]);
        $this->assertEquals("brainstormen", $variables["werkvorm"]);
        $this->assertEquals("plenair", $variables["organisatievorm"]);
        $this->assertEquals("discussie", $variables["werkvormsoort"]);
        $this->assertEquals("5 minuten", $variables["tijd"]);
        var_Dump($variables['intelligenties']);
        $this->assertEquals(Activiteit::MI_VERBAAL_LINGUISTISCH, $variables["intelligenties"][0]);
        $this->assertEquals(Activiteit::MI_INTERPERSOONLIJK, $variables["intelligenties"][1]);
        $this->assertEquals(Activiteit::MI_INTRAPERSOONLIJK, $variables["intelligenties"][2]);
    }
}
