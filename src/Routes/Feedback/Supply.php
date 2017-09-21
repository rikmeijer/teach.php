<?php namespace rikmeijer\Teach\Routes\Feedback;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Handler;
use rikmeijer\Teach\Resources;

class Supply implements \pulledbits\Router\Matcher
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)/supply$#', $request->getUri()->getPath()) === 1;
    }

    public function makeHandler(ServerRequestInterface $request): Handler
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath(), $matches);

        switch ($request->getMethod()) {
            case 'GET':
                $query = $request->getQueryParams();
                return new class($this->resources, $this->resources->phpview('Feedback\\Supply'), $this->resources->responseFactory(), $query, $matches['contactmomentIdentifier']) implements Handler
                {
                    private $resources;
                    private $responseFactory;
                    private $phpview;
                    private $query;
                    private $contactmomentIdentifier;

                    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, array $query, string $contactmomentIdentifier)
                    {
                        /**
                         * @var Resources
                         */
                        $this->resources = $resources;
                        $this->responseFactory = $responseFactory;
                        $this->phpview = $phpview;
                        $this->contactmomentIdentifier = $contactmomentIdentifier;
                        $this->query = $query;
                    }

                    public function makeResponse(): ResponseInterface
                    {
                        $contactmoment = $this->resources->schema()->readFirst('contactmoment', [], ['id' => $this->contactmomentIdentifier]);

                        $ipRating = $contactmoment->fetchFirstByFkRatingContactmoment(['ipv4' => $_SERVER['REMOTE_ADDR']]);

                        $rating = null;
                        $explanation = '';
                        if ($ipRating->waarde !== null) {
                            $data = ['rating' => $ipRating->waarde, 'explanation' => $ipRating->inhoud];
                            $rating = $data['rating'];
                            $explanation = $data['explanation'] !== null ? $data['explanation'] : '';
                        }

                        if (array_key_exists('rating', $this->query)) {
                            $rating = $this->query['rating'];
                        }

                        $resources = $this->resources;
                        return $this->responseFactory->make200($this->phpview->capture('supply', ['rating' => $rating, 'explanation' => $explanation, 'contactmomentIdentifier' => $this->contactmomentIdentifier, 'star' => function (int $i, $rating) use ($resources) : string {
                            if ($rating === null) {
                                $data = $resources->readAssetUnstar();
                            } elseif ($i < $rating) {
                                $data = $resources->readAssetStar();
                            } else {
                                $data = $resources->readAssetUnstar();
                            }
                            return 'data:image/png;base64,' . base64_encode($data);
                        }, 'rateForm' => function (string $contactmomentIdentifier, $rating, string $explanation): void {
                            ?><h1>Hoeveel sterren?</h1><?php
                            for ($i = 0; $i < 5; $i++) {
                                ?><a href="<?= $this->url('/feedback/%s/supply?rating=%s', $contactmomentIdentifier, $i + 1); ?>">
                                <img
                                        src="<?= $this->star($i, $rating); ?>" width="100"/></a><?php
                            }
                            if ($rating !== null) {
                                $this->form("post", "Verzenden", '<h1>Waarom?</h1>
                        <input type="hidden" name="rating" value="' . $this->escape($rating) . '" />
                        <textarea rows="5" cols="75" name="explanation">' . $this->escape($explanation) . '</textarea>
                    ');
                            }
                        }]));
                    }
                };

            case 'POST':
                return new class($this->resources, $this->resources->phpview('Feedback'), $this->resources->responseFactory(), $request->getParsedBody(), $matches['contactmomentIdentifier']) implements Handler
                {
                    private $resources;
                    private $responseFactory;
                    private $phpview;
                    private $contactmomentIdentifier;
                    private $parsedBody;

                    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, array $parsedBody, string $contactmomentIdentifier)
                    {
                        $this->resources = $resources;
                        $this->responseFactory = $responseFactory;
                        $this->phpview = $phpview;
                        $this->contactmomentIdentifier = $contactmomentIdentifier;
                        $this->parsedBody = $parsedBody;
                    }

                    public function makeResponse(): ResponseInterface
                    {
                        $session = $this->resources->session();

                        $csrf_token = $session->getCsrfToken();
                        if ($csrf_token->isValid($this->parsedBody['__csrf_value']) === false) {
                            return $this->responseFactory->make403("This looks like a cross-site request forgery.");
                        } else {
                            $this->resources->schema()->executeProcedure('rate_contactmoment', [$this->contactmomentIdentifier, $_SERVER['REMOTE_ADDR'], $this->parsedBody['rating'], $this->parsedBody['explanation']]);
                            return $this->responseFactory->make201('Dankje!');
                        }
                    }
                };

            default:
                return $this->responseFactory->make405('Method not allowed');
        }

    }

}