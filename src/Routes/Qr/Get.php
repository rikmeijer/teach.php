<?php namespace rikmeijer\Teach\Routes\Qr;

class Get implements \rikmeijer\Teach\Route {
    public function __invoke(
        \Psr\Http\Message\RequestInterface $request,
        \rikmeijer\Teach\Resources $resources
    ): \Psr\Http\Message\ResponseInterface {
        $query = $request->getQueryParams();
        if (array_key_exists('data', $query) === false) {
            return $resources->respond(400, 'Query incomplete');
        } elseif ($query['data'] === null) {
            return $resources->respond(400, 'Query data incomplete');
        } else {
            return $resources->respondWithHeaders(200, ['Content-Type' => 'image/png'],
                $resources->phpview('qr', [
                    'data' => $query['data']
                ]));
        }
    }
}