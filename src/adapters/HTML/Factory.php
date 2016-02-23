<?php
namespace Teach\Adapters\HTML;

final class Factory implements \Teach\Interactors\LayoutFactoryInterface
{

    const TAG = 0;

    const ATTRIBUTES = 1;

    const CHILDREN = 2;

    
    public function renderTemplate($filename, ...$templateParameters) {
        $renderer = require $filename;
        
        return $renderer($this, ...$templateParameters);
    }
    
    /**
     * 
     * @param array $listitems
     */
    public function renderUnorderedList(array $listitems)
    {
        $listitemsHTML = [];
        foreach ($listitems as $listitem) {
            $listitemsHTML[] = $this->createElement('li', [], [
                $listitem
            ]);
        }
        return $this->createElement('ul', [], $listitemsHTML)->render();
    }
    
    /**
     *
     * @param array $definition            
     * @return Element
     */
    public function createElement($tagName, array $attributes, array $elements)
    {
        $element = new Element($tagName);
        
        foreach ($attributes as $attributeIdentifier => $attributeValue) {
            $element->attribute($attributeIdentifier, $attributeValue);
        }
        
        foreach ($elements as $elementDefinition) {
            if ($elementDefinition instanceof RenderableInterface) {
                $element->append($elementDefinition);
            } else {
                $element->append($this->convertDefinition($elementDefinition));
            }
        }
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
     * @param array $elementDefinition            
     * @return RenderableInterface
     */
    private function convertDefinition($elementDefinition)
    {
        if (is_string($elementDefinition)) {
            return $this->createText($elementDefinition);
        } else {
            return $this->createElement($elementDefinition[0], $elementDefinition[1], $elementDefinition[2]);
        }
    }

    /**
     *
     * @param array $elements            
     * @return string
     */
    public function makeHTML(array $elements)
    {
        $html = '';
        foreach ($elements as $elementDefinition) {
            $html .= $this->convertDefinition($elementDefinition)->render();
        }
        return $html;
    }

    /**
     *
     * @param string $tag            
     * @param array $attributes            
     * @param array $children            
     */
    private function makeHTMLElement($tag, array $attributes, array $children)
    {
        return [
            self::TAG => $tag,
            self::ATTRIBUTES => $attributes,
            self::CHILDREN => $children
        ];
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
            $cellsHTML[] = $this->makeHTMLElement('th', [], [$header]);
            if (is_string($value)) {
                $cellsHTML[] = $this->makeHTMLElement('td', ['id' => $header], [$value]);
            } else {
                $cellsHTML[] = $this->makeHTMLElement('td', ['id' => $header], $value);
            }
        }
        
        $actualCellCount = count($cellsHTML);
        if ($actualCellCount < $expectedCellCount) {
            $lastCellIndex = $actualCellCount - 1;
            $colspan = (string) ($expectedCellCount - $lastCellIndex); // last cell must also be included in span
            
            if (count($cellsHTML[$lastCellIndex]) === 3) {
                $cellsHTML[$lastCellIndex][self::ATTRIBUTES]['colspan'] = $colspan;
            } else {
                $cellsHTML[$lastCellIndex] = $this->makeHTMLElement($cellsHTML[$lastCellIndex][self::TAG], [
                    'colspan' => $colspan
                ], [
                    $cellsHTML[$lastCellIndex][self::CHILDREN][0]
                ]);
            }
        }
        
        return $this->createElement('tr', [], $cellsHTML);
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
            $listitemsHTML[] = $this->makeHTMLElement('li', [], [
                $listitem
            ]);
        }
        return $this->makeHTMLElement($tag, [], $listitemsHTML);
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
        foreach ($rows as &$row) {
            foreach ($row as &$cell) {
                if (is_array($cell)) {
                    $cell = [$this->makeUnorderedList($cell)];
                }
            }
        }
        unset($row);
        
        $expectedCellCount = 0;
        foreach ($rows as $row) {
            $expectedCellCount = max($expectedCellCount, count($row) * 2); // key/value both give a cell (th/td)
        }
        
        $tableChildrenHTML = [];
        if ($caption !== null) {
            $tableChildrenHTML[] = $this->createElement('caption', [], [
                $caption
            ]);
        }
        foreach ($rows as $row) {
            $tableChildrenHTML[] = $this->makeTableRow($expectedCellCount, $row);
        }
        
        return $this->createElement('table', [], $tableChildrenHTML);
    }
}