<?php
namespace Teach\Adapters;

class HTMLTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $object = new HTML(new class implements \Teach\Adapters\AdapterInterface {

            /**
             *
             * @param int $expectedCellCount
             * @param array $data
             */
            public function makeTableRow($expectedCellCount, array $data)
            {
                return null;
            }
            
            /**
             *
             * @param array $listitems
             */
            public function makeUnorderedList(array $listitems)
            {
                return null;
            }
            
            /**
             *
             * @param string $caption
             * @param array $rows
             */
            public function makeTable($caption, array $rows)
            {
                return null;
            }
            
            /**
             *
             * @param string $level
             * @param string $text
             * @return \Teach\Adapters\HTML\Element
             */
            public function makeHeader(string $level, string $text)
            {
                return null;
            }
            public function makeSection()
            {
                return null;
            }
        });
        $html = $object->render(new class implements \Teach\Interactors\PresentableInterface {
            public function present(\Teach\Adapters\AdapterInterface $factory): string
            {
                return '<body></body>';
            }
        });
        $this->assertEquals('<!DOCTYPE html><html><body></body></html>', $html);
    }
    
    
}