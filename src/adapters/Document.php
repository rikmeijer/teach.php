<?php
namespace Teach\Adapters;

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
    
    public function render(\Teach\Interactors\Presentable $presentable)
    {
        return $this->adapter->makeDocument($presentable)->render();
    }
}