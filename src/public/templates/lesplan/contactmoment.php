<?php
return function(\Teach\Adapters\HTML\Factory $factory, string $title, \Teach\Interactors\Web\Lesplan\Contactmoment $contactmoment) {
    return '<section><h2>' . htmlentities($title) . '</h2>' . $factory->makeHTML($contactmoment->generateLayout($factory)) . '</section>';
};