<?php
return function(\Teach\Adapters\HTML\Factory $factory, $title, $inhoud, $werkvorm, $organisatievorm, $werkvormsoort, $tijd, $intelligenties) {
    return '';
    $inhoudChildren = [];
    if (is_string($inhoud)) {
        $inhoudChildren[] = $inhoud;
    } elseif (is_array($inhoud)) {
        $inhoudChildren[] = $factory->makeUnorderedList($inhoud);
    }
    
    return [
        $factory->makeTable($title, [
            [
                'werkvorm' => $werkvorm,
                'organisatievorm' => $organisatievorm
            ],
            [
                'tijd' => $tijd,
                'soort werkvorm' => $werkvormsoort
            ],
            [
                'intelligenties' => [$factory->makeUnorderedList($intelligenties)]
            ],
            [
                'inhoud' => $inhoudChildren
            ]
        ])
    ];
}; 