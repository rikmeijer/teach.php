<?php
return function(\Teach\Adapters\HTML\Factory $factory, \Teach\Interactors\Web\Lesplan\Fase $fase) {
    $variables = $fase->provideTemplateVariables([
        "title",
        "onderdelen",
    ]);
    return $factory->renderTemplate(dirname(__DIR__) . DIRECTORY_SEPARATOR .  "fase.php", $variables["title"], $variables["onderdelen"]);
};