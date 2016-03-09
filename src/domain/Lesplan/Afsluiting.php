<?php
namespace Teach\Domain\Lesplan;

class Afsluiting implements \Teach\Interactions\Interactable
{

    /**
     *
     * @var array
     */
    private $huiswerk;

    /**
     *
     * @var array
     */
    private $evaluatie;

    /**
     *
     * @var array
     */
    private $slot;

    public function __construct(array $huiswerk, array $evaluatie, array $slot)
    {
        $this->huiswerk = $huiswerk;
        $this->evaluatie = $evaluatie;
        $this->slot = $slot;
    }

    /**
     *
     * @param \Teach\Interactions\Web\Lesplan\Factory $factory            
     * @return \Teach\Interactions\Presentable
     */
    public function interact(\Teach\Interactions\Web\Lesplan\Factory $factory): \Teach\Interactions\Presentable
    {
        return $factory->createAfsluiting($factory->createActiviteit("Huiswerk", $this->huiswerk), $factory->createActiviteit("Evaluatie", $this->evaluatie), $factory->createActiviteit("Pakkend slot", $this->slot));
    }
}