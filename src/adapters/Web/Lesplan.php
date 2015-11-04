<?php
namespace Teach\Adapters\Web;

final class Lesplan implements \Teach\Adapters\HTML\LayoutableInterface
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
                'header',
                [],
                [
                    [
                        'h1',
                        $this->title
                    ]
                ]
            ]
        ];
    }
}