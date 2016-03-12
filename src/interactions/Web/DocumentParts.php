<?php
namespace Teach\Interactions\Web;

final class DocumentParts implements \Teach\Interactions\Documentable
{
    
    /**
     * 
     * @var \Teach\Interactions\Documentable[]
     */
    private $onderdelen;

    public function __construct(\Teach\Interactions\Documentable ...$onderdelen)
    {
        $this->onderdelen = $onderdelen;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $lines = [];
        foreach ($this->onderdelen as $onderdeel) {
            $lines[] = $onderdeel->document($adapter);
        }
        return join("", $lines);
    }
}