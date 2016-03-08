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
            public function makeTableRow($expectedCellCount, array $data): \Teach\Adapters\RenderableInterface
            {
                return null;
            }
            
            /**
             *
             * @param array $listitems
             */
            public function makeUnorderedList(array $listitems): \Teach\Adapters\RenderableInterface
            {
                return null;
            }
            
            /**
             *
             * @param string $caption
             * @param array $rows
             */
            public function makeTable($caption, array $rows): \Teach\Adapters\RenderableInterface
            {
                return null;
            }
            
            /**
             *
             * @param string $level
             * @param string $text
             * @return \Teach\Adapters\HTML\Element
             */
            public function makeHeader(string $level, string $text): \Teach\Adapters\RenderableInterface
            {
                return null;
            }
            public function makeSection(): \Teach\Adapters\RenderableInterface
            {
                return null;
            }
        });
        $html = $object->render(new class implements \Teach\Interactors\PresentableInterface {
            public function present(\Teach\Adapters\AdapterInterface $adapter): string
            {
                return '<body></body>';
            }
        });
        $this->assertEquals('<!DOCTYPE html><html><body></body></html>', $html);
    }
    
    
}