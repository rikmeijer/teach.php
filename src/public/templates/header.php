<?php
return function(\Teach\Adapters\HTML\Factory $factory, string $title, string $subtitle) {
    return '<header>' .  $factory->makeHeader('1', $title)->render() .  $factory->makeHeader('2', $subtitle)->render() . '</header>';
};