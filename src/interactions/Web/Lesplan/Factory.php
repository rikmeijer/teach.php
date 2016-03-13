<?php
namespace Teach\Interactions\Web\Lesplan;

final class Factory
{
    public function createTable($caption, array $rows)
    {
        return new \Teach\Interactions\Web\Document\Table($caption, $rows);
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