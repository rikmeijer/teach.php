<?php $layout = $this->layout('master'); ?>

<?php $layout->section('title', 'Importeer contactmomenten'); ?>

<?php $layout->section('content'); ?>
<header>
    <h1>Contactmomenten ge&iuml;mporteerd</h1>
</header>
<section>
    <p><?= $this->escape($numberImported); ?> contactmomenten zijn ge&iuml;mporteerd</p>
</section>
<?php $layout->compile(); ?>