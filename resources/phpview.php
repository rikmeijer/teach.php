<?php

namespace rikmeijer\Teach;

use Aura\Session\Session;
use pulledbits\View\Directory;

class PHPViewDirectoryFactory
{

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function make(string $templatesDirectory)
    {
        $directory = new Directory(__DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $templatesDirectory, __DIR__ . DIRECTORY_SEPARATOR . 'layouts');

        $directory->registerHelper('url', function (string $path, string ...$unencoded): string {
            $encoded = array_map('rawurlencode', $unencoded);
            if (strpos($path, '.') === 0) {
                $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '/' . $path;
            }

            $path = sprintf(get_absolute_path($path), ...$encoded);
            if (strpos($path, '?') === false) {
                $query = '';
            } else {
                list($path, $query) = explode('?', $path, 2);
            }
            return (string)\GuzzleHttp\Psr7\ServerRequest::getUriFromGlobals()->withPath($path)->withQuery($query);
        });

        $session = $this->session;
        $directory->registerHelper('form', function (string $method, string $submitValue, string $model) use ($session) : void {
            ?>
            <form method="<?= $this->escape($method); ?>">
                <input type="hidden" name="__csrf_value"
                       value="<?= $this->escape($session->getCsrfToken()->getValue()); ?>"/>
                <?= $model; ?>
                <input type="submit" value="<?= $this->escape($submitValue); ?>"/>
            </form>
            <?php
        });
        $directory->registerHelper('qr', function (int $width, int $height, string $data): void {
            $renderer = new \BaconQrCode\Renderer\Image\Png();
            $renderer->setHeight($width);
            $renderer->setWidth($height);
            $writer = new \BaconQrCode\Writer($renderer);
            print $writer->writeString($data);
        });
        return $directory;
    }
}