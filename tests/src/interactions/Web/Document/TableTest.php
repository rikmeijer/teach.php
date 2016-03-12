<?php
namespace Teach\Interactions\Web\Document;

class TableTest extends \PHPUnit_Framework_TestCase
{

    public function testDocument()
    {
        $object = new Table("Reflecteren", [
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
        ]);
        
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
