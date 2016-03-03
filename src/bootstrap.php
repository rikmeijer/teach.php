<?php return new class {
    
    private $pdo;
    
    public function __construct() {
        $applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
        $resourceFactory = $applicationBootstrap();
        $this->pdo = $resourceFactory['database']();
    }
    
    public function getContactmoment($contactmomentIdentifier) {
        $factory = new \Teach\Entities\Factory($this->pdo);
        $contactmomentEntity = $factory->createContactmoment($contactmomentIdentifier);
        return $contactmomentEntity->createLesplan(new \Teach\Interactors\Web\Lesplan\Factory());
    }
};