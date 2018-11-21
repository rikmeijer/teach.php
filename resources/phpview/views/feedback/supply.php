<?php $layout = $this->layout('html5'); ?>
<?php $layout->section('title', 'Feedback'); ?>
<?php $layout->section('head'); ?>
    <meta charset="utf-8">
    <style>
        body {
            font-family: arial, sans-serif;
            text-align: center;
        }
    </style>
<?php $layout->section('body');
?><h1>Hoeveel sterren?</h1>
    <img src="<?= $this->url('/rating/%s', $rating??"N"); ?>" usemap="#rating" width="500" height="100" style="margin: 25px 0;"/>
    <map name="rating">
        <?php
        for ($i = 0; $i < 5; $i++) {
            ?><area shape=rect coords="<?= $i*100; ?>,0,<?= $i*100+100; ?>,100" href="<?= $this->url('./?rating=%s', $i + 1); ?>" alt="rate <?=$i + 1?>"><?php
        }
        ?>
    </map>
<?php

if ($rating !== null) {
    $this->form("post", "Verzenden", '<h1>Waarom?</h1>
                        <input type="hidden" name="rating" value="' . $this->escape($rating) . '" />
                        <textarea rows="5" cols="75" name="explanation">' . $this->escape($explanation) . '</textarea>');
}
$layout->compile();