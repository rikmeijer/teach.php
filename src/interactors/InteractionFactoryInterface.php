<?php
namespace Teach\Interactors;

interface InteractionFactoryInterface
{
    public function createInteraction(\Teach\Interactors\Interactable $interactable): \Teach\Interactors\PresentableInterface;
}