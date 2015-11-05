<?php
namespace Teach\Adapters\Web\Lesplan;

final class Kern implements \Teach\Adapters\HTML\LayoutableInterface
{
    /**
     *
     * @var \Teach\Adapters\Web\Lesplan\Fase
     */
    private $fase;
    
    /**
     *
     * @var \Teach\Adapters\Web\Lesplan\Thema[string]
     */
    private $themas;
    
    public function __construct(Fase $fase)
    {
        $this->fase = $fase;
    }

    public function addThema($themaIdentifier, Thema $thema)
    {
        $this->themas[$themaIdentifier] = $thema;
        $this->fase->addOnderdeel($thema);
    }
    
    /**
     *
     * @return array
     */
    public function generateHTMLLayout()
    {
        return $this->fase->generateHTMLLayout();
    }
}