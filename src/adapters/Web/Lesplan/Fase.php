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

    public function __construct($title)
    {
        $this->title = $title;
    }
    
    public function addOnderdeel(\Teach\Adapters\HTML\LayoutableInterface $onderdeel)
    {
        $this->onderdelen[] = $onderdeel;
    }

    /**
     *
     * @return array
     */
    public function generateLayout (\Teach\Adapters\LayoutFactoryInterface $factory)
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