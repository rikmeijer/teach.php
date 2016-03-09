<?php
namespace Teach\Interactors\Web\Lesplan;

final class Fase implements \Teach\Interactors\Presentable
{

    private $title;
    
    /**
     * 
     * @var \Teach\Interactors\Presentable[]
     */
    private $onderdelen = array();

    public function __construct($title)
    {
        $this->title = $title;
    }
    
    public function addOnderdeel(\Teach\Interactors\Presentable $onderdeel)
    {
        $this->onderdelen[] = $onderdeel;
    }

    public function present(\Teach\Interactors\Documenter $adapter): string
    {
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeader('2', $this->title));
        foreach ($this->onderdelen as $activiteit) {
            $section->appendHTML($activiteit->present($adapter));
        }
        return $section->render();
    }
}