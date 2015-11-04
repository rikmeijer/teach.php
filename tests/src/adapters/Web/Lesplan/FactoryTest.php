<?php
namespace Teach\Adapters\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateActiviteit()
    {
        $object = new Factory();
        $layout = $object->createActiviteit("Activerende opening", [
            'inhoud' => '',
            'werkvorm' => "",
            'organisatievorm' => "plenair",
            'werkvormsoort' => "ijsbreker",
            'tijd' => "",
            'intelligenties' => [
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_VERBAAL_LINGUISTISCH,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_VISUEEL_RUIMTELIJK,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTERPERSOONLIJK,
                \Teach\Adapters\Web\Lesplan\Activiteit::MI_INTRAPERSOONLIJK
            ]
        ])->generateHTMLLayout();
        $this->assertEquals("Activerende opening", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    }
    

    public function testCreateThema()
    {
        $object = new Factory();
        $layout = $object->createThema("Thema caption here")->generateHTMLLayout();
        $this->assertEquals("Thema caption here", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    }


    public function testCreateFase()
    {
        $object = new Factory();
        $layout = $object->createFase("Kern")->generateHTMLLayout();
        $this->assertEquals("Kern", $layout[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    }
}
