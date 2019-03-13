<?php


namespace rikmeijer\Teach\GUI;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\PHPviewEndPoint;
use rikmeijer\Teach\SSO;

final class Index
{
    private $server;
    private $schema;

    public function __construct(SSO $server, Schema $schema)
    {
        $this->server = $server;
        $this->schema = $schema;
    }

    static function bootstrap(\pulledbits\Router\Router $router, \rikmeijer\Teach\Bootstrap $bootstrap) : void {
        $router->addRoute('^/$', self::view($bootstrap));
    }

    public static function view(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $server = $bootstrap->sso();
        $schema = $bootstrap->schema();

        $phpviewDirectory = $bootstrap->phpviewDirectoryFactory()->make('');

        $indexGUI = new self($server, $schema);

        return function(ServerRequestInterface $request) use ($indexGUI, $phpviewDirectory): RouteEndPoint
        {
            return new PHPviewEndPoint($phpviewDirectory->load('welcome', [
                'modules' => $indexGUI->retrieveModules(),
                'contactmomenten' => $indexGUI->retrieveContactmomenten()
            ]));
        };
    }

    public function retrieveModules(): array
    {
        $modules = [];
        foreach ($this->schema->read('module', [], []) as $module) {
            $modulecontactmomenten = Contactmoment::readByModuleName($this->schema, $this->server->getUserDetails()->uid, $module->naam);

            if (count($modulecontactmomenten) > 0) {
                $module->contains(['contactmomenten' => $modulecontactmomenten]);
                $module->bind('retrieveRating', function () {
                    $ratings = [];
                    foreach ($this->contactmomenten as $modulecontactmoment) {
                        $ratings[] = $modulecontactmoment->retrieveRating();
                    }
                    $numericRatings = array_filter($ratings, 'is_numeric');
                    if (count($numericRatings) === 0) {
                        return null;
                    }
                    return array_sum($numericRatings) / count($numericRatings);
                });

                $modules[] = $module;
            }
        }
        return $modules;
    }

    public function retrieveContactmomenten() {
        return Contactmoment::readVandaag($this->schema, $this->server->getUserDetails()->uid);
    }
}