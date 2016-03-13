<?php
namespace Teach\Domain\Lesplan;

class Kern implements \Teach\Interactions\Interactable
{

    /**
     *
     * @var array
     */
    private $themas;

    public function __construct(array $themas)
    {
        $this->themas = $themas;
    }

    /**
     *
     * @param \Teach\Interactions\Web\Lesplan\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Lesplan\Factory $factory): \Teach\Interactions\Documentable
    {
        $themaCount = 0;
        $themas = [];
        foreach ($this->themas as $themaIdentifier => $themaDefinition) {
            $activiteiten = [];
            foreach ($themaDefinition as $activiteit) {
                $activiteiten[] = $activiteit->interact($factory);
            }
            $themas[] = $factory->createSection('Thema ' . (++ $themaCount) . ': ' . $themaIdentifier, $factory->createDocumentParts(...$activiteiten));
        }
        return $factory->createSection("Kern", $factory->createDocumentParts(...$themas));
    }
}