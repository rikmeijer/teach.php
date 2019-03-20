<?php


namespace rikmeijer\Teach\GUI\Rating;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\CachedEndPoint;
use rikmeijer\Teach\ImagePngEndPoint;
use rikmeijer\Teach\PHPviewEndPoint;
use SebastianBergmann\CodeCoverage\Node\Directory;

class Visualize implements Route
{
    private $gui;
    private $phpviewDirectory;

    public function __construct(\rikmeijer\Teach\GUI\Rating $gui, Directory $phpviewDirectory)
    {
        $this->gui = $gui;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(ServerRequestInterface $request): RouteEndPoint
    {
        if ($request->getAttribute('value') === 'N') {
            $waarde = null;
        } else {
            $waarde = $request->getAttribute('value');
        }
        $eTag = md5($waarde . '500' . '100' . '5');
        $phpview = new PHPviewEndPoint($this->phpviewDirectory->load('rating', [
            'ratingwaarde' => $waarde,
            'ratingWidth' => 500,
            'ratingHeight' => 100,
            'repetition' => 5,
            'star' => $this->gui->readImage('star.png'),
            'unstar' => $this->gui->readImage('unstar.png'),
            'nostar' => $this->gui->readImage('nostar.png')
        ]));
        return new CachedEndPoint(new ImagePngEndPoint($phpview), $this->gui->eTag($eTag), $eTag);
    }
}
