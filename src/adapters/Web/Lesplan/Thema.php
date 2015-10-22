<?php
namespace Teach\Adapters\Web\Lesplan;

final class Thema implements \Teach\Adapters\HTML\LayoutableInterface
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
        return [
            [
                'section',
                [],
                [
                    [
                        'h3',
                        $this->title
                    ]
                ]
            ]
            
        ];
    }
}