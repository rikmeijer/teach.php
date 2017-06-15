<?php namespace rikmeijer\Teach\Routes\Index;

class Get implements \rikmeijer\Teach\Route
{
    public function __invoke(
        \Psr\Http\Message\RequestInterface $request,
        \rikmeijer\Teach\Resources $resources
    ): \Psr\Http\Message\ResponseInterface {
        $schema = $resources->schema();
        return $resources->respond(200, $resources->phpview(__DIR__)->capture('welcome', [
            'modules' => $schema->read('module', [], []),
            'contactmomenten' => $schema->read('contactmoment_vandaag', [], [])
        ]));
    }
}