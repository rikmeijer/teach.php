<?php
namespace Teach\Domain\Lesplan;

class Thema implements \Teach\Domain\Documentable
{

    /**
     *
     * @var string
     */
    private $title;

    /**
     *
     * @var Activiteit
     */
    private $ervaren;

    /**
     *
     * @var Activiteit
     */
    private $reflecteren;

    /**
     *
     * @var Activiteit
     */
    private $conceptualiseren;

    /**
     *
     * @var Activiteit
     */
    private $toepassen;

    public function __construct(string $title, Activiteit $ervaren, Activiteit $reflecteren, Activiteit $conceptualiseren, Activiteit $toepassen)
    {
        $this->title = $title;
        $this->ervaren = $ervaren;
        $this->reflecteren = $reflecteren;
        $this->conceptualiseren = $conceptualiseren;
        $this->toepassen = $toepassen;
    }

    public function document(\Teach\Domain\Documenter $documenter): string
    {
        $documenter->push();
        $section = $documenter->makeSection();
        $section->append($documenter->makeHeaderNested($this->title));
        $section->appendHTML(
            $this->ervaren->document($documenter),
            $this->reflecteren->document($documenter),
            $this->conceptualiseren->document($documenter),
            $this->toepassen->document($documenter)
        );
        $documenter->pop();
        return $section->render();
    }
}