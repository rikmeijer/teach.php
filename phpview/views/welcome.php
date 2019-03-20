<?php $layout = $this->layout('master'); ?>

<?php $layout->section('title', 'Welcome'); ?>

<?php $layout->section('content'); ?>
<header>
    <h1>Overzicht contactmomenten</h1>
    <ul class="horizontal-menu">
        <li><a href="<?= $this->url('/contactmoment/import'); ?>" target="_blank">Importeer contactmomenten</a></li>
        <li><a href="<?= $this->url('/logout'); ?>" target="_blank">Afmelden</a></li>
    </ul>
</header>

<nav>
    <ul class="horizontal-menu">
        <?php foreach ($this->modules() as $module) : ?>
            <li><a href="#<?= $this->escape($module->naam); ?>"><?= $this->escape($module->naam); ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>
<section>
    <?php $this->sub(
        'contactmomenten_vandaag',
        ['caption' => 'Contactmomenten vandaag', 'contactmomenten' => $this->contactmomenten()]
    ); ?>
</section>

<?php foreach ($this->modules() as $module) : ?>
    <section>
        <a name="<?= $this->escape($module->naam); ?>"></a>
        <h2><?= $this->escape($module->naam); ?><img
                    src="<?= $this->url('/rating/%s', $module->retrieveRating() ?? 'N'); ?>" width="75" height="15"
                    style="float: right;"/></h2>
        <?php $this->sub(
            'contactmomenten',
            ['caption' => 'Contactmomenten', 'contactmomenten' => $module->contactmomenten]
        ); ?>
    </section>
<?php endforeach; ?>
<?php $layout->compile(); ?>
