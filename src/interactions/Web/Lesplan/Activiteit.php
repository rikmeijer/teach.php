<?php
namespace Teach\Interactions\Web\Lesplan;

final class Activiteit implements \Teach\Interactions\Documentable
{
    private $caption;
    private $werkvorm;

    public function __construct($caption, array $werkvorm)
    {
        $this->caption = $caption;
        $this->werkvorm = $werkvorm;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        return $adapter->makeTable($this->caption, [
            [
                'werkvorm' => $this->werkvorm['werkvorm'],
                'organisatievorm' => $this->werkvorm['organisatievorm']
            ],
            [
                'tijd' => $this->werkvorm['tijd'] . ' minuten',
                'soort werkvorm' => $this->werkvorm['werkvormsoort']
            ],
            [
                'intelligenties' => $this->werkvorm['intelligenties']
            ],
            [
                'inhoud' => $this->werkvorm['inhoud']
            ]
        ])->render();
    }
}