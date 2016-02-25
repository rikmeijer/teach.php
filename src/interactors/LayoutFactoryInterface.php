<?php
namespace Teach\Interactors;

interface LayoutFactoryInterface
{
    /**
     * 
     * @param int $expectedCellCount
     * @param array $data
     */
    public function makeTableRow($expectedCellCount, array $data);
    
    /**
     * 
     * @param array $listitems
     */
    public function makeUnorderedList(array $listitems);
    
    /**
     * 
     * @param string $caption
     * @param array $rows
     */
    public function makeTable(string $caption, array $rows);
    
    /**
     * 
     * @param string $level
     * @param string $text
     * @return \Teach\Adapters\HTML\Element
     */
    public function makeHeader(string $level, string $text);
}