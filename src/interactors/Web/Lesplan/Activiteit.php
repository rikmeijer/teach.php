<?php
namespace Teach\Interactors\Web\Lesplan;

final class Activiteit implements \Teach\Interactors\LayoutableInterface
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

    public function provideTemplateVariables(array $variableIdentifiers)
    {
        $variables = [];
        foreach ($variableIdentifiers as $variableIdentifier) {
            switch ($variableIdentifier) {
                case 'title':
                    $variables[$variableIdentifier] = $this->caption;
                    break;
                case 'inhoud':
                    $variables[$variableIdentifier] = $this->werkvorm['inhoud'];
                    break;
                case 'werkvorm':
                    $variables[$variableIdentifier] = $this->werkvorm['werkvorm'];
                    break;
                case 'organisatievorm':
                    $variables[$variableIdentifier] = $this->werkvorm['organisatievorm'];
                    break;
                case 'werkvormsoort':
                    $variables[$variableIdentifier] = $this->werkvorm['werkvormsoort'];
                    break;
                case 'tijd':
                    $variables[$variableIdentifier] = $this->werkvorm['tijd'] . ' minuten';
                    break;
                case 'intelligenties':
                    $variables[$variableIdentifier] = array_values(array_intersect(self::INTELLIGENTIES, $this->werkvorm['intelligenties']));
                    break;
            }
        }
        return $variables;
    }

    /**
     *
     * @return array
     */
    public function generateLayout (\Teach\Interactors\LayoutFactoryInterface $factory)
    {
        $inhoudChildren = [];
        if (is_string($this->werkvorm['inhoud'])) {
            $inhoudChildren[] = $this->werkvorm['inhoud'];
        } elseif (is_array($this->werkvorm['inhoud'])) {
            $inhoudChildren[] = $factory->makeUnorderedList($this->werkvorm['inhoud']);
        }
        
        return [
            $factory->makeTable($this->caption, [
                [
                    'werkvorm' => $this->werkvorm['werkvorm'],
                    'organisatievorm' => $this->werkvorm['organisatievorm']
                ],
                [
                    'tijd' => $this->werkvorm['tijd'] . ' minuten',
                    'soort werkvorm' => $this->werkvorm['werkvormsoort']
                ],
                [
                    'intelligenties' => [$factory->makeUnorderedList(array_intersect(self::INTELLIGENTIES, $this->werkvorm['intelligenties']))]
                ],
                [
                    'inhoud' => $inhoudChildren
                ]
            ])
        ];
    }
}