<?php
namespace Test;

/*
 * test specific bootstrapper
 */
$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

require_once __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'DomainTest.php';

class Helper {
    
    static function implementDocumenter() {
        return new class() implements \Teach\Interactions\Documenter {

            private function makeRenderer(string $contents): \Teach\Adapters\Renderable {
                return new class($contents) implements \Teach\Adapters\Renderable {
                
                    private $contents;
                    private $children;
                    
                    public function __construct($contents)
                    {
                        $this->children = [];
                        $this->contents = $contents;
                    }
                
                    public function append(\Teach\Adapters\Renderable ...$children) 
                    {
                        $this->children = array_merge($this->children, $children);
                    }
                    public function appendHTML(string ...$children) 
                    {
                        $this->children = array_merge($this->children, $children);
                    }
                    
                    public function render(): string
                    {
                        $children = [];
                        foreach ($this->children as $child) {
                            if (is_string($child)) {
                                $children[] = $child;
                            } else {
                                $children[] = $child->render();
                            }
                        }
                        
                        return $this->contents . join("...", $children);
                    }
                };
            }
            
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
                return $this->makeRenderer("fp" . $title . ":" . $subtitle);
            }

            /**
             *
             * @param int $expectedCellCount            
             * @param array $data            
             */
            public function makeTableRow($expectedCellCount, array $data): \Teach\Adapters\Renderable
            {
                return $this->makeRenderer("tr(".$expectedCellCount."): " . serialize($data));
            }

            /**
             *
             * @param array $listitems            
             */
            public function makeUnorderedList(array $listitems): \Teach\Adapters\Renderable
            {
                return $this->makeRenderer("ul: " . serialize($listitems));
            }

            /**
             *
             * @param string $caption            
             * @param array $rows            
             */
            public function makeTable($caption, array $rows): \Teach\Adapters\Renderable
            {
                return $this->makeRenderer($caption . ": " . serialize($rows));
            }

            /**
             *
             * @param string $level            
             * @param string $text            
             * @return \Teach\Interactions\HTML\Element
             */
            public function makeHeader(string $level, string $text): \Teach\Adapters\Renderable
            {
                return $this->makeRenderer($level . ":" . $text);
            }

            /**
             *
             * @return Renderable
             */
            public function makeSection(): \Teach\Adapters\Renderable
            {
                return $this->makeRenderer("section");
            }
        };
    }
    
}