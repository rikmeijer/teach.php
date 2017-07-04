<?php namespace rikmeijer\Teach\Routes\Feedback;

class Supply implements \pulledbits\Router\Handler
{
    private $resources;
    private $responseFactory;
    private $phpview;
    private $schema;

    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview, \rikmeijer\Teach\Response $responseFactory)
    {
        $this->resources = $resources;
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
        $this->schema = $resources->schema();
    }

    public function handleRequest(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        switch ($request->getMethod()) {
            case 'GET':
                return $this->handleGetRequest($request);
            case 'POST':
                return $this->handlePostRequest($request);
            default:
                return $this->responseFactory->make(405, 'Method not allowed');
        }
    }

    private function handleGetRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $contactmoment = $this->schema->readFirst('contactmoment', [], ['id' => $request->getAttribute('contactmomentIdentifier')]);

        $ipRating = $contactmoment->fetchFirstByFkRatingContactmoment(['ipv4' => $_SERVER['REMOTE_ADDR']]);

        $rating = null;
        $explanation = '';
        if ($ipRating->waarde !== null) {
            $data = ['rating' => $ipRating->waarde, 'explanation' => $ipRating->inhoud];
            $rating = $data['rating'];
            $explanation = $data['explanation'] !== null ? $data['explanation'] : '';
        }

        $query = $request->getQueryParams();

        if (array_key_exists('rating', $query)) {
            $rating = $query['rating'];
        }

        $resources = $this->resources;
        return $this->responseFactory->make(200, $this->phpview->capture('supply', ['rating' => $rating, 'explanation' => $explanation, 'contactmomentIdentifier' => $request->getAttribute('contactmomentIdentifier'), 'star' => function (int $i, $rating) use ($resources) : string {
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

    public function handlePostRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $session = $this->resources->session();
        $payload = $request->getParsedBody();

        $csrf_token = $session->getCsrfToken();
        if ($csrf_token->isValid($payload['__csrf_value']) === false) {
            return $this->responseFactory->make(403, "This looks like a cross-site request forgery.");
        } else {
            $this->schema->executeProcedure('rate_contactmoment', [$request->getAttribute('contactmomentIdentifier'), $_SERVER['REMOTE_ADDR'], $payload['rating'], $payload['explanation']]);
            return $this->responseFactory->make(201, 'Dankje!');
        }
    }
}