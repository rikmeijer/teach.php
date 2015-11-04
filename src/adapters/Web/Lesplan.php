<?php
namespace Teach\Adapters\Web;

final class Lesplan implements \Teach\Adapters\HTML\LayoutableInterface
{

    private $vak;

    private $les;
    
    /**
     * 
     * @var \Teach\Adapters\Web\Lesplan\Beginsituatie
     */
    private $beginsituatie;
    
    public function __construct($vak, $les, Lesplan\Beginsituatie $beginsituatie)
    {
        $this->vak = $vak;
        $this->les = $les;
        $this->beginsituatie = $beginsituatie;
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
                array_merge([
                    [
                        'h2',
                        $this->les
                    ]
                ], $this->beginsituatie->generateHTMLLayout())
            ]
        ];
    }
}