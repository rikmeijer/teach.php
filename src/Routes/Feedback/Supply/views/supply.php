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
?><h1>Hoeveel sterren?</h1><?php
for ($i = 0; $i < 5; $i++) {
    ?><a href="<?= $this->url('/feedback/%s/supply?rating=%s', $contactmomentIdentifier, $i + 1); ?>">
    <img
            src="<?= $this->star($i, $rating); ?>" width="100"/></a><?php
}
if ($rating !== null) {
    $this->form("post", "Verzenden", '<h1>Waarom?</h1>
                        <input type="hidden" name="rating" value="' . $this->escape($rating) . '" />
                        <textarea rows="5" cols="75" name="explanation">' . $this->escape($explanation) . '</textarea>');
}