<?php
return function(\Teach\Adapters\HTML\Factory $factory, string $title, array $activiteiten) {
    $section = $factory->makeSection();
    $section->append($factory->makeHeader('2', $title));
    foreach ($activiteiten as $activiteit) {
        $section->appendHTML($factory->renderTemplate(__DIR__ . DIRECTORY_SEPARATOR . "fase" . DIRECTORY_SEPARATOR . "activiteit.php", ...array_values($activiteit->provideTemplateVariables([
            "title",
            "inhoud",
            "werkvorm",
            "organisatievorm",
            "werkvormsoort",
            "tijd",
            "intelligenties"
        ]))));
    }
    return $section->render();
};
