<?php
namespace Teach\Interactions;

class DocumentTest extends \PHPUnit_Framework_TestCase
{

    public function testRender()
    {
        $object = new Document(new class() implements \Teach\Interactions\Documenter {

            public function makeDocument(\Teach\Interactions\Documentable $documentable): \Teach\Adapters\Renderable
            {
                return new class($documentable->document($this)) implements \Teach\Adapters\Renderable {

                    /**
                     *
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
                return null;
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

            public function makeSection(): \Teach\Adapters\Renderable
            {
                return null;
            }
        });
        
        $html = $object->render(new class() implements \Teach\Interactions\Documentable {

            public function document(\Teach\Interactions\Documenter $adapter): string
            {
                return '<p>Hello World</p>';
            }
        });
        $this->assertEquals('<html><head></head><body><p>Hello World</p></body></html>', $html);
    }
}