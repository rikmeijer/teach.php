<?php namespace rikmeijer\Teach\Routes\Feedback;

use Aura\Session\CsrfToken;
use Aura\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;
use rikmeijer\Teach\Resources;

class Supply implements \pulledbits\Router\ResponseFactoryFactory
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

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath(), $matches);

        $responseFactory = $this->resources->responseFactory();

        switch ($request->getMethod()) {
            case 'GET':
                $phpview = $this->resources->phpview('Feedback\\Supply');
                $query = $request->getQueryParams();
                $contactmoment = $this->resources->schema()->readFirst('contactmoment', [], ['id' => $matches['contactmomentIdentifier']]);
                $assets = [
                        'star' => $this->resources->readAssetStar(),
                    'unstar' => $this->resources->readAssetUnstar()
                ];
                return new class($contactmoment, $phpview, $responseFactory, $assets, $query) implements ResponseFactory
                {
                    private $contactmoment;
                    private $responseFactory;
                    private $phpview;
                    private $assets;
                    private $query;

                    public function __construct( Record $contactmoment, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, array $assets, array $query)
                    {
                        $this->contactmoment = $contactmoment;
                        $this->responseFactory = $responseFactory;
                        $this->phpview = $phpview;
                        $this->assets = $assets;
                        $this->query = $query;
                    }

                    public function makeResponse(): ResponseInterface
                    {

                        $ipRating = $this->contactmoment->fetchFirstByFkRatingContactmoment(['ipv4' => $_SERVER['REMOTE_ADDR']]);

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

                        $assets = $this->assets;
                        return $this->responseFactory->make200($this->phpview->capture('supply', [
                                'rating' => $rating,
                                'explanation' => $explanation,
                                'contactmomentIdentifier' => $this->contactmoment->id,
                                'star' => function (int $i, $rating) use ($assets) : string {
                                    $data = $assets['unstar'];
                                    if ($i < $rating) {
                                        $data = $assets['star'];
                                    }
                                    return 'data:image/png;base64,' . base64_encode($data);
                                }
                        ]));
                    }
                };

            case 'POST':
                $resources = $this->resources;
                $csrf_token = $this->resources->session()->getCsrfToken();
                $schema = $this->resources->schema();
                return new class($csrf_token, $schema, $responseFactory, $request->getParsedBody(), $matches['contactmomentIdentifier']) implements ResponseFactory
                {
                    private $csrf_token;
                    private $schema;
                    private $responseFactory;
                    private $contactmomentIdentifier;
                    private $parsedBody;

                    public function __construct(CsrfToken $csrf_token, Schema $schema, \pulledbits\Response\Factory $responseFactory, array $parsedBody, string $contactmomentIdentifier)
                    {
                        $this->csrf_token = $csrf_token;
                        $this->schema = $schema;
                        $this->responseFactory = $responseFactory;
                        $this->contactmomentIdentifier = $contactmomentIdentifier;
                        $this->parsedBody = $parsedBody;
                    }

                    public function makeResponse(): ResponseInterface
                    {
                        if ($this->csrf_token->isValid($this->parsedBody['__csrf_value']) === false) {
                            return $this->responseFactory->make403("This looks like a cross-site request forgery.");
                        } else {
                            $this->schema->executeProcedure('rate_contactmoment', [$this->contactmomentIdentifier, $_SERVER['REMOTE_ADDR'], $this->parsedBody['rating'], $this->parsedBody['explanation']]);
                            return $this->responseFactory->make201('Dankje!');
                        }
                    }
                };

            default:
                return $responseFactory->make405('Method not allowed');
        }

    }

}