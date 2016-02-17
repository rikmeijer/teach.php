<?php
return function(\Teach\Adapters\HTML\Factory $factory, string $title, array $onderdelen) {    
    $onderdelenHTML = [];
    foreach ($onderdelen as $onderdeel) {
        $onderdelenHTML[] = $factory->makeHTML($onderdeel->generateLayout ($factory));
    }
    
    return '<section><h2>' . htmlentities($title) . '</h2>' . join('', $onderdelenHTML) . '</section>';
};
