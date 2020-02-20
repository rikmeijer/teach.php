<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Avans\Rooster;
use PHPUnit\Framework\TestCase;

class RoosterTest extends TestCase
{
    final public function testWhen_EventsImported_Expect_ListOfContactmomenten(): void
    {
        $object = new Rooster();
        $this->assertCount(0, $object->import());
    }
}
