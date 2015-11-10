<?php
namespace Teach\Adapters\HTML;

final class Factory implements \Teach\Adapters\LayoutFactoryInterface
{

    const TAG = 0;

    const ATTRIBUTES = 1;

    const TEXT = 1;

    const CHILDREN = 2;

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
            $element->append($this->convertDefinition($elementDefinition));
        }
        return $element;
    }

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
        } elseif (is_string($elementDefinition[1])) {
            return $this->convertDefinition([
                $elementDefinition[0],
                [],
                [
                    $elementDefinition[1]
                ]
            ]);
        } else {
            return $this->createElement($elementDefinition[0], $elementDefinition[1], $elementDefinition[2]);
        }
    }

    public function makeHTML(array $elements)
    {
        $html = '';
        foreach ($elements as $elementDefinition) {
            $html .= $this->convertDefinition($elementDefinition)->render();
        }
        return $html;
    }   

    public function makeHTMLFrom(\Teach\Adapters\LayoutableInterface $layoutable)
    {
        return $this->makeHTML($layoutable->generateLayout ($this));
    }
    
    private function makeHTMLText($tag, $text)
    {
        return [self::TAG => $tag, self::TEXT => $text];
    }
    
    private function makeHTMLElement($tag, array $attributes, array $children)
    {
        return [self::TAG => $tag, self::ATTRIBUTES => $attributes, self::CHILDREN => $children];
    }
    
    public function makeTableRow($expectedCellCount, array $data)
    {
        $cellsHTML = [];
        foreach ($data as $header => $value) {
            $cellsHTML[] = $this->makeHTMLText('th', $header);
            if (is_string($value)) {
                $cellsHTML[] = $this->makeHTMLText('td', $value);
            } else {
                $cellsHTML[] = $this->makeHTMLElement('td', [], $value);
            }
        }
        
        $actualCellCount = count($cellsHTML);
        if ($actualCellCount < $expectedCellCount) {
            $lastCellIndex = $actualCellCount - 1;
            $colspan = (string)($expectedCellCount - $lastCellIndex); // last cell must also be included in span
            
            if (count($cellsHTML[$lastCellIndex]) === 3) {
                $cellsHTML[$lastCellIndex][self::ATTRIBUTES]['colspan'] = $colspan;
            } else {
                $cellsHTML[$lastCellIndex] = $this->makeHTMLElement($cellsHTML[$lastCellIndex][self::TAG], ['colspan' => $colspan], [$cellsHTML[$lastCellIndex][self::TEXT]]);
            }
        }
        
        return $this->makeHTMLElement('tr', [], $cellsHTML);
    }
    
    private function makeList($tag, array $listitems)
    {
        $listitemsHTML = [];
        foreach ($listitems as $listitem) {
            $listitemsHTML[] = $this->makeHTMLText('li', $listitem);
        }
        return $this->makeHTMLElement($tag, [], $listitemsHTML);
    }
    
    public function makeUnorderedList(array $listitems)
    {
        return $this->makeList('ul', $listitems);
    }


    public function makeOrderedList(array $listitems)
    {
        return $this->makeList('ol', $listitems);
    }
    
    public function makeTable($caption, array $rows)
    {
        $expectedCellCount = 0;
        foreach ($rows as $row) {
            $expectedCellCount = max($expectedCellCount, count($row) * 2); // key/value both give a cell (th/td)
        }
            
        $tableChildrenHTML = [];
        if ($caption !== null) {
            $tableChildrenHTML[] = $this->makeHTMLText('caption', $caption);
        }
        foreach ($rows as $row) {
            $tableChildrenHTML[] = $this->makeTableRow($expectedCellCount, $row);
        }
        
        return $this->makeHTMLElement('table', [], $tableChildrenHTML);
    }
    
    public function makeHeader1($text)
    {
        return $this->makeHTMLText('h1', $text);
    }
    
    public function makeHeader2($text)
    {
        return $this->makeHTMLText('h2', $text);
    }
    
    public function makeHeader3($text)
    {
        return $this->makeHTMLText('h3', $text);
    }
    
    public function makeParagraph($text)
    {
        return $this->makeHTMLText('p', $text);
    }
    
    public function makePageHeader(array $header)
    {
        return $this->makeHTMLElement('header', [], [$header]);
    }
    
    public function makeSection(array $header, array $contents)
    {
        \array_unshift($contents, $header);
        return $this->makeHTMLElement('section', [], $contents);
    }
}