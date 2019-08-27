<?php


namespace rikmeijer\Teach\GUI;

use Aura\Router\Map;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\Beans\Module;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\GUI\Feedback\View;
use TheCodingMachine\TDBM\ResultIterator;

final class Index implements GUI
{
    /**
     * @var Directory
     */
    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $user = $bootstrap->resource('user');

        $this->phpviewDirectory = $bootstrap->resource('phpview');
        $this->phpviewDirectory->registerHelper('modules', function(TemplateInstance $templateInstance) : ResultIterator {
            return ($templateInstance->resource('dao')('Module'))->findAll();
        });
        $this->phpviewDirectory->registerHelper('getModuleContactmomenten', function(TemplateInstance $templateInstance, Module $module) use ($user) : ResultIterator {
            return $user->findContactmomentenByModule($module);
        });
        $this->phpviewDirectory->registerHelper('contactmomenten', function(TemplateInstance $templateInstance) use ($user) : ResultIterator
        {
            return $user->findContactmomentenToday();
        });
    }

    public function mapRoutes(Map $map): void
    {
        $map->get('index','/', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
            $view = new Index\Index($this->phpviewDirectory);
            return $view->handleRequest($request)->respond($response);
        });
    }
}
