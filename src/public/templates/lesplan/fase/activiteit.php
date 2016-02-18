<?php
return function(\Teach\Adapters\HTML\Factory $factory, $title, $inhoud, $werkvorm, $organisatievorm, $werkvormsoort, $tijd, $intelligenties) {
    return $factory->renderTable($title, [
        [
            'werkvorm' => $werkvorm,
            'organisatievorm' => $organisatievorm
        ],
        [
            'tijd' => $tijd,
            'soort werkvorm' => $werkvormsoort
        ],
        [
            'intelligenties' => $intelligenties
        ],
        [
            'inhoud' => $inhoud
        ]
    ]);
}; 