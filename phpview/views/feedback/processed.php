<?php $layout = $this->layout('html5'); ?>
<?php $layout->section('title', 'Feedback'); ?>
<?php $layout->section('head'); ?>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: arial, sans-serif;
            text-align: center;
            background-color: #ffffff;
        }
    </style>
<?php $layout->section('body'); ?>
    <h1>Dankje!</h1>
<?php $layout->compile(); ?>