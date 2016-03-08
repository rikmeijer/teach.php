<?php
namespace Teach\Adapters;

interface Renderable
{    
    /**
     *
     * @return string
     */
    public function render(): string;
}