<?php
namespace Teach\Interactors;

interface InteractableInterface {
    
    public function interact(Web\Lesplan\Factory $factory): \Teach\Interactors\PresentableInterface;
}