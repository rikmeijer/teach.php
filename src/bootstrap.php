<?php
$environmentBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

interface ApplicationBootstrap
{

    public function createInteraction(\Teach\Interactors\InteractableInterface $interactable): \Teach\Interactors\LayoutableInterface;

    public function getDomainFactory(): \Teach\Domain\Factory;
}

return new class($environmentBootstrap) implements ApplicationBootstrap {

    /**
     *
     * @var \EnvironmentBootstrap
     */
    private $environment;

    public function __construct(\EnvironmentBootstrap $environmentBootstrap)
    {
        $this->environment = $environmentBootstrap;
    }

    /**
     *
     * @return \Teach\Domain\Factory
     */
    public function getDomainFactory(): \Teach\Domain\Factory
    {
        return new \Teach\Domain\Factory($this->environment->getDatabase());
    }

    /**
     * 
     * @return \Teach\Interactors\InteractionFactory
     */
    private function getInteractionFactory(): \Teach\Interactors\InteractionFactory
    {
        return new \Teach\Interactors\InteractionFactory();
    }

    /**
     * 
     * @param \Teach\Interactors\InteractableInterface $interactable
     * @return \Teach\Interactors\LayoutableInterface
     */
    public function createInteraction(\Teach\Interactors\InteractableInterface $interactable): \Teach\Interactors\LayoutableInterface
    {
        return $this->getInteractionFactory()->createInteraction($interactable);
    }
};