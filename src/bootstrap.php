<?php

/*
 * public specific bootstrapper
 */
return function () {
    $applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    $resourceFactory = $applicationBootstrap();
    
    return new class($resourceFactory['database']()) {
        
        /**
         * 
         * @var \PDO
         */
        private $pdo;
        
        public function __construct(\PDO $pdo) {
            $this->pdo = $pdo;
        }
        
        public function getContactmoment($contactmomentIdentifier) {
            $factory = new \Teach\Entities\Factory($this->pdo);
            $contactmomentEntity = $factory->createContactmoment($contactmomentIdentifier);
            return $contactmomentEntity->createLesplan(new \Teach\Interactors\Web\Lesplan\Factory());
        }
    };
};
