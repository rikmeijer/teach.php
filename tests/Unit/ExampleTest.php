<?php
declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PDO;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    final public function testBasicTest(): void
    {
        $this->assertTrue(true);
    }

    final public function testDatabaseConnection(): void
    {
        $this->assertInstanceOf(PDO::class, DB::connection()->getPdo());
    }
}
