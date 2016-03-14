<?php
$environmentBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

interface ApplicationBootstrap
{

    public function startDocument(\Teach\Interactions\Documenter $adapter): \Teach\Interactions\Document;

    public function createInteractionWeb(): \Teach\Interactions\Web\Factory;

    public function getDomainFactory(): \Teach\Domain\Factory;
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
        
        $lesplanEntity = $this->getDomainFactory()->createLesplan($_GET['contactmoment']);
        $interaction = new \Teach\Interactions\Document\HTML();
        
        $response = new Zend\Diactoros\Response();
        $response->getBody()->write($interaction->makeDocument($lesplanEntity->document($interaction))
            ->render());
        $response->getBody()->rewind();
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     *
     * @return \Teach\Domain\Factory
     */
    public function getDomainFactory(): \Teach\Domain\Factory
    {
        return new \Teach\Domain\Factory($this->environment->getDatabase());
    }

    /**
     *
     * @return \Teach\Interactions\Web\Factory
     */
    public function createInteractionWeb(): \Teach\Interactions\Web\Factory
    {
        return new \Teach\Interactions\Web\Factory();
    }

    public function startDocument(\Teach\Interactions\Documenter $adapter): \Teach\Interactions\Document
    {
        return $this->environment->getInteractorFactory()->makeDocument($adapter);
    }
};