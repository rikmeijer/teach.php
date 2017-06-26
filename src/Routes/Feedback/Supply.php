<?php namespace rikmeijer\Teach\Routes\Feedback;

class Supply implements \pulledbits\Router\Handler
{
    private $resources;
    private $phpview;

    public function __construct(\rikmeijer\Teach\Resources $resources) {
        $this->resources = $resources;
        $this->phpview = $this->resources->phpview(__DIR__ . DIRECTORY_SEPARATOR . str_replace(__NAMESPACE__ . NAMESPACE_SEPARATOR,"",__CLASS__));
    }

    public function handleRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        switch ($request->getMethod()) {
            case 'GET':
                return $this->handleGetRequest($request);
            case 'POST':
                return $this->handlePostRequest($request);
            default:
                return $this->resources->respond(405, 'Method not allowed');
        }
    }

    private function handleGetRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $schema = $this->resources->schema();

        $contactmoment = $schema->readFirst('contactmoment', [], ['id' => $request->getAttribute('contactmomentIdentifier')]);

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
        return $this->resources->respond(200, $this->phpview->capture('supply', ['rating' => $rating, 'explanation' => $explanation, 'contactmomentIdentifier' => $request->getAttribute('contactmomentIdentifier'), 'star' => function (int $i, $rating) use ($resources) : string {
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

    public function handlePostRequest(\Psr\Http\Message\RequestInterface $request, \rikmeijer\Teach\Resources $resources): \Psr\Http\Message\ResponseInterface
    {
        $schema = $this->resources->schema();
        $session = $this->resources->session();
        $payload = $request->getParsedBody();

        $csrf_token = $session->getCsrfToken();
        if ($csrf_token->isValid($payload['__csrf_value']) === false) {
            return $this->resources->respond(403, "This looks like a cross-site request forgery.");
        } else {
            $contactmoment = $schema->readFirst('contactmoment', [], ['id' => $request->getAttribute('contactmomentIdentifier')]);
            $rating = $contactmoment->fetchFirstByFkRatingContactmoment(['ipv4' => $_SERVER['REMOTE_ADDR']]);
            $rating->waarde = $payload['rating'];
            $rating->inhoud = $payload['explanation'];
            if ($rating->created_at === null) {
                $rating->created_at = date('Y-m-d H:i:s');
            }
            $rating->updated_at = date('Y-m-d H:i:s');
            return $this->resources->respond(201, 'Dankje!');
        }
    }
}