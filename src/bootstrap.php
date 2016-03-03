<?php
$environmentBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

interface ApplicationBootstrap {
    public function getContactmoment($contactmomentIdentifier): \Teach\Interactors\LayoutableInterface;
    public function getEntitiesFactory(): \Teach\Entities\Factory;
}

return new class($environmentBootstrap) implements ApplicationBootstrap {
    
    /**
     * 
     * @var \EnvironmentBootstrap
     */
    private $environment;
    
    public function __construct(\EnvironmentBootstrap $environmentBootstrap) {
        $this->environment = $environmentBootstrap;
    }
    
    public function getEntitiesFactory() {
        return new \Teach\Entities\Factory($this->environment->getDatabase());
    }
    
    public function getContactmoment($contactmomentIdentifier): \Teach\Interactors\LayoutableInterface {
        return $this->getEntitiesFactory()->createContactmoment($contactmomentIdentifier)->createLesplan(new \Teach\Interactors\Web\Lesplan\Factory());
    }
};