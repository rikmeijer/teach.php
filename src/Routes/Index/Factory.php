<?php namespace rikmeijer\Teach\Routes\Index;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;

class Factory implements ResponseFactory
{
    private $schema;
    private $responseFactory;
    private $phpview;

    public function __construct(Schema $schema, \pulledbits\View\Directory $phpview, \pulledbits\Response\Factory $responseFactory)
    {
        $this->schema = $schema;
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
    }

    public function makeResponse(): ResponseInterface
    {
        $modules = [];
        foreach ($this->schema->read('module', [], []) as $module) {
            $module->contains(['contactmomenten' => $this->schema->read("contactmoment_module", [], ["module_id" => $module->id])]);
            $modules[] = $module;
        }

        return $this->responseFactory->make200($this->phpview->load('welcome')->prepare([
            'modules' => $modules,
            'contactmomenten' => $this->schema->read('contactmoment_vandaag', [], [])
        ])->capture());
    }
}