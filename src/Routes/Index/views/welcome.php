<?php $layout = $this->layout('master'); ?>

<?php $layout->section('title', 'Welcome'); ?>

<?php $layout->section('content'); ?>
    <header>
        <h1>Overzicht contactmomenten</h1>
        <ul class="horizontal-menu">
            <li><a href="<?= $this->url('/contactmoment/import'); ?>" target="_blank">Importeer contactmomenten</a></li>
        </ul>
    </header>

    <nav>
        <ul class="horizontal-menu">
            <?php foreach ($modules as $module): ?>
                <li><a href="#<?= $this->escape($module->naam); ?>"><?= $this->escape($module->naam); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section>
        <?php $this->render('contactmomenten', ['caption' => 'Contactmomenten vandaag', 'contactmomenten' => $contactmomenten]); ?>
    </section>

<?php foreach ($modules as $module): ?>
    <section>
        <a name="<?= $this->escape($module->naam); ?>"></a>
        <h2><?= $this->escape($module->naam); ?></h2>
        <?php $this->render('contactmomenten', ['caption' => 'Contactmomenten', 'contactmomenten' => $module->read("contactmoment_module", ["module_id" => "id"])]); ?>
    </section>
<?php endforeach; ?>