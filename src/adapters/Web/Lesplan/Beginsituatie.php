<?php
namespace Teach\Adapters\Web\Lesplan;

final class Beginsituatie implements \Teach\Adapters\HTML\LayoutableInterface
{
    private $opleiding;
    
    private $beginsituatie;

    public function __construct($opleiding, array $beginsituatie)
    {
        $this->opleiding = $opleiding;
        $this->beginsituatie = $beginsituatie;
    }

    /**
     *
     * @return array
     */
    public function generateHTMLLayout(\Teach\Adapters\HTML\Factory $factory)
    {
        
        return [
            ['h3', 'Beginsituatie'],
            [
                'table',
                [
                    'class' => 'two-columns'
                ],
                [
                    [
                        'tr',
                        [],
                        [
                            [
                                'th',
                                'doelgroep'
                            ],
                            [
                                'td',
                                $this->beginsituatie['doelgroep']['beschrijving']
                            ],
                            [
                                'th',
                                'opleiding'
                            ],
                            [
                                'td',
                                $this->opleiding
                            ]
                        ]
                    ],
                    [
                        'tr',
                        [],
                        [
                            [
                                'th',
                                'ervaring'
                            ],
                            [
                                'td',
                                $this->beginsituatie['doelgroep']['ervaring']
                            ],
                            [
                                'th',
                                'groepsgrootte'
                            ],
                            [
                                'td',
                                $this->beginsituatie['doelgroep']['grootte']
                            ]
                        ]
                    ],
                    [
                        'tr',
                        [],
                        [
                            [
                                'th',
                                'tijd'
                            ],
                            [
                                'td',
                                [
                                    'colspan' => '3'
                                ],
                                [
                                    'van ' . $this->beginsituatie['starttijd'] . ' tot ' . $this->beginsituatie['eindtijd'] . ' (' . $this->beginsituatie['duur'] . ' minuten)'
                                ]
                            ]
                        ]
                    ],
                    [
                        'tr',
                        [],
                        [
                            [
                                'th',
                                'ruimte'
                            ],
                            [
                                'td',
                                [
                                    'colspan' => '3'
                                ],
                                [$this->beginsituatie['ruimte']]
                            ]
                        ]
                    ],
                    [
                        'tr',
                        [],
                        [
                            [
                                'th',
                                'overige'
                            ],
                            [
                                'td',
                                [
                                    'colspan' => '3'
                                ],
                                [$this->beginsituatie['overige']]
                            ]
                        ]
                    ]
                ]
            ]
        ]
        ;
    }
}