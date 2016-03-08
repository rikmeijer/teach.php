<?php
namespace Teach\Interactors;

interface Interactable {
    
    public function interact(Web\Lesplan\Factory $factory): \Teach\Interactors\PresentableInterface;
}