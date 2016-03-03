<?php
$environmentBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

interface ApplicationBootstrap {
    public function getContactmoment($contactmomentIdentifier): \Teach\Interactors\LayoutableInterface;
}

return new class($environmentBootstrap) implements ApplicationBootstrap {
    
    private $pdo;
    
    public function __construct(\EnvironmentBootstrap $environmentBootstrap) {
        $this->pdo = $environmentBootstrap->getDatabase();
    }
    
    public function getContactmoment($contactmomentIdentifier): \Teach\Interactors\LayoutableInterface {
        $factory = new \Teach\Entities\Factory($this->pdo);
        $contactmomentEntity = $factory->createContactmoment($contactmomentIdentifier);
        return $contactmomentEntity->createLesplan(new \Teach\Interactors\Web\Lesplan\Factory());
    }
};