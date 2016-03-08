<?php
namespace Teach\Adapters;

final class Document
{    
    
    /**
     * 
     * @var Documentable
     */
    private $adapter;
    
    public function __construct(Documentable $adapter)
    {
        $this->adapter = $adapter;
    }
    
    public function render(\Teach\Interactors\Presentable $presentable)
    {
        return $this->adapter->makeDocument($presentable)->render();
    }
}