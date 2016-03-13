<?php
namespace Teach\Interactions;

interface Interactable
{

    public function interact(Web\Factory $factory): \Teach\Interactions\Documentable;
}