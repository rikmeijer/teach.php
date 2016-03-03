<?php
namespace Teach\Interactors;

interface InteractionFactoryInterface
{
    public function createInteraction(\Teach\Interactors\InteractableInterface $interactable): \Teach\Interactors\LayoutableInterface;
}