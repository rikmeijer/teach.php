<?php
namespace Teach\Adapters\Web\Lesplan;

final class Fase
{
    private $caption;
    
    public function __construct($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return array
     */
    public function generateFirstStep()
    {
        return ['table' => [['class' => 'two-columns'], [
            'caption' => [$this->caption]
        ]]];
    }
}