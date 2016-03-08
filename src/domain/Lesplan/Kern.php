<?php
namespace Teach\Domain\Lesplan;

class Kern implements \Teach\Interactors\InteractableInterface
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
     * @param \Teach\Interactors\Web\Lesplan\Factory $factory
     * @return \Teach\Interactors\LayoutableInterface
     */
    public function interact(\Teach\Interactors\Web\Lesplan\Factory $factory): \Teach\Interactors\LayoutableInterface
    {
        $kern = $factory->createFase("Kern");
        $themaCount = 0;
        foreach ($this->themas as $themaIdentifier => $themaDefinition) {
            $thema = $factory->createThema('Thema ' . (++$themaCount) . ': ' . $themaIdentifier, $themaDefinition);
            $kern->addOnderdeel($thema);
        }
        return $kern;
    }
}