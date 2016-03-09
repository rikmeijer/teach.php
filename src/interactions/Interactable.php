<?php
namespace Teach\Interactions;

interface Interactable
{

    public function interact(Web\Lesplan\Factory $factory): \Teach\Interactions\Documentable;
}