<?php
namespace Teach\Adapters;

interface Documentable
{
    /**
     * 
     * @param \Teach\Interactors\PresentableInterface $presentable
     * @return \Teach\Adapters\RenderableInterface
     */
    public function makeDocument(\Teach\Interactors\PresentableInterface $presentable): \Teach\Adapters\RenderableInterface;
    
    /**
     * 
     * @param string $title
     * @param string $subtitle
     * @return \Teach\Adapters\RenderableInterface
     */
    public function makeFirstPage(string $title, string $subtitle): \Teach\Adapters\RenderableInterface;
    
    /**
     * 
     * @param int $expectedCellCount
     * @param array $data
     */
    public function makeTableRow($expectedCellCount, array $data): \Teach\Adapters\RenderableInterface;
    
    /**
     * 
     * @param array $listitems
     */
    public function makeUnorderedList(array $listitems): \Teach\Adapters\RenderableInterface;
    
    /**
     * 
     * @param string $caption
     * @param array $rows
     */
    public function makeTable($caption, array $rows): \Teach\Adapters\RenderableInterface;
    
    /**
     * 
     * @param string $level
     * @param string $text
     * @return \Teach\Adapters\HTML\Element
     */
    public function makeHeader(string $level, string $text): \Teach\Adapters\RenderableInterface;
    
    /**
     * 
     * @return RenderableInterface
     */
    public function makeSection();
}