<?php

/*
 * public specific bootstrapper
 */
return function () {
    $applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    $resourceFactory = $applicationBootstrap();
    
    $databaseFactory = $resourceFactory['database'];
    
    return function ($contactmomentIdentifier) use ($databaseFactory) {
        $factory = new \Teach\Entities\Factory($databaseFactory());
        $contactmomentEntity = $factory->createContactmoment($contactmomentIdentifier);
        return $contactmomentEntity->createLesplan(new \Teach\Interactors\Web\Lesplan\Factory());
    };
};
