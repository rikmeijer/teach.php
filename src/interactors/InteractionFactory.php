<?php
namespace Teach\Interactors;

final class InteractionFactory
{
    /**
     * 
     * @param \Teach\Interactors\InteractableInterface $interactable
     * @return \Teach\Interactors\LayoutableInterface
     */
    public function createInteraction(\Teach\Interactors\InteractableInterface $interactable, Web\Lesplan\Factory $interaction): \Teach\Interactors\LayoutableInterface
    {
        return $interactable->createInteractor($interaction);
    }
}