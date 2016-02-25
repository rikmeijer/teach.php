<?php
return function(\Teach\Adapters\HTML\Factory $factory, \Teach\Interactors\Web\Lesplan\Fase $fase) {
    $variables = $fase->provideTemplateVariables([
        "title",
        "onderdelen",
    ]);
    $section = $factory->makeSection();
    $section->append($factory->makeHeader('2', $variables['title']));
    foreach ($variables["onderdelen"] as $onderdeel) {
        $section->appendHTML($factory->renderTemplate(__DIR__ . DIRECTORY_SEPARATOR .  "kern" . DIRECTORY_SEPARATOR . "thema.php", $onderdeel));
    }
    return $section->render();
};