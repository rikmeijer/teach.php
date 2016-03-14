<?php
namespace Teach\Domain\Lesplan;

final class Activiteit implements \Teach\Domain\Documentable
{
    const MI_VERBAAL_LINGUISTISCH = "VL";

    const MI_LOGISCH_MATHEMATISCH = "LM";

    const MI_VISUEEL_RUIMTELIJK = "VR";

    const MI_MUZIKAAL_RITMISCH = "MR";

    const MI_LICHAMELIJK_KINESTHETISCH = "LK";

    const MI_NATURALISTISCH = "N";

    const MI_INTERPERSOONLIJK = "IR";

    const MI_INTRAPERSOONLIJK = "IA";

    const INTELLIGENTIES = [
        self::MI_VERBAAL_LINGUISTISCH,
        self::MI_LOGISCH_MATHEMATISCH,
        self::MI_VISUEEL_RUIMTELIJK,
        self::MI_MUZIKAAL_RITMISCH,
        self::MI_LICHAMELIJK_KINESTHETISCH,
        self::MI_NATURALISTISCH,
        self::MI_INTERPERSOONLIJK,
        self::MI_INTRAPERSOONLIJK
    ];
    
    /**
     *
     * @var string
     */
    private $caption;
    
    /**
     *
     * @var array
     */
    private $werkvorm;

    public function __construct(string $caption, array $werkvorm)
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