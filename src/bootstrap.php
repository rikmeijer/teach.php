<?php
$environmentBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

interface ApplicationBootstrap
{
    public function handleRequest(array ...$globals): \Psr\Http\Message\ResponseInterface;

    public function sendResponse(\Psr\Http\Message\ResponseInterface $response);
}

return new class($environmentBootstrap) implements ApplicationBootstrap {

    /**
     *
     * @var \EnvironmentBootstrap
     */
    private $environment;

    public function __construct(\EnvironmentBootstrap $environmentBootstrap)
    {
        $this->environment = $environmentBootstrap;
    }

    public function handleRequest(array ...$globals): \Psr\Http\Message\ResponseInterface
    {
        $request = \Zend\Diactoros\ServerRequestFactory::fromGlobals(...$globals);
        
        $lesplanEntity = $this->environment->getDomainFactory()->createLesplan($_GET['contactmoment']);
        $interaction = new \Teach\Adapters\HTML();
        
        $response = new Zend\Diactoros\Response();
        $response->getBody()->write($lesplanEntity->document($interaction));
        $response->getBody()->rewind();
        return $response->withHeader('Content-Type', 'text/html');
    }
    
    public function sendResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        foreach ($response->getHeaders() as $name => $values) {
            header($name . ": " . implode(", ", $values));
        }
        $body = $response->getBody();
        print $body->getContents();
    }
};