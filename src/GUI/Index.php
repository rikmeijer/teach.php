<?php


namespace rikmeijer\Teach\GUI;

use Aura\Router\Map;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Bootstrap\Bootstrap;
use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\Beans\Module;
use rikmeijer\Teach\Beans\User;
use rikmeijer\Teach\GUI;
use TheCodingMachine\TDBM\ResultIterator;

final class Index implements GUI
{
    /**
     * @var Directory
     */
    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        /**
         * @var User
         */
        $user = $bootstrap->resource('currentuser');

        $this->phpviewDirectory = $bootstrap->resource('phpview');
        $this->phpviewDirectory->registerHelper(
            'modules',
            function (TemplateInstance $templateInstance): ResultIterator {
                return ($templateInstance->resource('dao')('Module'))->findAll();
            }
        );
        $this->phpviewDirectory->registerHelper(
            'getModuleContactmomenten',
            function (TemplateInstance $templateInstance, Module $module) use ($user) : ResultIterator {
                return $user->getContactmomentenByModule($module);
            }
        );
        $this->phpviewDirectory->registerHelper(
            'contactmomenten',
            function (TemplateInstance $templateInstance) use ($user) : ResultIterator {
                return $user->getContactmomentenToday();
            }
        );
    }

    public function mapRoutes(Map $map): void
    {
        $map->get(
            'index',
            '/',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                $view = new Index\Index($this->phpviewDirectory);
                return $view->handleRequest($request)->respond($response);
            }
        );
    }
}
