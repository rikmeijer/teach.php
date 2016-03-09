<?php
namespace Teach\Domain\Lesplan;

class Introductie implements \Teach\Interactions\Interactable
{

    /**
     *
     * @var array
     */
    private $opening;

    /**
     *
     * @var array
     */
    private $focus;

    /**
     *
     * @var array
     */
    private $voorstellen;

    /**
     *
     * @var array
     */
    private $kennismaken;

    /**
     *
     * @var array
     */
    private $terugblik;

    public function __construct(array $opening, array $focus, array $voorstellen, array $kennismaken, array $terugblik)
    {
        $this->opening = $opening;
        $this->focus = $focus;
        $this->voorstellen = $voorstellen;
        $this->kennismaken = $kennismaken;
        $this->terugblik = $terugblik;
    }

    /**
     *
     * @param \Teach\Interactions\Web\Lesplan\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Lesplan\Factory $factory): \Teach\Interactions\Documentable
    {
        return $factory->createIntroductie($factory->createActiviteit("Activerende opening", $this->opening), $factory->createActiviteit("Focus", $this->focus), $factory->createActiviteit("Voorstellen", $this->voorstellen), $factory->createActiviteit("Kennismaken", $this->kennismaken), $factory->createActiviteit("Terugblik", $this->terugblik));
    }
}