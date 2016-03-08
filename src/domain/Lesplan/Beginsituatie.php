<?php
namespace Teach\Domain\Lesplan;

class Beginsituatie implements \Teach\Interactors\Interactable
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
     * @return \Teach\Interactors\PresentableInterface
     */
    public function interact(\Teach\Interactors\Web\Lesplan\Factory $factory): \Teach\Interactors\PresentableInterface
    {
        return $factory->createContactmoment($this->beginsituatie, $this->media, $this->leerdoelen);
    }
}