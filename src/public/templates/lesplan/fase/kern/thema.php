<?php
return function(\Teach\Adapters\HTML\Factory $factory, \Teach\Interactors\Web\Lesplan\Thema $thema) {
    $variables = $thema->provideTemplateVariables([
        "title",
        "activiteiten",
    ]);
    
    $activiteitenHTML = [];
    foreach ($variables["activiteiten"] as $activiteit) {
        $activiteitenHTML[] = $factory->renderTemplate(dirname(__DIR__) . DIRECTORY_SEPARATOR . "activiteit.php", ...array_values($activiteit->provideTemplateVariables([
            "title",
            "inhoud",
            "werkvorm",
            "organisatievorm",
            "werkvormsoort",
            "tijd",
            "intelligenties"
        ])));
    }
    
    return '<section><h3>' . htmlentities($variables["title"]) . '</h3>' . join('', $activiteitenHTML) . '</section>';
};