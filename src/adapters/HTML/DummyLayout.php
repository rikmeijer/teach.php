<?php
namespace Teach\Adapters\HTML;

final class DummyLayout implements \Teach\Adapters\HTML\LayoutableInterface
{
    /**
     *
     * @return array
     */
    public function generateHTMLLayout()
    {
        return [];
    }
}