<?php
namespace Teach\Domain\Lesplan;

class Afsluiting implements \Teach\Interactions\Interactable, \Teach\Interactions\Documentable
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

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $adapter->push();
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeaderNested("Afsluiting"));
        $section->appendHTML($this->huiswerk->document($adapter), $this->evaluatie->document($adapter), $this->slot->document($adapter));
        $adapter->pop();
        return $section->render();
    }
}