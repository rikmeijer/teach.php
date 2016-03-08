<?php
namespace Teach\Domain\Lesplan;

class Afsluiting implements \Teach\Interactors\InteractableInterface
{

    /**
     *
     * @var Factory
     */
    private $factory;

    /**
     *
     * @var string
     */
    private $huiswerkIdentifier;

    /**
     *
     * @var string
     */
    private $evaluatieIdentifier;

    /**
     *
     * @var string
     */
    private $slotIdentifier;

    public function __construct(\Teach\Domain\Factory $factory, string $huiswerkIdentifier = null, string $evaluatieIdentifier = null, string $slotIdentifier = null)
    {
        $this->factory = $factory;
        $this->huiswerkIdentifier = $huiswerkIdentifier;
        $this->evaluatieIdentifier = $evaluatieIdentifier;
        $this->slotIdentifier = $slotIdentifier;
    }

    /**
     * 
     * @param \Teach\Interactors\Web\Lesplan\Factory $factory
     * @return \Teach\Interactors\LayoutableInterface
     */
    public function interact(\Teach\Interactors\Web\Lesplan\Factory $factory): \Teach\Interactors\LayoutableInterface
    {
        return $factory->createAfsluiting(
            $factory->createActiviteit("Huiswerk", $this->factory->getActiviteit($this->huiswerkIdentifier)), 
            $factory->createActiviteit("Evaluatie", $this->factory->getActiviteit($this->evaluatieIdentifier)), 
            $factory->createActiviteit("Pakkend slot", $this->factory->getActiviteit($this->slotIdentifier))
        );
    }
}