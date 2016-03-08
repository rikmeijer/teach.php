<?php
$environmentBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

interface ApplicationBootstrap
{
    public function getDocumentAdapter(): \Teach\Adapters\Document;
    
    public function createInteractionWeb(): \Teach\Interactors\Web\Lesplan\Factory;

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
     * @return \Teach\Interactors\Web\Lesplan\Factory
     */
    public function createInteractionWeb(): \Teach\Interactors\Web\Lesplan\Factory
    {
        return new \Teach\Interactors\Web\Lesplan\Factory();
    }
    
    public function getDocumentAdapter(): \Teach\Adapters\Document
    {
        return new \Teach\Adapters\Document(new \Teach\Adapters\Document\HTML());
    }
};