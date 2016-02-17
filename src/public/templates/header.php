<?php
return function(\Teach\Adapters\HTML\Factory $factory, string $title, string $subtitle) {
    return '<header><h1>' . htmlentities($title) . '</h1><h2>' . htmlentities($subtitle) . '</h2></header>';
};