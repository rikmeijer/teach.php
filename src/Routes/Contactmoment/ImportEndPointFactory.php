<?php namespace rikmeijer\Teach\Routes\Contactmoment;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Contactmoment\Import\Form;
use rikmeijer\Teach\Routes\Contactmoment\Import\Process;
use rikmeijer\Teach\User;

class ImportEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $user;
    private $phpviewDirectory;

    public function __construct(User $user, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->user = $user;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('contactmoment');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/contactmoment/import$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request) : RouteEndPoint
    {
        switch ($request->getMethod()) {
            case 'GET':
                return new Form($this->phpviewDirectory->load('import', [
                    'importForm' => function (): void {
                        $this->form("post", "Importeren", 'rooster.avans.nl');
                    }
                ]));

            case 'POST':
                return new Process($this->phpviewDirectory->load('imported', [
                    "numberImported" => $this->user->importCalendarEvents()
                ]));

            default:
                return ErrorFactory::makeInstance('405');
        }

    }
}