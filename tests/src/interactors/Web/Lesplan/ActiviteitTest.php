<?php
namespace Teach\Interactions\Web\Lesplan;

class ActiviteitTest extends \PHPUnit_Framework_TestCase
{

    public function testProvideTemplateVariablesOnderdelen()
    {
        $object = new Activiteit("Reflecteren", $werkvorm = array(
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
        ));
        
        $html = $object->document(new class() implements \Teach\Interactions\Documenter {

            /**
             *
             * @param \Teach\Interactions\Documentable $documentable            
             * @return \Teach\Adapters\Renderable
             */
            public function makeDocument(\Teach\Interactions\Documentable $documentable): \Teach\Adapters\Renderable
            {
                return null;
            }

            /**
             *
             * @param string $title            
             * @param string $subtitle            
             * @return \Teach\Adapters\Renderable
             */
            public function makeFirstPage(string $title, string $subtitle): \Teach\Adapters\Renderable
            {
                return null;
            }

            /**
             *
             * @param int $expectedCellCount            
             * @param array $data            
             */
            public function makeTableRow($expectedCellCount, array $data): \Teach\Adapters\Renderable
            {
                return null;
            }

            /**
             *
             * @param array $listitems            
             */
            public function makeUnorderedList(array $listitems): \Teach\Adapters\Renderable
            {
                return null;
            }

            /**
             *
             * @param string $caption            
             * @param array $rows            
             */
            public function makeTable($caption, array $rows): \Teach\Adapters\Renderable
            {
                return new class($caption . ": " . serialize($rows)) implements \Teach\Adapters\Renderable {

                    public function __construct($content)
                    {
                        $this->content = $content;
                    }

                    public function render(): string
                    {
                        return $this->content;
                    }
                };
            }

            /**
             *
             * @param string $level            
             * @param string $text            
             * @return \Teach\Interactions\HTML\Element
             */
            public function makeHeader(string $level, string $text): \Teach\Adapters\Renderable
            {
                return null;
            }

            /**
             *
             * @return Renderable
             */
            public function makeSection(): \Teach\Adapters\Renderable
            {
                return null;
            }
        });
        
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
                'intelligenties' => array_values(array_intersect(Activiteit::INTELLIGENTIES, [
                    Activiteit::MI_VERBAAL_LINGUISTISCH,
                    Activiteit::MI_INTRAPERSOONLIJK,
                    Activiteit::MI_INTERPERSOONLIJK
                ]))
            ],
            [
                'inhoud' => "• Link leggen naar een programmeeromgeving: niet fysiek, maar virtueel.
    • Wie kan bedenken wat voor gereedschap erbij programmeren komt kijken?"
            ]
        ]), $html);
    }
}
