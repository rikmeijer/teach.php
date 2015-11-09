<?php
namespace Teach\Adapters\HTML;

final class Factory
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

    public function makeHTMLFrom(LayoutableInterface $layoutable)
    {
        return $this->makeHTML($layoutable->generateHTMLLayout($this));
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
    
    public function makeUnorderedList(array $listitems)
    {
        $listitemsHTML = [];
        foreach ($listitems as $listitem) {
            $listitemsHTML[] = $this->makeHTMLText('li', $listitem);
        }
        return $this->makeHTMLElement('ul', [], $listitemsHTML);
    }
    
    public function makeTable($caption, array $rows)
    {
        return $this->makeHTMLElement('table', [], [
            $this->makeHTMLText('caption', $caption)
        ]);
    }
}