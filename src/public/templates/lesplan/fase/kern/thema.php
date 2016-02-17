<?php
return function(\Teach\Adapters\HTML\Factory $factory, \Teach\Interactors\Web\Lesplan\Thema $thema) {
    $variables = $thema->provideTemplateVariables([
        "title",
        "activiteiten",
    ]);
    
    $activiteitenHTML = [];
    foreach ($variables["activiteiten"] as $activiteit) {
        $activiteitenHTML[] = $factory->makeHTML($activiteit->generateLayout ($factory));
    }
    
    return '<section><h3>' . htmlentities($variables["title"]) . '</h3>' . join('', $activiteitenHTML) . '</section>';
};