<?php
namespace Teach\Interactors\Web\Lesplan;

final class Activiteit implements \Teach\Interactors\Presentable
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

    private $caption;

    private $werkvorm;

    public function __construct($caption, array $werkvorm)
    {
        $this->caption = $caption;
        $this->werkvorm = $werkvorm;
    }

    public function present(\Teach\Adapters\Documentable $adapter): string
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
                'intelligenties' => array_values(array_intersect(self::INTELLIGENTIES, $this->werkvorm['intelligenties']))
            ],
            [
                'inhoud' => $this->werkvorm['inhoud']
            ]
        ])->render();
    }
}