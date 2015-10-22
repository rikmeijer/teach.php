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
    
    public function addActiviteit(Activiteit $activiteit) {
        $this->activiteiten[] = $activiteit;
    }

    /**
     *
     * @return array
     */
    public function generateHTMLLayout()
    {
        $activiteitenHTML = [];
        foreach ($this->activiteiten as $activiteit) {
            $activiteitenHTML = array_merge($activiteitenHTML, $activiteit->generateHTMLLayout());
        }
        
        return [
            [
                'section',
                [],
                array_merge([[
                    'h3',
                    $this->title
                ]], $activiteitenHTML)
            ]
            
        ];
    }
}