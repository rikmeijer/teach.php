<?php
namespace Teach\Domain;

interface Documenter
{
    public function push();
    public function pop();
    
    public function makeDocument(string $title, string $content): \Teach\Adapters\Renderable;

    public function makeFirstPage(string $title, string $subtitle): \Teach\Adapters\Renderable;

    public function makeTableRow($expectedCellCount, array $data): \Teach\Adapters\Renderable;

    public function makeUnorderedList(array $listitems): \Teach\Adapters\Renderable;

    public function makeTable($caption, array $rows): \Teach\Adapters\Renderable;

    public function makeHeader(string $level, string $text): \Teach\Adapters\Renderable;

    public function makeHeaderNested(string $text): \Teach\Adapters\Renderable;
    
    public function makeSection(): \Teach\Adapters\Renderable;
}