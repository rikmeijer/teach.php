<?php
namespace Teach\Interactors\Web\Lesplan;

final class Beginsituatie implements \Teach\Interactors\LayoutableInterface
{

    private $opleiding;

    private $beginsituatie;

    public function __construct($opleiding, array $beginsituatie)
    {
        $this->opleiding = $opleiding;
        $this->beginsituatie = $beginsituatie;
    }

    /**
     *
     * @return array
     */
    public function generateLayout (\Teach\Interactors\LayoutFactoryInterface $factory)
    {
        return [
            $factory->makeHeader3('Beginsituatie'),
            $factory->makeTable(null, [
                [
                    'doelgroep' => $this->beginsituatie['doelgroep']['beschrijving'],
                    'opleiding' => $this->opleiding
                ],
                [
                    'ervaring' => $this->beginsituatie['doelgroep']['ervaring'],
                    'groepsgrootte' => $this->beginsituatie['doelgroep']['grootte']
                ],
                [
                    'tijd' => 'van ' . $this->beginsituatie['starttijd'] . ' tot ' . $this->beginsituatie['eindtijd'] . ' (' . $this->beginsituatie['duur'] . ' minuten)'
                ],
                [
                    'ruimte' => $this->beginsituatie['ruimte']
                ],
                [
                    'overige' => $this->beginsituatie['overige']
                ]
            ])
        ];
    }
}