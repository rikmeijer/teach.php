<?php return new class implements \rikmeijer\Teach\Route {
    public function __invoke(\Psr\Http\Message\RequestInterface $request, \rikmeijer\Teach\Resources $resources) : \Psr\Http\Message\ResponseInterface {
        return $resources->respond(200, $resources->phpview('contactmoment/import', [
            'importForm' => function() : void {
                $model = 'ICS URL: <input type="text" name="url" />';

                $this->form("post", "Importeren", $model);
            }
        ]));
    }
};