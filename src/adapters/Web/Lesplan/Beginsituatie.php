<?php
namespace Teach\Adapters\Web\Lesplan;

final class Beginsituatie implements \Teach\Adapters\HTML\LayoutableInterface
{

    private $beginsituatie;

    public function __construct(array $beginsituatie)
    {
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
//                     [
//                         'caption',
//                         $this->caption
//                     ],
//                     [
//                         'tr',
//                         [],
//                         [
//                             [
//                                 'th',
//                                 'werkvorm'
//                             ],
//                             [
//                                 'td',
//                                 $this->werkvorm['werkvorm']
//                             ],
//                             [
//                                 'th',
//                                 'organisatievorm'
//                             ],
//                             [
//                                 'td',
//                                 $this->werkvorm['organisatievorm']
//                             ]
//                         ]
//                     ],
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