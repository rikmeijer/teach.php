<?php
namespace Teach\Interactions\Web;

final class Factory
{
    public function createTable($caption, array $rows)
    {
        return new Document\Table($caption, $rows);
    }

    /**
     *
     * @param \Teach\Interactions\Documentable ...$parts            
     * @return \Teach\Interactions\Web\Lesplan\Document\Parts
     */
    public function createDocumentParts(\Teach\Interactions\Documentable ...$parts)
    {
        return new Document\Parts(...$parts);
    }

    /**
     *
     * @param string $title            
     * @param \Teach\Interactions\Web\Document\Parts $parts            
     * @return \Teach\Interactions\Web\Document\Section
     */
    public function createSection(string $title, \Teach\Interactions\Web\Document\Parts $parts)
    {
        return new Document\Section($title, $parts);
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
        return new Document($title, $subtitle, $parts);
    }
}