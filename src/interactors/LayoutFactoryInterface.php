<?php
namespace Teach\Interactors;

interface LayoutFactoryInterface
{
    public function makeTableRow($expectedCellCount, array $data);
    
    public function makeUnorderedList(array $listitems);
    
    public function makeOrderedList(array $listitems);
    
    public function makeTable($caption, array $rows);
}