<?php
namespace Teach\Adapters\Web\Lesplan;

final class Fase implements \Teach\Adapters\HTML\LayoutableInterface
{

    private $title;
    
    /**
     * 
     * @var \Teach\Adapters\HTML\LayoutableInterface[]
     */
    private $onderdelen = array();

    /**
     *
     * @var \Teach\Adapters\HTML\LayoutableInterface
     */
    private $sibling;

    public function __construct($title)
    {
        $this->title = $title;
    }
    
    public function chainTo(\Teach\Adapters\HTML\LayoutableInterface $sibling)
    {
        $this->sibling = $sibling;
    }
    
    public function addOnderdeel(\Teach\Adapters\HTML\LayoutableInterface $onderdeel)
    {
        $this->onderdelen[] = $onderdeel;
    }

    /**
     *
     * @return array
     */
    public function generateHTMLLayout()
    {
        $onderdelenHTML = [];
        foreach ($this->onderdelen as $onderdeel) {
            $onderdelenHTML = array_merge($onderdelenHTML, $onderdeel->generateHTMLLayout());
        }
        
        if ($this->sibling === null) {
            $siblingHTML = [];
        } else {
            $siblingHTML = $this->sibling->generateHTMLLayout();
        }
        
        return array_merge([
            [
                'section',
                [],
                array_merge([
                    [
                        'h2',
                        $this->title
                    ]
                ], $onderdelenHTML)
            ]
        ], $siblingHTML);
    }
}