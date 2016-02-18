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
    

    return '<section><h2>' . htmlentities($variables['title']) . '</h2>' . join('', $themasHTML) . '</section>';
};