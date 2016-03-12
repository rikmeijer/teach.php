<?php
namespace Teach\Interactions\Web\Lesplan;

final class Factory
{

    /**
     *
     * @param string $caption            
     * @param array $werkvorm            
     * @return \Teach\Interactions\Web\Document\Table
     */
    public function createActiviteit($caption, array $werkvorm)
    {
        return $this->createTable($caption, [
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
    
    public function createTable($caption, array $rows)
    {
        return new \Teach\Interactions\Web\Document\Table($caption, $rows);
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
     * @param \Teach\Interactions\Web\Document\Parts $parts            
     * @return \Teach\Interactions\Web\Document\Section
     */
    public function createSection(string $title, \Teach\Interactions\Web\Document\Parts $parts)
    {
        return new \Teach\Interactions\Web\Document\Section($title, $parts);
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