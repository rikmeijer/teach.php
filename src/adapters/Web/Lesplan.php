<?php
namespace Teach\Adapters\Web;

final class Lesplan implements \Teach\Adapters\HTML\LayoutableInterface
{

    private $vak;

    private $les;
    
    public function __construct($vak, $les)
    {
        $this->vak = $vak;
        $this->les = $les;
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
                        'Lesplan ' . $this->vak
                    ]
                ]
            ],
            [
                'section',
                [],
                [
                    [
                        'h2',
                        $this->les
                    ]
                ]
            ]
        ];
    }
}