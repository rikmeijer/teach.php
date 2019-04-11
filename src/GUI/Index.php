<?php


namespace rikmeijer\Teach\GUI;

use pulledbits\Router\Route;
use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\GUI;

final class Index implements GUI
{
    /**
     * @var Directory
     */
    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $this->phpviewDirectory = $bootstrap->resource('phpview');
        $this->phpviewDirectory->registerHelper('modules', function(TemplateInstance $templateInstance) : array
        {
            $modules = [];
            $userId = $templateInstance->resource('user')->uid;
            $schema = $templateInstance->resource('database');
            foreach ($schema->read('module', [], []) as $module) {
                $modulecontactmomenten = Contactmoment::readByModuleName($schema, $userId, $module->naam);

                if (count($modulecontactmomenten) > 0) {
                    $module->contains(['contactmomenten' => $modulecontactmomenten]);
                    $module->bind(
                        'retrieveRating',
                        function () {
                            $ratings = [];
                            foreach ($this->contactmomenten as $modulecontactmoment) {
                                if ($modulecontactmoment->retrieveRating() > 0) {
                                    $ratings[] = $modulecontactmoment->retrieveRating();
                                }
                            }
                            $numericRatings = array_filter($ratings, 'is_numeric');
                            if (count($numericRatings) === 0) {
                                return 0;
                            }
                            return round(array_sum($numericRatings) / count($numericRatings), 1);
                        }
                    );

                    $modules[] = $module;
                }
            }
            return $modules;
        });
        $this->phpviewDirectory->registerHelper('contactmomenten', function(TemplateInstance $templateInstance) : array
        {
            return Contactmoment::readVandaag($templateInstance->resource('database'), $templateInstance->resource('user')->uid);
        });
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('/$', new Index\Index($this->phpviewDirectory));
    }
}
