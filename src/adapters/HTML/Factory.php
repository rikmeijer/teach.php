<?php
namespace Teach\Adapters\HTML;

final class Factory implements \Teach\Interactors\LayoutFactoryInterface
{
    /**
     * 
     * @param string $filename
     * @param mixed ...$templateParameters
     */
    public function renderTemplate(string $filename, ...$templateParameters) {
        $renderer = require $filename;
        
        return $renderer($this, ...$templateParameters);
    }
    
    /**
     * 
     * @param string $tagName
     * @param array $attributes
     * @return \Teach\Adapters\HTML\Element
     */
    public function makeElement(string $tagName, array $attributes) 
    {
        $element = new Element($tagName);
        
        foreach ($attributes as $attributeIdentifier => $attributeValue) {
            $element->attribute($attributeIdentifier, $attributeValue);
        }
        
        return $element;
    }

    /**
     *
     * @param string $text            
     * @return \Teach\Adapters\HTML\Text
     */
    public function makeText($text)
    {
        return new Text($text);
    }
    
    /**
     *
     * {@inheritDoc}
     *
     * @see \Teach\Interactors\LayoutFactoryInterface::makeTableRow()
     */
    public function makeTableRow($expectedCellCount, array $data)
    {
        $cellsHTML = [];
        foreach ($data as $header => $value) {
            $cellHeader = $this->makeElement('th', []);
            $cellHeader->append($this->makeText($header));
            $cellsHTML[] = $cellHeader;
            
            if (is_string($value)) {
                $cell = $this->makeElement('td', ['id' => $header]);
                $cell->append($this->makeText($value));
            } else {
                $cell = $this->makeElement('td', ['id' => $header]);
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
    private function makeList($tag, array $listitems)
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
     * @see \Teach\Interactors\LayoutFactoryInterface::makeUnorderedList()
     */
    public function makeUnorderedList(array $listitems)
    {
        return $this->makeList('ul', $listitems);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Teach\Interactors\LayoutFactoryInterface::makeTable()
     */
    public function makeTable($caption, array $rows)
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
     * @return \Teach\Adapters\HTML\Element
     */
    public function makeHeader(string $level, string $text)
    {
        $header = $this->makeElement('h' . $level, []);
        $header->append($this->makeText($text));
        return $header;
    }
    
    public function makeSection()
    {
        return $this->makeElement('section', []);
    }
}