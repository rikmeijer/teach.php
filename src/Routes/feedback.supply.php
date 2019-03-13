<?php return function($bootstrap) {
    $session = $bootstrap->session();
    $schema = $bootstrap->schema();
    $phpviewDirectoryFactory = $bootstrap->phpviewDirectoryFactory($session);

    $feedbackGUI = new \rikmeijer\Teach\GUI\Feedback($session, $schema);

    return function(\Psr\Http\Message\ServerRequestInterface $request) use ($feedbackGUI, $phpviewDirectoryFactory): \pulledbits\Router\RouteEndPoint {
        $phpviewDirectory = $phpviewDirectoryFactory->make('feedback');
        $contactmoment = $feedbackGUI->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
        if ($contactmoment->id === null) {
            return \pulledbits\Router\ErrorFactory::makeInstance('404');
        }

        switch ($request->getMethod()) {
            case 'GET':
                $ipRating = $contactmoment->findRatingByIP(($request->getServerParams())['REMOTE_ADDR']);

                $query = $request->getQueryParams();
                if (array_key_exists('rating', $query)) {
                    $rating = $query['rating'];
                } else {
                    $rating = $ipRating->waarde;
                }

                return new \rikmeijer\Teach\PHPviewEndPoint($phpviewDirectory->load('supply', ['rating' => $rating, 'explanation' => $ipRating->inhoud]));

            case 'POST':
                $parsedBody = $request->getParsedBody();
                if ($feedbackGUI->verifyCSRFToken($parsedBody['__csrf_value']) === false) {
                    return ErrorFactory::makeInstance('403');
                }
                $contactmoment->rate($_SERVER['REMOTE_ADDR'], $parsedBody['rating'], $parsedBody['explanation']);
                return new \rikmeijer\Teach\PHPviewEndPoint($phpviewDirectory->load('processed'));

            default:
                return \pulledbits\Router\ErrorFactory::makeInstance('405');
        }
    };
};
