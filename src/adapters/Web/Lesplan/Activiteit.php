<?php
namespace Teach\Adapters\Web\Lesplan;

final class Activiteit implements \Teach\Adapters\HTML\LayoutableInterface
{

    const MI_VERBAAL_LINGUISTISCH = "verbaal-linguistisch";

    const MI_LOGISCH_MATHEMATISCH = "logisch-mathematisch";

    const MI_VISUEEL_RUIMTELIJK = "visueel-ruimtelijk";

    const MI_MUZIKAAL_RITMISCH = "muzikaal-ritmisch";

    const MI_LICHAMELIJK_KINESTHETISCH = "lichamelijk-kinesthetisch";

    const MI_NATURALISTISCH = "naturalistisch";

    const MI_INTERPERSOONLIJK = "interpersoonlijk";

    const MI_INTRAPERSOONLIJK = "intrapersoonlijk";

    const INTELLIGENTIES = [
        self::MI_VERBAAL_LINGUISTISCH => 'VL',
        self::MI_LOGISCH_MATHEMATISCH => "LM",
        self::MI_VISUEEL_RUIMTELIJK => "VR",
        self::MI_MUZIKAAL_RITMISCH => "MR",
        self::MI_LICHAMELIJK_KINESTHETISCH => "LK",
        self::MI_NATURALISTISCH => "N",
        self::MI_INTERPERSOONLIJK => "IR",
        self::MI_INTRAPERSOONLIJK => "IA"
    ];

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
    public function generateHTMLLayout(\Teach\Adapters\HTML\Factory $factory)
    {
        $intelligentieListItems = array();
        foreach (self::INTELLIGENTIES as $intelligentieIdentifier => $intelligentieLable) {
            if (in_array($intelligentieIdentifier, $this->werkvorm['intelligenties'])) {
                $intelligentieListItems[] = [
                    'li',
                    [],
                    [
                        $intelligentieLable
                    ]
                ];;
            }
        }
        
        $inhoudChildren = [];
        if (is_string($this->werkvorm['inhoud'])) {
            $inhoudChildren[] = $this->werkvorm['inhoud'];
        } elseif (is_array($this->werkvorm['inhoud'])) {
            $inhoudList = [
                'ul',
                [],
                []
            ];
            foreach ($this->werkvorm['inhoud'] as $inhoudItem) {
                $inhoudList[2][] = [
                    'li',
                    $inhoudItem
                ];
            }
            $inhoudChildren[] = $inhoudList;
        }
        
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
                    $factory->makeTableRow(4, [
                        'werkvorm' => $this->werkvorm['werkvorm'],
                        'organisatievorm' => $this->werkvorm['organisatievorm']
                    ]),
                    $factory->makeTableRow(4, [
                        'tijd' => $this->werkvorm['tijd'] . ' minuten',
                        'soort werkvorm' => $this->werkvorm['werkvormsoort']
                    ]),
                    $factory->makeTableRow(4, [
                        'intelligenties' => [[
                            'ul',
                            [
                                'class' => "meervoudige-intelligenties"
                            ],
                            $intelligentieListItems
                        ]]
                    ]),
                    $factory->makeTableRow(4, [
                        'inhoud' => $inhoudChildren
                    ])
                ]
            ]
        ];
    }
}