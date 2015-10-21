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
                                ['ul', ['class' => "meervoudige-intelligenties"], [
                                    ['li']
                                ]]
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