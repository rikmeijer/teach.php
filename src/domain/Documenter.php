<?php
namespace Teach\Domain;

interface Documenter
{
    public function push();
    public function pop();
    
    public function makeDocument(string $title, string $content): \Teach\Adapters\Renderable;

    /**
     *
     * @param string $title            
     * @param string $subtitle            
     * @return \Teach\Adapters\Renderable
     */
    public function makeFirstPage(string $title, string $subtitle): \Teach\Adapters\Renderable;

    /**
     *
     * @param int $expectedCellCount            
     * @param array $data            
     */
    public function makeTableRow($expectedCellCount, array $data): \Teach\Adapters\Renderable;

    /**
     *
     * @param array $listitems            
     */
    public function makeUnorderedList(array $listitems): \Teach\Adapters\Renderable;

    /**
     *
     * @param string $caption            
     * @param array $rows            
     */
    public function makeTable($caption, array $rows): \Teach\Adapters\Renderable;

    /**
     *           
     * @param string $text            
     * @return \Teach\Interactions\HTML\Element
     */
    public function makeHeader(string $text): \Teach\Adapters\Renderable;
    
    /**
     *
     * @return Renderable
     */
    public function makeSection(): \Teach\Adapters\Renderable;
}