<?php namespace rikmeijer\Teach\Routes\Index;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Factory implements RouteEndPoint
{
    private $schema;
    private $phpview;

    public function __construct(Schema $schema, \pulledbits\View\Directory $phpview)
    {
        $this->schema = $schema;
        $this->phpview = $phpview;
    }

    public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
    {
        $modules = [];
        foreach ($this->schema->read('module', [], []) as $module) {
            $module->contains(['contactmomenten' => $this->schema->read("contactmoment_module", [], ["module_id" => $module->id])]);
            $modules[] = $module;
        }

        return $psrResponseFactory->make('200', $this->phpview->load('welcome')->prepare([
            'modules' => $modules,
            'contactmomenten' => $this->schema->read('contactmoment_vandaag', [], [])
        ])->capture());
    }
}