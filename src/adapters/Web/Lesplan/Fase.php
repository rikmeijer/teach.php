<?php
namespace Teach\Adapters\Web\Lesplan;

final class Fase implements \Teach\Adapters\HTML\LayoutableInterface
{

    private $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     *
     * @return array
     */
    public function generateHTMLLayout()
    {
        $activiteitenHTML = [];
        
        return [
            [
                'section',
                [],
                array_merge([
                    [
                        'h2',
                        $this->title
                    ]
                ], $activiteitenHTML)
            ]
        ]
        ;
    }
}