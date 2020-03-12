<?php declare(strict_types=1);

namespace Tests;

use Dotenv\Dotenv;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    public static function basePath(string $path = ''): string
    {
        return __DIR__ . '/../' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare(): void
    {
        static::startChromeDriver();
    }

    public static function setUpBeforeClass(): void
    {
        copy(self::basePath('.env'), self::basePath('.env.backup'));
        copy(self::basePath('.env.dusk.local'), self::basePath('.env'));
        (Dotenv::create(self::basePath()))->overload();

        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass(): void
    {
        copy(self::basePath('.env.backup'), self::basePath('.env'));
        unlink(self::basePath('.env.backup'));
        (Dotenv::create(self::basePath()))->overload();

        parent::tearDownAfterClass();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return RemoteWebDriver
     */
    final protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(
            [
                '--disable-gpu',
                '--headless',
                '--window-size=1920,1080',
            ]
        );

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }
}
