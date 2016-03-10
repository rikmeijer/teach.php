<?php
namespace Teach\Interactions\Web\Lesplan;

final class Fase implements \Teach\Interactions\Documentable
{
    /**
     * 
     * @var string
     */
    private $headerLevel;
    
    /**
     * 
     * @var string
     */
    private $title;

    /**
     *
     * @var \Teach\Interactions\Documentable[]
     */
    private $onderdelen = array();

    public function __construct($headerLevel, $title)
    {
        $this->headerLevel = $headerLevel;
        $this->title = $title;
    }

    public function addOnderdeel(\Teach\Interactions\Documentable $onderdeel)
    {
        $this->onderdelen[] = $onderdeel;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeader($this->headerLevel, $this->title));
        foreach ($this->onderdelen as $activiteit) {
            $section->appendHTML($activiteit->document($adapter));
        }
        return $section->render();
    }
}