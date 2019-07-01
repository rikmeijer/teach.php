#!/usr/bin/env php
<?php
// application.php

$bootstrap = require dirname(__DIR__).'/bootstrap.php';

use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new class($bootstrap) extends \Symfony\Component\Console\Command\Command {

    private $bootstrap;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        parent::__construct('regenerateTDBM');
        $this->bootstrap = $bootstrap;
    }

    protected function configure()
    {
        $this
            ->setDescription('Regenerates TDBM Beans and DAOS')
            ->setHelp('Runs the regenerateBeansAndDaos on the TDBMService')
        ;
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $output->write("Regenerating Daos and Beans...");
        /**
         * @var \TheCodingMachine\TDBM\TDBMService $tdbm
         */
        $tdbm = $this->bootstrap->resource('tdbm');
        $tdbm->generateAllDaosAndBeans();
        apcu_clear_cache();
        $output->writeln("OK");
    }
});

$application->run();
