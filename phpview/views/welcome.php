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
            <li><a href="#<?= $this->escape($module->getNaam()); ?>"><?= $this->escape($module->getNaam()); ?></a></li>
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
        <a name="<?= $this->escape($module->getNaam()); ?>"></a>
        <h2><?= $this->escape($module->getNaam()); ?><?php $this->rating($module->getAverageRating(), 75, 15); ?></h2>
        <?php $this->sub(
            'contactmomenten',
            ['caption' => 'Contactmomenten', 'contactmomenten' => $this->getModuleContactmomenten($module)]
        ); ?>
    </section>
<?php endforeach; ?>
<?php $layout->compile(); ?>
