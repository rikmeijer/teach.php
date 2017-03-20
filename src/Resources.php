<?php
/**
 * Created by PhpStorm.
 * User: hameijer
 * Date: 22-2-17
 * Time: 9:25
 */
namespace rikmeijer\Teach;

class Resources
{
    private $resourcesPath;

    public function __construct(string $resourcesPath)
    {
        $this->resourcesPath = $resourcesPath;
        $this->resources = require $resourcesPath . DIRECTORY_SEPARATOR . 'config.php';
    }

    public function schema(): \pulledbits\ActiveRecord\SQL\Schema
    {
        /**
         * @var $factory \pulledbits\ActiveRecord\RecordFactory
         */
        $factory = new \pulledbits\ActiveRecord\RecordFactory(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'activerecord');
        return new \pulledbits\ActiveRecord\SQL\Schema($factory,
            new \PDO($this->resources['DB_CONNECTION'] . ':host=' . $this->resources['DB_HOST'] . ';dbname=' . $this->resources['DB_DATABASE'],
                $this->resources['DB_USERNAME'], $this->resources['DB_PASSWORD'],
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')));
    }

    public function session(): \Aura\Session\Session
    {
        $session_factory = new \Aura\Session\SessionFactory;
        return $session_factory->newInstance($_COOKIE);
    }

    private function assetsDirectory()
    {
        return $this->resourcesPath . DIRECTORY_SEPARATOR . 'assets';
    }

    public function readAssetStar()
    {
        $image = $this->assetsDirectory() . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'star.png';
        return file_get_contents($image);
    }

    public function readAssetUnstar()
    {
        $image = $this->assetsDirectory() . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'unstar.png';
        return file_get_contents($image);
    }

    public function phpview($templateIdentifier): \pulledbits\View\Template
    {
        $template = new \pulledbits\View\File\Template($this->resourcesPath . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $templateIdentifier . '.php',
            $this->resourcesPath . DIRECTORY_SEPARATOR . 'layouts');
        $template->registerHelper('url', function (string $path, string ...$unencoded): string {
            if (array_key_exists('HTTPS', $_SERVER) === false) {
                $scheme = 'http';
            } else {
                $scheme = 'https';
            }

            $encoded = array_map('rawurlencode', $unencoded);

            return $scheme . '://' . $_SERVER['HTTP_HOST'] . sprintf($path, ...$encoded);
        });
        $template->registerHelper('form',
            function (string $method, string $csrftoken, string $submitValue, string $model): void {
                ?>
                <form method="<?= $this->escape($method); ?>">
                    <input type="hidden" name="__csrf_value" value="<?= $this->escape($csrftoken); ?>"/>
                    <?= $model; ?>
                    <input type="submit" value="<?= $this->escape($submitValue); ?>"/>
                </form>
                <?php
            });

        return $template;
    }

    public function qrRenderer(int $width, int $height): \BaconQrCode\Renderer\Image\Png
    {
        $renderer = new \BaconQrCode\Renderer\Image\Png();
        $renderer->setHeight($width);
        $renderer->setWidth($height);
        return $renderer;
    }

    public function qrWriter(\BaconQrCode\Renderer\RendererInterface $renderer): \BaconQrCode\Writer
    {
        return new \BaconQrCode\Writer($renderer);
    }

    public function iCalReader(string $uri): \ICal
    {
        return new \ICal($uri);
    }
}