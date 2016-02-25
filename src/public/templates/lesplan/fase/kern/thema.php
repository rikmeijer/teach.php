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
    
    return '<section>' .  $factory->makeHeader('3', $variables["title"])->render() . join('', $activiteitenHTML) . '</section>';
};