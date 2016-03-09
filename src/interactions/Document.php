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

    public function render(\Teach\Interactions\Presentable $presentable)
    {
        return $this->adapter->makeDocument($presentable)->render();
    }
}