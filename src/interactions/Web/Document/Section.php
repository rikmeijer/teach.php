<?php
namespace Teach\Interactions\Web\Document;

final class Section implements \Teach\Interactions\Documentable
{
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

    public function __construct($title, Parts $parts)
    {
        $this->title = $title;
        $this->parts = $parts;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $adapter->push();
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeaderNested($this->title));
        $section->appendHTML($this->parts->document($adapter));
        $adapter->pop();
        return $section->render();
    }
}