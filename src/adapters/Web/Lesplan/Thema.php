<?php
namespace Teach\Adapters\Web\Lesplan;

final class Thema implements \Teach\Adapters\HTML\LayoutableInterface
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
    public function generateHTMLLayout(\Teach\Adapters\HTML\Factory $factory)
    {
        $activiteitenHTML = [];
        foreach ($this->activiteiten as $activiteit) {
            $activiteitenHTML = array_merge($activiteitenHTML, $activiteit->generateHTMLLayout($factory));
        }
        
        return [
            [
                'section',
                [],
                array_merge([
                    $factory->makeHeader3($this->title)
                ], $activiteitenHTML)
            ]
        ]
        ;
    }
}