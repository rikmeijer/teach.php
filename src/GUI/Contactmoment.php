<?php
namespace rikmeijer\Teach\GUI;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPviewEndPoint;

class Contactmoment
{

    /**
     * Contactmoment constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
    }

    public static function import(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $user = $bootstrap->userForToken();
        $phpviewDirectory = $bootstrap->phpviewDirectoryFactory()->make('contactmoment');

        return function(ServerRequestInterface $request) use ($user, $phpviewDirectory) : RouteEndPoint
        {
            switch ($request->getMethod()) {
                case 'GET':
                    return new PHPviewEndPoint($phpviewDirectory->load('import', [
                        'importForm' => function (): void {
                            $this->form("post", "Importeren", 'rooster.avans.nl');
                        }
                    ]));

                case 'POST':
                    return new PHPviewEndPoint($phpviewDirectory->load('imported', [
                        "numberImported" => $user->importCalendarEvents()
                    ]));

                default:
                    return ErrorFactory::makeInstance('405');
            }

        };
    }
}