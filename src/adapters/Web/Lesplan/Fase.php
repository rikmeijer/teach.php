<?php
namespace Teach\Adapters\Web\Lesplan;

final class Fase
{

    private $caption;
    private $werkvorm;

    public function __construct($caption, array $werkvorm)
    {
        $this->caption = $caption;
        $this->werkvorm = $werkvorm;
    }

    /**
     *
     * @return array
     */
    public function generateFirstStep()
    {
        return [
            [
                'table',
                [
                    'class' => 'two-columns'
                ],
                [
                    [
                        'caption',
                        $this->caption
                    ],
                    [
                        'tr',
                        [],
                        [   
                            ['th', 'werkvorm'],
                            ['td', $this->werkvorm['werkvorm']],
                            ['th', 'organisatievorm'],
                            ['td', $this->werkvorm['organisatievorm']]
                        ]
                    ]
                ]
            ]
            
        ];
    }
}