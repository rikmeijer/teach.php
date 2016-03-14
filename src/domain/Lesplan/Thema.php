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
        $adapter->push();
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeaderNested($this->title));
        $section->appendHTML(
            $this->ervaren->document($adapter),
            $this->reflecteren->document($adapter),
            $this->conceptualiseren->document($adapter),
            $this->toepassen->document($adapter)
        );
        $adapter->pop();
        return $section->render();
    }
}