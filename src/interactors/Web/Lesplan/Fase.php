<?php
namespace Teach\Interactors\Web\Lesplan;

final class Fase implements \Teach\Interactors\LayoutableInterface
{

    private $title;
    
    /**
     * 
     * @var \Teach\Interactors\LayoutableInterface[]
     */
    private $onderdelen = array();

    public function __construct($title)
    {
        $this->title = $title;
    }
    
    public function addOnderdeel(\Teach\Interactors\LayoutableInterface $onderdeel)
    {
        $this->onderdelen[] = $onderdeel;
    }

    /**
     *
     * @return array
     */
    public function generateLayout (\Teach\Interactors\LayoutFactoryInterface $factory)
    {
        $onderdelenHTML = [];
        foreach ($this->onderdelen as $onderdeel) {
            $onderdelenHTML = array_merge($onderdelenHTML, $onderdeel->generateLayout ($factory));
        }
        
        return [
            $factory->makeSection($factory->makeHeader2($this->title), $onderdelenHTML)
        ];
    }
}