<?php
namespace Teach\Domain\Lesplan;

class Afsluiting implements \Teach\Interactions\Interactable
{

    /**
     *
     * @var Activiteit
     */
    private $huiswerk;

    /**
     *
     * @var Activiteit
     */
    private $evaluatie;

    /**
     *
     * @var Activiteit
     */
    private $slot;

    public function __construct(Activiteit $huiswerk, Activiteit $evaluatie, Activiteit $slot)
    {
        $this->huiswerk = $huiswerk;
        $this->evaluatie = $evaluatie;
        $this->slot = $slot;
    }

    /**
     *
     * @param \Teach\Interactions\Web\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Factory $factory): \Teach\Interactions\Documentable
    {
        $parts = $factory->createDocumentParts($this->huiswerk->interact($factory), $this->evaluatie->interact($factory), $this->slot->interact($factory));
        return $factory->createSection("Afsluiting", $parts);
    }
}