<?php
namespace Teach\Interactors\Web\Lesplan;

final class Contactmoment implements \Teach\Interactors\LayoutableInterface
{
    private $les;
    
    /**
     * 
     * @var \Teach\Interactors\Web\Lesplan\Beginsituatie
     */
    private $beginsituatie;
    
    /**
     * 
     * @var string[]
     */
    private $media;

    /**
     *
     * @var string[]
     */
    private $leerdoelen;
    
    
    public function __construct($les, Beginsituatie $beginsituatie, array $media, array $leerdoelen)
    {
        $this->les = $les;
        $this->beginsituatie = $beginsituatie;
        $this->media = $media;
        $this->leerdoelen = $leerdoelen;
    }

    /**
     *
     * @return array
     */
    public function generateLayout (\Teach\Interactors\LayoutFactoryInterface $factory)
    {
        $beginsituatieHTMLLayout = $this->beginsituatie->generateLayout ($factory);
        if (count($this->media) > 0) {
            $beginsituatieHTMLLayout[] = $factory->makeHeader3('Benodigde media');
            $beginsituatieHTMLLayout[] = $factory->makeUnorderedList($this->media);
        }
        
        $beginsituatieHTMLLayout[] = $factory->makeHeader3('Leerdoelen');
        $beginsituatieHTMLLayout[] = $factory->makeParagraph('Na afloop van de les kan de student:');
        $beginsituatieHTMLLayout[] = $factory->makeOrderedList($this->leerdoelen);
        
        return [$factory->makeSection($factory->makeHeader2($this->les), $beginsituatieHTMLLayout)];
    }
}