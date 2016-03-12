<?php
namespace Teach\Interactions\Web;

final class Document implements \Teach\Interactions\Documentable
{
    /**
     *
     * @var string
     */
    private $title;

    /**
     *
     * @var string
     */
    private $subtitle;
    
    /**
     * 
     * @var Document\Parts
     */
    private $parts;

    public function __construct($title, $subtitle, Document\Parts $parts)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->parts = $parts;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $lines = [];
        $lines[] = $adapter->makeFirstPage($this->title, $this->subtitle)->render();
        $lines[] = $this->parts->document($adapter);
        return join("", $lines);
    }
}