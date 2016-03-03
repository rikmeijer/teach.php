<?php
namespace Teach\Interactors;

interface InteractableInterface {
    
    public function createInteractor(Web\Lesplan\Factory $factory): \Teach\Interactors\LayoutableInterface;
}