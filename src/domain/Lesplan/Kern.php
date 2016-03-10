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
        $kern = $factory->createFase('2', "Kern");
        $themaCount = 0;
        foreach ($this->themas as $themaIdentifier => $themaDefinition) {
            $thema = $factory->createFase('3', 'Thema ' . (++ $themaCount) . ': ' . $themaIdentifier);
            foreach ($themaDefinition as $activiteitIdentifier => $activiteitDefinition) {
                $thema->addOnderdeel($factory->createActiviteit($activiteitIdentifier, $activiteitDefinition));
            }
            $kern->addOnderdeel($thema);
        }
        return $kern;
    }
}