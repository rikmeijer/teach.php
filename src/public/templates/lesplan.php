<?php
return function(\Teach\Adapters\HTML\Factory $factory, \Teach\Interactors\Web\Lesplan $lesplan) {
    $lines = [];
    $lines[] = "<!DOCTYPE html>";
    $lines[] = "<html>";
    $lines[] = $factory->renderTemplate(__DIR__ . DIRECTORY_SEPARATOR . "head.php");
    $lines[] = "<body>";
    $lines[] = $factory->makeHTMLFrom($lesplan);
    $lines[] = "</body>";
    $lines[] = "</html>";
    return join(PHP_EOL, $lines);
};