<?php
$environmentBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

interface ApplicationBootstrap
{

    public function getContactmoment($contactmomentIdentifier): \Teach\Interactors\LayoutableInterface;

    public function getEntitiesFactory(): \Teach\Entities\Factory;
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
     * @return \Teach\Entities\Factory
     */
    public function getEntitiesFactory(): \Teach\Entities\Factory
    {
        return new \Teach\Entities\Factory($this->environment->getDatabase());
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