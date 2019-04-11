<?php $layout = $this->layout('html5'); ?>
<?php $layout->section('title', 'Feedback'); ?>
<?php $layout->section('head'); ?>
<meta charset="utf-8">
<meta http-equiv="refresh" content="5">
<style>
    body {
        font-family: arial, sans-serif;
        text-align: center;
        background-color: #ffffff;
    }
</style>

<?php $layout->section('body'); ?>
<h1>Feedback-o-meter</h1>
<?php $this->rating($this->contactmomentRating($contactmomentIdentifier) , 500, 100); ?><br />
<img src="<?= $this->url('/qr?data=%s', $this->feedbackSupplyURL($contactmomentIdentifier)); ?>" width="400" height="400"/>
<p><?= $this->feedbackSupplyURL($contactmomentIdentifier); ?></p>
<?php $layout->compile(); ?>
