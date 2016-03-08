<?php
namespace Teach\Domain\Lesplan;

class Contactmoment implements \Teach\Interactors\InteractableInterface
{

    /**
     *
     * @var array
     */
    private $beginsituatie;

    /**
     *
     * @var array
     */
    private $media;

    /**
     *
     * @var array
     */
    private $leerdoelen;

    public function __construct(array $beginsituatie, array $media, array $leerdoelen)
    {
        $this->beginsituatie = $beginsituatie;
        $this->media = $media;
        $this->leerdoelen = $leerdoelen;
    }

    /**
     * 
     * @param \Teach\Interactors\Web\Lesplan\Factory $factory
     * @return \Teach\Interactors\LayoutableInterface
     */
    public function interact(\Teach\Interactors\Web\Lesplan\Factory $factory): \Teach\Interactors\LayoutableInterface
    {
        return $factory->createContactmoment($this->beginsituatie, $this->media, $this->leerdoelen);
    }
}