<?php
return function(\Teach\Adapters\HTML\Factory $factory, \Teach\Interactors\Web\Lesplan\Fase $fase) {
    $variables = $fase->provideTemplateVariables([
        "title",
        "onderdelen",
    ]);
    
    
    $themasHTML = [];
    foreach ($variables["onderdelen"] as $onderdeel) {
        $themasHTML[] = $factory->renderTemplate(__DIR__ . DIRECTORY_SEPARATOR .  "kern" . DIRECTORY_SEPARATOR . "thema.php", $onderdeel);
    }
    

    return '<section>' .  $factory->makeHeader('2', $variables['title'])->render() . join('', $themasHTML) . '</section>';
};