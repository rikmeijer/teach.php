<?php
namespace Teach\Interactors;

final class InteractionFactory
{
    /**
     * 
     * @param \Teach\Interactors\InteractableInterface $interactable
     * @return \Teach\Interactors\LayoutableInterface
     */
    public function createInteraction(\Teach\Interactors\InteractableInterface $interactable): \Teach\Interactors\LayoutableInterface
    {
        return $interactable->createInteractor(new Web\Lesplan\Factory());
    }
}