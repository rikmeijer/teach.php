<?php
namespace Teach\Adapters\Web\Lesplan;

final class Fase
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
    public function generateFirstStep()
    {
        $intelligentieListItems = array();
        foreach (self::INTELLIGENTIES as $intelligentieIdentifier => $intelligentieLable) {
            $intelligentieListItems[] = ['li', ['id' => $intelligentieIdentifier], [$intelligentieLable]];
            if (in_array($intelligentieIdentifier, $this->werkvorm['intelligenties'])) {
                $intelligentieListItems[count($intelligentieListItems) - 1][1]['class'] = 'selected';
            }
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
                    [
                        'tr',
                        [],
                        [   
                            ['th', 'werkvorm'],
                            ['td', $this->werkvorm['werkvorm']],
                            ['th', 'organisatievorm'],
                            ['td', $this->werkvorm['organisatievorm']]
                        ]
                    ],
                    [
                        'tr',
                        [],
                        [   
                            ['th', 'tijd'],
                            ['td', $this->werkvorm['tijd'] . ' minuten'],
                            ['th', 'soort werkvorm'],
                            ['td', $this->werkvorm['werkvormsoort']]
                        ]
                    ],
                    [
                        'tr',
                        [],
                        [   
                            ['th', 'intelligenties'],
                            ['td', ['colspan' => '3'], [
                                ['ul', ['class' => "meervoudige-intelligenties"], $intelligentieListItems]
                            ]]
                        ]
                    ],
                    [
                        'tr',
                        [],
                        [   
                            ['th', 'inhoud'],
                            ['td', ['colspan' => '3'], [$this->werkvorm['inhoud']]]
                        ]
                    ]
                ]
            ]
            
        ];
    }
}