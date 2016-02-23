<?php
namespace Teach\Interactors;

interface LayoutFactoryInterface
{
    public function makeTableRow($expectedCellCount, array $data);
    
    public function makeUnorderedList(array $listitems);
    
    public function makeOrderedList(array $listitems);
    
    public function makeTable($caption, array $rows);
    
    public function makeHeader1($text);
    
    public function makeHeader2($text);
    
    public function makeHeader3($text);
    
    public function makeParagraph($text);
}