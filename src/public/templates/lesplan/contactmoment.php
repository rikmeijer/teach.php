<?php
return function(\Teach\Adapters\HTML\Factory $factory, string $title, \Teach\Interactors\Web\Lesplan\Contactmoment $contactmoment) {
    $variables = $contactmoment->provideTemplateVariables([
        'doelgroep',
        'groepsgrootte',
        'tijd',
        'ruimte',
        'overige',
        'media',
        'leerdoelen'
    ]);
    
    $html ='<section>' . $factory->makeHeader('2', $title)->render() . $factory->makeHeader('3', 'Beginsituatie')->render() . $factory->makeTable($title, [
                [
                    'doelgroep' => $variables['doelgroep']['beschrijving'],
                    'ervaring' => $variables['doelgroep']['ervaring']
                ],
                [
                    'groepsgrootte' => $variables['groepsgrootte']
                ],
                [
                    'tijd' => 'van ' . $variables['tijd']
                ],
                [
                    'ruimte' => $variables['ruimte']
                ],
                [
                    'overige' => $variables['overige']
                ]
    ])->render();
    
    if (count($variables['media']) > 0) {
        $html .= $factory->makeHeader('3', 'Media')->render() . $factory->makeUnorderedList($variables['media'])->render();
    }
    
    $html .= $factory->makeHeader('3', 'Leerdoelen')->render() . '<p>Na afloop van de les kan de student:</p>' . $factory->makeUnorderedList($variables['leerdoelen'])->render() . '</section>';
                
    
    return $html;
};