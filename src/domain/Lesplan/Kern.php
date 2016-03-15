<?php
namespace Teach\Domain\Lesplan;

class Kern implements \Teach\Domain\Documentable
{

    /**
     *
     * @var Thema[]
     */
    private $themas;

    public function __construct(array $themas)
    {
        $this->themas = $themas;
    }

    public function document(\Teach\Domain\Documenter $documenter): string
    {
        $section = $documenter->makeSection();
        $section->append($documenter->makeHeader("2", "Kern"));
        foreach ($this->themas as $thema) {
            $section->appendHTML($thema->document($documenter));
        }
        return $section->render();
    }
}