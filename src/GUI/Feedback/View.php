<?php

namespace rikmeijer\Teach\GUI\Feedback;

use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;

class View implements Route
{
    private $phpviewDirectory;

    public function __construct(Directory $phpviewDirectory)
    {
        $this->phpviewDirectory = $phpviewDirectory;
        $this->phpviewDirectory->registerHelper(
            'feedbackSupplyURL',
            function (TemplateInstance $templateInstance, string $contactmomentIdentifier): string {
                return $templateInstance->url('/feedback/%s/supply', $contactmomentIdentifier);
            }
        );
    }

    public function handleRequest(\Psr\Http\Message\ServerRequestInterface $request): RouteEndPoint
    {
        return new \rikmeijer\Teach\PHPviewEndPoint(
            $this->phpviewDirectory->load(
                'feedback',
                ['contactmomentIdentifier' => $request->getAttribute('contactmomentIdentifier')]
            )
        );
    }
}
