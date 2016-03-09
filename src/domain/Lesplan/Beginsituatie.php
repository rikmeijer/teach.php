<?php
namespace Teach\Domain\Lesplan;

class Beginsituatie implements \Teach\Interactions\Interactable
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
     * @param \Teach\Interactions\Web\Lesplan\Factory $factory            
     * @return \Teach\Interactions\Presentable
     */
    public function interact(\Teach\Interactions\Web\Lesplan\Factory $factory): \Teach\Interactions\Presentable
    {
        return $factory->createContactmoment($this->beginsituatie, $this->media, $this->leerdoelen);
    }
}