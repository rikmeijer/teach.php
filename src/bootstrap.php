<?php
$environmentBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

interface ApplicationBootstrap
{

    public function startHTMLDocument(): \Teach\Interactions\Document;

    public function createInteractionWeb(): \Teach\Interactions\Web\Lesplan\Factory;

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
     * @return \Teach\Interactions\Web\Lesplan\Factory
     */
    public function createInteractionWeb(): \Teach\Interactions\Web\Lesplan\Factory
    {
        return new \Teach\Interactions\Web\Lesplan\Factory();
    }

    public function startHTMLDocument(): \Teach\Interactions\Document
    {
        return $this->environment->getInteractorFactory()->makeHTMLDocument();
    }
};