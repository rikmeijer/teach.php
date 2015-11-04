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
    public function generateHTMLLayout()
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
//                     [
//                         'tr',
//                         [],
//                         [
//                             [
//                                 'th',
//                                 'tijd'
//                             ],
//                             [
//                                 'td',
//                                 $this->werkvorm['tijd'] . ' minuten'
//                             ],
//                             [
//                                 'th',
//                                 'soort werkvorm'
//                             ],
//                             [
//                                 'td',
//                                 $this->werkvorm['werkvormsoort']
//                             ]
//                         ]
//                     ],
//                     [
//                         'tr',
//                         [],
//                         [
//                             [
//                                 'th',
//                                 'intelligenties'
//                             ],
//                             [
//                                 'td',
//                                 [
//                                     'colspan' => '3'
//                                 ],
//                                 [
//                                     [
//                                         'ul',
//                                         [
//                                             'class' => "meervoudige-intelligenties"
//                                         ],
//                                         $intelligentieListItems
//                                     ]
//                                 ]
//                             ]
//                         ]
//                     ],
//                     [
//                         'tr',
//                         [],
//                         [
//                             [
//                                 'th',
//                                 'inhoud'
//                             ],
//                             [
//                                 'td',
//                                 [
//                                     'colspan' => '3'
//                                 ],
//                                 $inhoudChildren
//                             ]
//                         ]
//                     ]
                ]
            ]
        ]
        ;
    }
}