<?php
require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

return new class implements \rikmeijer\Teach\Bootstrap
{
    public function route(\Psr\Http\Message\ServerRequestInterface $request) : \Aura\Router\Route {
        $routerContainer = new \Aura\Router\RouterContainer();
        $map = $routerContainer->getMap();

        $routes = [];
        foreach (glob(__DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . '*.php') as $routeFile) {
            $routeFactory = require $routeFile;
            $routes[] = $routeFactory($map);
        }

        return $routerContainer->getMatcher()->match($request);
    }

    public function responseFactory() : callable {
        return function(int $status, string $body) : \Psr\Http\Message\ResponseInterface {
            return (new \GuzzleHttp\Psr7\Response($status))->withBody(\GuzzleHttp\Psr7\stream_for($body));
        };
    }

    public function request(): \Psr\Http\Message\ServerRequestInterface
    {
        return \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
    }

    public function resources() : \rikmeijer\Teach\Resources
    {
        return new class implements \rikmeijer\Teach\Resources
        {
            private $resources;

            public function __construct()
            {
                $this->resources = require __DIR__ . DIRECTORY_SEPARATOR . 'resources.php';
            }

            public function schema(): \pulledbits\ActiveRecord\SQL\Schema
            {
                /**
                 * @var $factory \pulledbits\ActiveRecord\RecordFactory
                 */
                $factory = new \pulledbits\ActiveRecord\RecordFactory(__DIR__ . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'activerecord');
                return new \pulledbits\ActiveRecord\SQL\Schema($factory,
                    new \PDO($this->resources['DB_CONNECTION'] . ':host=' . $this->resources['DB_HOST'] . ';dbname=' . $this->resources['DB_DATABASE'],
                        $this->resources['DB_USERNAME'], $this->resources['DB_PASSWORD'],
                        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')));
            }

            public function session(): \Aura\Session\Session
            {
                $session_factory = new \Aura\Session\SessionFactory;
                return $session_factory->newInstance($_COOKIE);
            }

            private function assetsDirectory()
            {
                return __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'assets';
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
                $template = new pulledbits\View\File\Template(__DIR__ . "/resources/views/" . $templateIdentifier . '.php',
                    __DIR__ . '/resources/layouts', __DIR__ . "/storage/views");
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
        };
    }
};