<?php
namespace Teach\Interactions\Web\Document;

final class Table implements \Teach\Interactions\Documentable
{
    private $caption;
    private $rows;

    public function __construct($caption, array $rows)
    {
        $this->caption = $caption;
        $this->rows = $rows;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        return $adapter->makeTable($this->caption, $this->rows)->render();
    }
}