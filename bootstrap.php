<?php

namespace {


    define('NAMESPACE_SEPARATOR', '\\');

    function get_class_shortname($object) {
        $classname = get_class($object);
        return (substr($classname, strrpos($classname, '\\') + 1));
    }

    function get_absolute_path($path) {
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            if ('.' === $part) continue;
            if ('..' === $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }
}

namespace rikmeijer\Teach {

    use Aura\Session\Session;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\SimpleCache\CacheInterface;
    use pulledbits\Router\ErrorFactory;
    use pulledbits\Router\RouteEndPoint;


    final class Bootstrap
    {
        private $autoloader;
        private $resourcesPath;

        public function __construct()
        {
            $this->autoloader = require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
            $this->resourcesPath = __DIR__ . DIRECTORY_SEPARATOR . 'resources';
        }

        public function router(): \pulledbits\Router\Router
        {
            $server = $this->sso();
            $schema = $this->schema();

            $user = $this->userForToken();
            $phpviewDirectoryFactory = $this->phpviewDirectoryFactory();

            $calendarGUI = new GUI\Calendar($server, $schema);
            $indexGUI = new GUI\Index($server, $schema);

            return new \pulledbits\Router\Router([
                '^/feedback/(?<contactmomentIdentifier>\d+)/supply$' => GUI\Feedback::supply($this),
                '^/feedback/(?<contactmomentIdentifier>\d+)' => GUI\Feedback::view($this),
                '^/rating/(?<value>(N|[\d\.]+))$' => GUI\Rating::view($this),
                '^/contactmoment/import$' => function(ServerRequestInterface $request) use ($user, $phpviewDirectoryFactory) : RouteEndPoint
                {
                    $phpviewDirectory = $phpviewDirectoryFactory->make('contactmoment');
                    switch ($request->getMethod()) {
                        case 'GET':
                            return new PHPviewEndPoint($phpviewDirectory->load('import', [
                                'importForm' => function (): void {
                                    $this->form("post", "Importeren", 'rooster.avans.nl');
                                }
                            ]));

                        case 'POST':
                            return new PHPviewEndPoint($phpviewDirectory->load('imported', [
                                "numberImported" => $user->importCalendarEvents()
                            ]));

                        default:
                            return ErrorFactory::makeInstance('405');
                    }

                },
                '^/qr' => function(ServerRequestInterface $request) use ($phpviewDirectoryFactory): RouteEndPoint
                {
                    $phpviewDirectory = $phpviewDirectoryFactory->make('');

                    $query = $request->getQueryParams();
                    if (array_key_exists('data', $query) === false) {
                        syslog(E_USER_ERROR, 'Query incomplete');
                        return ErrorFactory::makeInstance('400');
                    } elseif ($query['data'] === null) {
                        syslog(E_USER_ERROR, 'Query data incomplete');
                        return ErrorFactory::makeInstance('400');
                    }
                    return new PHPviewEndPoint($phpviewDirectory->load('qr', [
                        'data' => $query['data'],
                        'qr' => function (int $width, int $height, string $data): void {
                            $renderer = new \BaconQrCode\Renderer\Image\Png();
                            $renderer->setHeight($width);
                            $renderer->setWidth($height);
                            $writer = new \BaconQrCode\Writer($renderer);
                            print $writer->writeString($data);
                        }
                    ]));
                },
                '^/sso/authorize' => function(ServerRequestInterface $request) use ($server): RouteEndPoint
                {
                    return new Routes\SSO\Authorize\TemporaryTokenCredentialsAcquisitionFactory($server);
                },
                '^/sso/callback' => function(ServerRequestInterface $request) use ($server): RouteEndPoint
                {
                    $queryParams = $request->getQueryParams();

                    if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
                        return new Routes\SSO\Callback\TokenAuthorizationFactory($server, $queryParams['oauth_token'], $queryParams['oauth_verifier']);
                    } else {
                        return ErrorFactory::makeInstance(400);
                    }
                },
                '^/logout' => function(ServerRequestInterface $request) use ($user): RouteEndPoint
                {
                    $user->logout();
                    return new SeeOtherEndPoint('/');
                },
                '^/calendar/(?<calendarIdentifier>[^/]+)' => function(ServerRequestInterface $request) use ($calendarGUI, $phpviewDirectoryFactory): RouteEndPoint
                {
                    $phpviewDirectory = $phpviewDirectoryFactory->make('');

                    $calendar = $calendarGUI->retrieveCalendar($request->getAttribute('calendarIdentifier'));
                    return new CalendarEndPoint(new PHPviewEndPoint($phpviewDirectory->load('calendar', ['calendar' => $calendar])), $request->getAttribute('calendarIdentifier'));
                },
                '^/' => function(ServerRequestInterface $request) use ($indexGUI, $phpviewDirectoryFactory): RouteEndPoint
                {
                    $phpviewDirectory = $phpviewDirectoryFactory->make('');

                    return new PHPviewEndPoint($phpviewDirectory->load('welcome', [
                        'modules' => $indexGUI->retrieveModules(),
                        'contactmomenten' => $indexGUI->retrieveContactmomenten()
                    ]));
                }
            ]);
        }

        public function cache() : CacheInterface {
            static $cache;
            if (isset($cache)) {
                return $cache;
            }
            return $cache = require $this->resourcesPath . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'bootstrap.php';
        }

        public function schema(): \pulledbits\ActiveRecord\Schema {
            static $schema;
            if (isset($schema)) {
                return $schema;
            }
            return $schema = require $this->resourcesPath . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'bootstrap.php';
        }

        public function assets() : \League\Flysystem\FilesystemInterface {
            static $assets;
            if (isset($assets)) {
                return $assets;
            }
            return $assets = require $this->resourcesPath . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'bootstrap.php';
        }

        public function session(): \Aura\Session\Session {
            static $session;
            if (isset($session)) {
                return $session;
            }
            return $session = require $this->resourcesPath . DIRECTORY_SEPARATOR . 'session' . DIRECTORY_SEPARATOR . 'bootstrap.php';
        }

        public function sso(): SSO
        {
            static $sso;
            if (!isset($sso)) {
                $server = require $this->resourcesPath . DIRECTORY_SEPARATOR . 'sso' . DIRECTORY_SEPARATOR . 'bootstrap.php';
                $sso = new SSO($server, $this->session());
            }
            return $sso;
        }

        public function phpviewDirectoryFactory() : PHPViewDirectoryFactory {
            require_once $this->resourcesPath . DIRECTORY_SEPARATOR . 'phpview' . DIRECTORY_SEPARATOR . 'bootstrap.php';
            return new PHPViewDirectoryFactory($this->session());
        }


        public function userForToken() : User
        {
            return new User($this->sso(), $this->session(), $this->schema());
        }
    };

    return new Bootstrap();
}