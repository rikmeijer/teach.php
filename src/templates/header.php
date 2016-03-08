<?php
return function(\Teach\Adapters\AdapterInterface $adapter, string $title, string $subtitle) {
    return '<header>' .  $adapter->makeHeader('1', $title)->render() .  $adapter->makeHeader('2', $subtitle)->render() . '</header>';
};