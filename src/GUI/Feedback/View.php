<?php

namespace rikmeijer\Teach\GUI\Feedback;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\PHPviewEndPoint;

class View
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

    public function handleRequest(ServerRequestInterface $request): PHPviewEndPoint
    {
        return new PHPviewEndPoint(
            $this->phpviewDirectory->load(
                'feedback',
                ['contactmomentIdentifier' => $request->getAttribute('contactmomentIdentifier')]
            )
        );
    }
}
