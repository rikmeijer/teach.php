<?php
namespace Teach\Interactions\Web\Lesplan;

final class Factory
{

    /**
     *
     * @param string $caption            
     * @param array $werkvorm            
     * @return \Teach\Interactions\Web\Lesplan\Activiteit
     */
    public function createActiviteit($caption, array $werkvorm)
    {
        return new \Teach\Interactions\Web\Document\Table($caption, [
            [
                'werkvorm' => $werkvorm['werkvorm'],
                'organisatievorm' => $werkvorm['organisatievorm']
            ],
            [
                'tijd' => $werkvorm['tijd'] . ' minuten',
                'soort werkvorm' => $werkvorm['werkvormsoort']
            ],
            [
                'intelligenties' => $werkvorm['intelligenties']
            ],
            [
                'inhoud' => $werkvorm['inhoud']
            ]
        ]);
    }

    /**
     * 
     * @param string $title
     * @param \Teach\Interactions\Web\Document\Parts $parts
     * @return \Teach\Interactions\Web\Document\Section
     */
    public function createSection(string $title, \Teach\Interactions\Web\Document\Parts $parts)
    {
        return new \Teach\Interactions\Web\Document\Section($title, $parts);
    }

    /**
     * 
     * @param \Teach\Interactions\Documentable $activerendeOpening
     * @param \Teach\Interactions\Documentable $focus
     * @param \Teach\Interactions\Documentable $voorstellen
     * @param \Teach\Interactions\Documentable $kennismaken
     * @param \Teach\Interactions\Documentable $terugblik
     * @return \Teach\Interactions\Web\Document\Section
     */
    public function createIntroductie(\Teach\Interactions\Documentable $activerendeOpening, \Teach\Interactions\Documentable $focus, \Teach\Interactions\Documentable $voorstellen, \Teach\Interactions\Documentable $kennismaken, \Teach\Interactions\Documentable $terugblik)
    {
        $parts = $this->createDocumentParts($activerendeOpening, $focus, $voorstellen, $kennismaken, $terugblik);
        $fase = $this->createSection("Introductie", $parts);
        return $fase;
    }

    /**
     * 
     * @param \Teach\Interactions\Documentable $huiswerk
     * @param \Teach\Interactions\Documentable $feedback
     * @param \Teach\Interactions\Documentable $pakkendSlot
     * @return \Teach\Interactions\Web\Document\Section
     */
    public function createAfsluiting(\Teach\Interactions\Documentable $huiswerk, \Teach\Interactions\Documentable $feedback, \Teach\Interactions\Documentable $pakkendSlot)
    {
        $parts = $this->createDocumentParts($huiswerk, $feedback, $pakkendSlot);
        $fase = $this->createSection("Afsluiting", $parts);
        return $fase;
    }

    /**
     *
     * @param string $les            
     * @param array $beginsituatie            
     * @param array $media            
     * @param array $leerdoelen            
     * @return \Teach\Interactions\Web\Lesplan\Beginsituatie
     */
    public function createBeginsituatie(string $les, array $beginsituatie, array $media, array $leerdoelen)
    {
        return new Beginsituatie($les, $beginsituatie, $media, $leerdoelen);
    }

    /**
     * 
     * @param \Teach\Interactions\Documentable ...$parts
     * @return \Teach\Interactions\Web\Lesplan\Document\Parts
     */
    public function createDocumentParts(\Teach\Interactions\Documentable ...$parts)
    {
        return new \Teach\Interactions\Web\Document\Parts(...$parts);
    }

    /**
     * 
     * @param string $title
     * @param string $subtitle
     * @param \Teach\Interactions\Web\Document\Parts $parts
     * @return \Teach\Interactions\Web\Document
     */
    public function createDocument(string $title, string $subtitle, \Teach\Interactions\Web\Document\Parts $parts)
    {
        return new \Teach\Interactions\Web\Document($title, $subtitle, $parts);
    }
}