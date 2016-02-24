<?php
return function(\Teach\Adapters\HTML\Factory $factory, string $title, array $activiteiten) {    
    $activiteitenHTML = [];
    foreach ($activiteiten as $activiteit) {
        $activiteitenHTML[] = $factory->renderTemplate(__DIR__ . DIRECTORY_SEPARATOR . "fase" . DIRECTORY_SEPARATOR . "activiteit.php", ...array_values($activiteit->provideTemplateVariables([
            "title",
            "inhoud",
            "werkvorm",
            "organisatievorm",
            "werkvormsoort",
            "tijd",
            "intelligenties"
        ])));
    }
    
    return '<section><h2>' . htmlentities($title) . '</h2>' . join('', $activiteitenHTML) . '</section>';
};