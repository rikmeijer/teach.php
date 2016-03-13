<?php
namespace Teach\Domain\Lesplan;

class Kern implements \Teach\Interactions\Interactable
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
}