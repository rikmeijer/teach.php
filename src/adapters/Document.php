<?php
namespace Teach\Adapters;

final class Document
{    
    
    /**
     * 
     * @var AdapterInterface
     */
    private $adapter;
    
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }
    
    public function render(\Teach\Interactors\PresentableInterface $presentable)
    {
        return $this->adapter->makeDocument($presentable)->render();
    }
}