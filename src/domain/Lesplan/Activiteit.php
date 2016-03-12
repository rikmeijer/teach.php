<?php
namespace Teach\Domain\Lesplan;

final class Activiteit implements \Teach\Interactions\Interactable
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
    

    public function interact(\Teach\Interactions\Web\Lesplan\Factory $factory): \Teach\Interactions\Documentable
    {
        // TODO Auto-generated method stub
    }
}