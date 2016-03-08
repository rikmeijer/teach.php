<?php
namespace Teach\Adapters;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $object = new Document(new class implements \Teach\Adapters\AdapterInterface {

            public function makeDocument(\Teach\Interactors\PresentableInterface $presentable): \Teach\Adapters\RenderableInterface
            {
                return new class($presentable->present($this)) implements \Teach\Adapters\RenderableInterface {
                    
                    /**
                     * @var string
                     */
                    private $content;
                    
                    public function __construct(string $content)
                    {
                        $this->content = $content;   
                    }
                    
                    public function render(): string
                    {
                        return '<html><head></head><body>' . $this->content . '</body></html>';
                    }
                };
            }
            
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
                return '<p>Hello World</p>';
            }
        });
        $this->assertEquals('<html><head></head><body><p>Hello World</p></body></html>', $html);
    }
    
    
}