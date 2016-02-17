<?php
return function(\Teach\Adapters\HTML\Factory $factory, \Teach\Interactors\Web\Lesplan\Fase $fase) {
    $variables = $fase->provideTemplateVariables([
        "title",
        "onderdelen",
    ]);
    
    $onderdelenHTML = [];
    foreach ($variables['onderdelen'] as $onderdeel) {
        $onderdelenHTML[] = $factory->makeHTML($onderdeel->generateLayout ($factory));
    }
    
    return '<section><h2>' . htmlentities($variables['title']) . '</h2>' . join('', $onderdelenHTML) . '</section>';
};
