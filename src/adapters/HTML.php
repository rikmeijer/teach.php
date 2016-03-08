<?php
namespace Teach\Adapters;

final class HTML
{    
    
    /**
     * 
     * @var AdapterInterface
     */
    private $factory;
    
    public function __construct(HTML\Factory $factory)
    {
        $this->factory = $factory;
    }
    
    public function render(\Teach\Interactors\PresentableInterface $presentable)
    {
        return '<!DOCTYPE html>' . $presentable->present($this->factory);
    }
}