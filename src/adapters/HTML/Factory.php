<?php
namespace Teach\Adapters\HTML;

final class Factory implements \Teach\Interactors\LayoutFactoryInterface
{
    public function renderTemplate($filename, ...$templateParameters) {
        $renderer = require $filename;
        
        return $renderer($this, ...$templateParameters);
    }
    
    public function createElementWithoutChildren($tagName, array $attributes) 
    {
        $element = new Element($tagName);
        
        foreach ($attributes as $attributeIdentifier => $attributeValue) {
            $element->attribute($attributeIdentifier, $attributeValue);
        }
        
        return $element;
    }
    
    /**
     *
     * @param array $definition            
     * @return Element
     */
    public function createElement($tagName, array $attributes, RenderableInterface ...$elements)
    {
        $element = $this->createElementWithoutChildren($tagName, $attributes);
        $element->append(...$elements);
        return $element;
    }

    /**
     *
     * @param string $text            
     * @return \Teach\Adapters\HTML\Text
     */
    public function createText($text)
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
            $cellHeader = $this->createElementWithoutChildren('th', []);
            $cellHeader->append($this->createText($header));
            $cellsHTML[] = $cellHeader;
            
            if (is_string($value)) {
                $cell = $this->createElementWithoutChildren('td', ['id' => $header]);
                $cell->append($this->createText($value));
            } else {
                $cell = $this->createElementWithoutChildren('td', ['id' => $header]);
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
        
        $row = $this->createElementWithoutChildren('tr', []);
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
            $li = $this->createElementWithoutChildren('li', []);
            $li->append($this->createText($listitem));
            $listitemsHTML[] = $li;
        }
        $list = $this->createElementWithoutChildren($tag, []);
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

        $table = $this->createElementWithoutChildren('table', []);
        if ($caption !== null) {
            $captionElement = $this->createElementWithoutChildren('caption', []);
            $captionElement->append($this->createText($caption));
            $table->append($captionElement);
        }
        
        foreach ($rows as $row) {
            $table->append($this->makeTableRow($expectedCellCount, $row));
        }

        return $table;
    }
}