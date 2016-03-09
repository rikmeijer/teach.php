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
     * @return \Teach\Interactions\Presentable
     */
    public function interact(\Teach\Interactions\Web\Lesplan\Factory $factory): \Teach\Interactions\Presentable
    {
        $kern = $factory->createFase("Kern");
        $themaCount = 0;
        foreach ($this->themas as $themaIdentifier => $themaDefinition) {
            $thema = $factory->createThema('Thema ' . (++ $themaCount) . ': ' . $themaIdentifier, $themaDefinition);
            $kern->addOnderdeel($thema);
        }
        return $kern;
    }
}