<?php
namespace Teach\Domain\Lesplan;

class Kern implements \Teach\Interactions\Interactable, \Teach\Interactions\Documentable
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

    /**
     *
     * @param \Teach\Interactions\Web\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Factory $factory): \Teach\Interactions\Documentable
    {
        $themas = [];
        foreach ($this->themas as $thema) {
            $themas[] = $thema->interact($factory);
        }
        return $factory->createSection("Kern", $factory->createDocumentParts(...$themas));
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