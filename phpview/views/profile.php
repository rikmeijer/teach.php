<?php $layout = $this->layout('master'); ?>

<?php $layout->section('title', 'Profile'); ?>

<?php $layout->section('content'); ?>
<?php print_r($profile); ?>
<?php $layout->compile(); ?>
