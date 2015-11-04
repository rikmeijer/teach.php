<?php
namespace Teach\Adapters\Web\Lesplan;

final class Factory
{
    /**
     * 
     * @param string $caption
     * @param array $werkvorm
     * @return \Teach\Adapters\Web\Lesplan\Activiteit
     */
    public function createActiviteit($caption, array $werkvorm)
    {
        return new Activiteit($caption, $werkvorm);
    }
}