<?php
namespace Teach\Interactions\Document;

final class HTML implements \Teach\Interactions\Documenter
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \Teach\Interactions\Documenter::makeDocument($presentable)
     */
    public function makeDocument(\Teach\Interactions\Documentable $presentable): \Teach\Adapters\Renderable
    {
        $html = $this->makeElement('html', []);
        $head = $this->makeElement('head', []);
        // @TODO: remove specific les head contents
        $head->appendHTML('<meta charset="UTF-8"><title>Lesplan</title><link rel="stylesheet" type="text/css" href="lesplan.css">');
        $html->append($head);
        $body = $this->makeElement('body', []);
        $body->appendHTML($presentable->present($this));
        $html->append($body);
        return $html;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Teach\Interactions\Documenter::makePageHeader($title, $subtitle)
     */
    public function makeFirstPage(string $title, string $subtitle): \Teach\Adapters\Renderable
    {
        $header = $this->makeElement('header', []);
        $header->append($this->makeHeader('1', $title));
        $header->append($this->makeHeader('2', $subtitle));
        return $header;
    }

    /**
     *
     * @param string $tagName            
     * @param array $attributes            
     * @return \Teach\Interactions\HTML\Element
     */
    public function makeElement(string $tagName, array $attributes): \Teach\Adapters\Renderable
    {
        $element = new \Teach\Adapters\HTML\Element($tagName);
        
        foreach ($attributes as $attributeIdentifier => $attributeValue) {
            $element->attribute($attributeIdentifier, $attributeValue);
        }
        
        return $element;
    }

    /**
     *
     * @param string $text            
     * @return \Teach\Interactions\HTML\Text
     */
    public function makeText($text): \Teach\Adapters\Renderable
    {
        return new \Teach\Adapters\HTML\Text($text);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Teach\Interactions\LayoutFactoryInterface::makeTableRow()
     */
    public function makeTableRow($expectedCellCount, array $data): \Teach\Adapters\Renderable
    {
        $cellsHTML = [];
        foreach ($data as $header => $value) {
            $cellHeader = $this->makeElement('th', []);
            $cellHeader->append($this->makeText($header));
            $cellsHTML[] = $cellHeader;
            
            if (is_string($value)) {
                $cell = $this->makeElement('td', [
                    'id' => $header
                ]);
                $cell->append($this->makeText($value));
            } else {
                $cell = $this->makeElement('td', [
                    'id' => $header
                ]);
                $cell->append($this->makeUnorderedList($value));
            }
            $cellsHTML[] = $cell;
        }
        
        $actualCellCount = count($cellsHTML);
        if ($actualCellCount < $expectedCellCount) {
            $lastCellIndex = $actualCellCount - 1;
            $colspan = (string) ($expectedCellCount - $lastCellIndex); // last cell must also be included in span
            
            $cellsHTML[$lastCellIndex]->attribute('colspan', $colspan);
        }
        
        $row = $this->makeElement('tr', []);
        $row->append(...$cellsHTML);
        return $row;
    }

    /**
     *
     * @param string $tag            
     * @param array $listitems            
     */
    private function makeList($tag, array $listitems): \Teach\Adapters\Renderable
    {
        $listitemsHTML = [];
        foreach ($listitems as $listitem) {
            $li = $this->makeElement('li', []);
            $li->append($this->makeText($listitem));
            $listitemsHTML[] = $li;
        }
        $list = $this->makeElement($tag, []);
        $list->append(...$listitemsHTML);
        return $list;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Teach\Interactions\LayoutFactoryInterface::makeUnorderedList()
     */
    public function makeUnorderedList(array $listitems): \Teach\Adapters\Renderable
    {
        return $this->makeList('ul', $listitems);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Teach\Interactions\LayoutFactoryInterface::makeTable()
     */
    public function makeTable($caption, array $rows): \Teach\Adapters\Renderable
    {
        $expectedCellCount = 0;
        foreach ($rows as $row) {
            $expectedCellCount = max($expectedCellCount, count($row) * 2); // key/value both give a cell (th/td)
        }
        
        $table = $this->makeElement('table', []);
        if ($caption !== null) {
            $captionElement = $this->makeElement('caption', []);
            $captionElement->append($this->makeText($caption));
            $table->append($captionElement);
        }
        
        foreach ($rows as $row) {
            $table->append($this->makeTableRow($expectedCellCount, $row));
        }
        
        return $table;
    }

    /**
     *
     * @param string $level            
     * @param string $text            
     * @return \Teach\Interactions\HTML\Element
     */
    public function makeHeader(string $level, string $text): \Teach\Adapters\Renderable
    {
        $header = $this->makeElement('h' . $level, []);
        $header->append($this->makeText($text));
        return $header;
    }

    public function makeSection(): \Teach\Adapters\Renderable
    {
        return $this->makeElement('section', []);
    }
}