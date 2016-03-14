<?php
namespace Teach\Domain\Lesplan;

class Afsluiting implements \Teach\Domain\Documentable
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

    public function document(\Teach\Domain\Documenter $adapter): string
    {
        $adapter->push();
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeaderNested("Afsluiting"));
        $section->appendHTML($this->huiswerk->document($adapter), $this->evaluatie->document($adapter), $this->slot->document($adapter));
        $adapter->pop();
        return $section->render();
    }
}