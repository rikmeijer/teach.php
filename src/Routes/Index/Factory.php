<?php namespace rikmeijer\Teach\Routes\Index;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\User;

class Factory implements RouteEndPoint
{
    private $schema;
    private $user;
    private $phpview;

    public function __construct(Schema $schema, User $user, \pulledbits\View\Template $phpview)
    {
        $this->schema = $schema;
        $this->user = $user;
        $this->phpview = $phpview;
    }

    public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
    {
        $modules = [];
        foreach ($this->schema->read('module', [], []) as $module) {
            $modulecontactmomenten = $this->user->retrieveModulecontactmomenten($module->id);
            if (count($modulecontactmomenten) > 0) {
                $module->contains(['contactmomenten' => $modulecontactmomenten]);
                $modules[] = $module;
            }
        }

        return $psrResponseFactory->makeWithTemplate('200', $this->phpview->prepare([
            'modules' => $modules,
            'contactmomenten' => $this->user->retrieveModulecontactmomentenToday()
        ]));
    }
}