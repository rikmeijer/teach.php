<?php declare(strict_types=1);

namespace Tests\Unit;

use App\User;
use Sabre\VObject\Component\VCalendar;
use Tests\TestCase;

class UserTest extends TestCase
{
    final public function testReadVCalendar(): void
    {
        $user = new User();

        $calendar = $user->readVCalendar();

        $this->assertInstanceOf(VCalendar::class, $calendar);
    }
}
