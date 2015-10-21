<?php
namespace Teach\Adapters\HTML;

final class Text implements RenderableInterface
{
    private $contents;
    
    public function __construct($contents)
    {
        $this->contents = $contents;
    }
    
    public function render()
    {
        return htmlentities($this->contents);
    }
}