<?php
namespace Teach\Adapters\HTML;

final class Text implements \Teach\Adapters\Renderable
{

    private $contents;

    public function __construct($contents)
    {
        $this->contents = $contents;
    }

    public function render(): string
    {
        return htmlentities($this->contents);
    }
}