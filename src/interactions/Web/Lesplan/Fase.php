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
     * @var \Teach\Interactions\Web\Document\Parts
     */
    private $parts;

    public function __construct($headerLevel, $title, \Teach\Interactions\Web\Document\Parts $parts)
    {
        $this->headerLevel = $headerLevel;
        $this->title = $title;
        $this->parts = $parts;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeader($this->headerLevel, $this->title));
        $section->appendHTML($this->parts->document($adapter));
        return $section->render();
    }
}