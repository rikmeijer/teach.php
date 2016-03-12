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
     * @var \Teach\Interactions\Documentable[]
     */
    private $onderdelen;

    public function __construct($title, $subtitle)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
    }
    
    public function addOnderdeel(\Teach\Interactions\Documentable $onderdeel)
    {
        $this->onderdelen[] = $onderdeel;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $lines = [];
        $lines[] = $adapter->makeFirstPage($this->title, $this->subtitle)->render();
        foreach ($this->onderdelen as $onderdeel) {
            $lines[] = $onderdeel->document($adapter);
        }
        return join("", $lines);
    }
}