<?php
return function(\Teach\Adapters\HTML\Factory $factory, \Teach\Interactors\Web\Lesplan $lesplan) {
    $variables = $lesplan->provideTemplateVariables([
        "title",
        "subtitle",
        "contactmomentTitle",
        "contactmoment",
        "introductie",
        "kern",
        "afsluiting",
    ]);
    
    $lines = [];
    $lines[] = "<!DOCTYPE html>";
    $lines[] = "<html>";
    $lines[] = $factory->renderTemplate(__DIR__ . DIRECTORY_SEPARATOR . "head.php");
    $lines[] = "<body>";
    $lines[] = $factory->renderTemplate(__DIR__ . DIRECTORY_SEPARATOR . "header.php", $variables["title"], $variables["subtitle"]);
    
    $lesplanTemplateDirectory = __DIR__ . DIRECTORY_SEPARATOR . "lesplan";
    $lines[] = $factory->renderTemplate($lesplanTemplateDirectory . DIRECTORY_SEPARATOR .  "contactmoment.php", $variables["contactmomentTitle"], $variables["contactmoment"]);
    $lines[] = $factory->renderTemplate($lesplanTemplateDirectory . DIRECTORY_SEPARATOR .  "fase.php", $variables["introductie"]);
    $lines[] = $factory->renderTemplate($lesplanTemplateDirectory . DIRECTORY_SEPARATOR .  "fase.php", $variables["kern"]);
    $lines[] = $factory->renderTemplate($lesplanTemplateDirectory . DIRECTORY_SEPARATOR .  "fase.php", $variables["afsluiting"]);
    
    $lines[] = "</body>";
    $lines[] = "</html>";
    return join(PHP_EOL, $lines);
};