<?php
namespace Teach\Adapters\Web\Lesplan;

use Teach\Adapters\HTML\DummyLayout;
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
        $this->sibling = new DummyLayout();
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
        ], $this->sibling->generateHTMLLayout());
    }
}