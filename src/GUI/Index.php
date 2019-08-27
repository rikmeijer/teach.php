<?php


namespace rikmeijer\Teach\GUI;

use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\Beans\Module;
use rikmeijer\Teach\GUI;
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

    public function createRoutes() : array
    {
        return ['/$' => new Index\Index($this->phpviewDirectory)];
    }
}
