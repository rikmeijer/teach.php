<?php
namespace Teach\Adapters;

final class HTML
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
        return '<!DOCTYPE html><html>' . $presentable->present($this->adapter) . '</html>';
    }
}