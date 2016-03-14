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

    public function document(\Teach\Domain\Documenter $documenter): string
    {
        $documenter->push();
        $section = $documenter->makeSection();
        $section->append($documenter->makeHeaderNested("Afsluiting"));
        $section->appendHTML($this->huiswerk->document($documenter), $this->evaluatie->document($documenter), $this->slot->document($documenter));
        $documenter->pop();
        return $section->render();
    }
}