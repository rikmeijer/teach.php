<?php return function($bootstrap) {
    $session = $bootstrap->session();
    $schema = $bootstrap->schema();
    $phpviewDirectoryFactory = $bootstrap->phpviewDirectoryFactory();
    $feedbackGUI = new \rikmeijer\Teach\GUI\Feedback($session, $schema);

    return function(\Psr\Http\Message\ServerRequestInterface $request) use ($feedbackGUI, $phpviewDirectoryFactory): \pulledbits\Router\RouteEndPoint {
        $phpviewDirectory = $phpviewDirectoryFactory->make('');

        $contactmoment = $feedbackGUI->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
        if ($contactmoment->id === null) {
            return \pulledbits\Router\ErrorFactory::makeInstance(404);
        }
        return new \rikmeijer\Teach\PHPviewEndPoint($phpviewDirectory->load('feedback', [
            'contactmoment' => $contactmoment
        ]));
    };
};
