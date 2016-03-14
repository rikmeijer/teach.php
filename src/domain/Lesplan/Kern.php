<?php
namespace Teach\Domain\Lesplan;

class Kern implements \Teach\Domain\Documentable
{

    /**
     *
     * @var Thema[]
     */
    private $themas;

    public function __construct(array $themas)
    {
        $this->themas = $themas;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $adapter->push();
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeaderNested("Kern"));
        foreach ($this->themas as $thema) {
            $section->appendHTML($thema->document($adapter));
        }
        $adapter->pop();
        return $section->render();
    }
}