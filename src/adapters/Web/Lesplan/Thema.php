<?php
namespace Teach\Adapters\Web\Lesplan;

final class Thema implements \Teach\Adapters\LayoutableInterface
{

    private $title;

    /**
     *
     * @var Activiteit[]
     */
    private $activiteiten = [];

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function addActiviteit(Activiteit $activiteit)
    {
        $this->activiteiten[] = $activiteit;
    }

    /**
     *
     * @return array
     */
    public function generateLayout (\Teach\Adapters\LayoutFactoryInterface $factory)
    {
        $activiteitenHTML = [];
        foreach ($this->activiteiten as $activiteit) {
            $activiteitenHTML = array_merge($activiteitenHTML, $activiteit->generateLayout ($factory));
        }
        
        return [
            $factory->makeSection($factory->makeHeader3($this->title), $activiteitenHTML)
        ];
    }
}