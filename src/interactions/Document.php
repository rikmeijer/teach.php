<?php
namespace Teach\Interactions;

final class Document
{

    /**
     *
     * @var Documenter
     */
    private $adapter;

    public function __construct(Documenter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function render(\Teach\Domain\Documentable $documentable)
    {
        $contents = $documentable->document($this->adapter);
        return $this->adapter->makeDocument($contents)->render();
    }
}