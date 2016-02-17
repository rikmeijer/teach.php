<?php
return function(\Teach\Adapters\HTML\Factory $factory, \Teach\Interactors\Web\Lesplan $lesplan) {
    $variables = $lesplan->provideTemplateVariables([
        "lesplanIdentifier",
        "opleidingIdentifier"
    ]);
    
    $lines = [];
    $lines[] = "<!DOCTYPE html>";
    $lines[] = "<html>";
    $lines[] = $factory->renderTemplate(__DIR__ . DIRECTORY_SEPARATOR . "head.php");
    $lines[] = "<body>";
    $lines[] = $factory->makeHTML([$factory->makePageHeader($factory->makeHeader1($variables["lesplanIdentifier"]), $factory->makeHeader2($variables["opleidingIdentifier"]))]);
    $lines[] = $factory->makeHTML($lesplan->generateLayout($factory));
    $lines[] = "</body>";
    $lines[] = "</html>";
    return join(PHP_EOL, $lines);
};