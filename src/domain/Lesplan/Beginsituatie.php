<?php
namespace Teach\Domain\Lesplan;

class Beginsituatie implements \Teach\Interactions\Interactable
{
    /**
     *
     * @var string
     */
    private $les;

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

    public function __construct(string $les, array $beginsituatie, array $media, array $leerdoelen)
    {
        $this->les = $les;
        $this->beginsituatie = $beginsituatie;
        $this->media = $media;
        $this->leerdoelen = $leerdoelen;
    }

    /**
     *
     * @param \Teach\Interactions\Web\Lesplan\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Lesplan\Factory $factory): \Teach\Interactions\Documentable
    {
        return $factory->createContactmoment($this->les, $this->beginsituatie, $this->media, $this->leerdoelen);
    }
}