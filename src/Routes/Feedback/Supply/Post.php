<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

class Post implements \rikmeijer\Teach\Route {
    public function __invoke(
        \Psr\Http\Message\RequestInterface $request,
        \rikmeijer\Teach\Resources $resources
    ): \Psr\Http\Message\ResponseInterface {
        $schema = $resources->schema();
        $session = $resources->session();
        $payload = $request->getParsedBody();

        $csrf_token = $session->getCsrfToken();
        if ($csrf_token->isValid($payload['__csrf_value']) === false) {
            return $resources->respond(403, "This looks like a cross-site request forgery.");
        } else {
            $contactmoment = $schema->readFirst('contactmoment', [],
                ['id' => $request->getAttribute('contactmomentIdentifier')]);
            $rating = $contactmoment->fetchFirstByFkRatingContactmoment([
                'ipv4' => $_SERVER['REMOTE_ADDR']
            ]);
            $rating->waarde = $payload['rating'];
            $rating->inhoud = $payload['explanation'];
            if ($rating->created_at === null) {
                $rating->created_at = date('Y-m-d H:i:s');
            }
            $rating->updated_at = date('Y-m-d H:i:s');
            return $resources->respond(201, 'Dankje!');
        }
    }
}