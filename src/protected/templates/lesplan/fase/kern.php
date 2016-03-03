<?php
return function(\Teach\Adapters\HTML\Factory $factory, string $title, array $onderdelen) {
    $section = $factory->makeSection();
    $section->append($factory->makeHeader('2', $title));
    foreach ($onderdelen as $onderdeel) {
        $section->appendHTML($factory->renderTemplate(__DIR__ . DIRECTORY_SEPARATOR .  "kern" . DIRECTORY_SEPARATOR . "thema.php", $onderdeel));
    }
    return $section->render();
};