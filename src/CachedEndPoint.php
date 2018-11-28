<?php
namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\RouteEndPointDecorator;

class CachedEndPoint extends RouteEndPointDecorator
{

    private $lastModified;
    private $eTag;

    public function __construct(RouteEndPoint $wrappedEndPoint, \DateTime $lastModified, string $eTag)
    {
        parent::__construct($wrappedEndPoint);
        $this->lastModified = $lastModified;
        $this->eTag = $eTag;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return parent::respond($psrResponse
            ->withHeader('Last-Modified', $this->lastModified->format(DATE_RFC7231))
            ->withHeader('Etag', $this->eTag)
            ->withHeader('Cache-Control', 'public')
        );
    }
}