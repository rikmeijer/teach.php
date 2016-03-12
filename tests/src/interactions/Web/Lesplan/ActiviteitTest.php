<?php
namespace Teach\Interactions\Web\Lesplan;

class ActiviteitTest extends \PHPUnit_Framework_TestCase
{

    public function testDocument()
    {
        $object = new Activiteit("Reflecteren", $werkvorm = array(
            "inhoud" => "• Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.
    • Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?",
            "werkvorm" => "brainstormen",
            "organisatievorm" => "plenair",
            "werkvormsoort" => "discussie",
            "tijd" => "5",
            "intelligenties" => array(
                \Teach\Domain\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Domain\Lesplan\Activiteit::MI_INTRAPERSOONLIJK,
                \Teach\Domain\Lesplan\Activiteit::MI_INTERPERSOONLIJK
            )
        ));
        
        $html = $object->document(\Test\Helper::implementDocumenter());
        
        $this->assertEquals("Reflecteren: " . serialize([
            [
                'werkvorm' => "brainstormen",
                'organisatievorm' => "plenair"
            ],
            [
                'tijd' => "5 minuten",
                'soort werkvorm' => "discussie"
            ],
            [
                'intelligenties' => [
                    \Teach\Domain\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                    \Teach\Domain\Lesplan\Activiteit::MI_INTRAPERSOONLIJK,
                    \Teach\Domain\Lesplan\Activiteit::MI_INTERPERSOONLIJK
                ]
            ],
            [
                'inhoud' => "• Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.
    • Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?"
            ]
        ]), $html);
    }
}
