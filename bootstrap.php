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
            $session = $this->session();
            $server = $this->sso($session);
            $schema = $this->schema();
            $publicAssetsFileSystem = $this->assets();
            $cache = $this->cache();
            $user = $this->userForToken($server, $session, $schema);
            $phpviewDirectoryFactory = $this->phpviewDirectoryFactory($session);

            $feedbackGUI = new GUI\Feedback($session, $schema);
            $calendarGUI = new GUI\Calendar($server, $schema);
            $indexGUI = new GUI\Index($server, $schema);

            return new \pulledbits\Router\Router([
                '^/feedback/(?<contactmomentIdentifier>\d+)/supply$' => function(ServerRequestInterface $request) use ($feedbackGUI, $phpviewDirectoryFactory): RouteEndPoint {
                    $phpviewDirectory = $phpviewDirectoryFactory->make('feedback');
                    $contactmoment = $feedbackGUI->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
                    if ($contactmoment->id === null) {
                        return ErrorFactory::makeInstance('404');
                    }

                    switch ($request->getMethod()) {
                        case 'GET':
                            $ipRating = $contactmoment->findRatingByIP(($request->getServerParams())['REMOTE_ADDR']);

                            $query = $request->getQueryParams();
                            if (array_key_exists('rating', $query)) {
                                $rating = $query['rating'];
                            } else {
                                $rating = $ipRating->waarde;
                            }

                            return new PHPviewEndPoint($phpviewDirectory->load('supply', ['rating' => $rating, 'explanation' => $ipRating->inhoud]));

                        case 'POST':
                            $parsedBody = $request->getParsedBody();
                            if ($feedbackGUI->verifyCSRFToken($parsedBody['__csrf_value']) === false) {
                                return ErrorFactory::makeInstance('403');
                            }
                            $contactmoment->rate($_SERVER['REMOTE_ADDR'], $parsedBody['rating'], $parsedBody['explanation']);
                            return new PHPviewEndPoint($phpviewDirectory->load('processed'));

                        default:
                            return ErrorFactory::makeInstance('405');
                    }

                },
                '^/feedback/(?<contactmomentIdentifier>\d+)' => function(ServerRequestInterface $request) use ($feedbackGUI, $phpviewDirectoryFactory): RouteEndPoint
                {
                    $phpviewDirectory = $phpviewDirectoryFactory->make('');

                    $contactmoment = $feedbackGUI->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
                    if ($contactmoment->id === null) {
                        return ErrorFactory::makeInstance(404);
                    }
                    return new PHPviewEndPoint($phpviewDirectory->load('feedback', [
                        'contactmoment' => $contactmoment
                    ]));
                },
                '^/rating/(?<value>(N|[\d\.]+))$' => function(ServerRequestInterface $request) use ($cache, $publicAssetsFileSystem, $phpviewDirectoryFactory): RouteEndPoint
                {
                    $phpviewDirectory = $phpviewDirectoryFactory->make('');

                    $eTag = md5(($request->getAttribute('value') === 'N' ? null : $request->getAttribute('value')).'500'.'100'.'5');

                    if ($cache->has($eTag) === false) {
                        $cache->set($eTag, new \DateTime());
                    }

                    return new CachedEndPoint(new ImagePngEndPoint(new PHPviewEndPoint($phpviewDirectory->load('rating', [
                        'ratingwaarde' => $request->getAttribute('value') == 'N' ? null : $request->getAttribute('value'),
                        'ratingWidth' => 500,
                        'ratingHeight' => 100,
                        'repetition' => 5,
                        'star' =>  $publicAssetsFileSystem->read('img' . DIRECTORY_SEPARATOR . 'star.png'),
                        'unstar' => $publicAssetsFileSystem->read('img' . DIRECTORY_SEPARATOR . 'unstar.png'),
                        'nostar' => $publicAssetsFileSystem->read('img' . DIRECTORY_SEPARATOR . 'nostar.png')
                    ]))), $cache->get($eTag), $eTag);
                },
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

        private function cache() : CacheInterface {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'bootstrap.php';
        }

        private function schema(): \pulledbits\ActiveRecord\Schema {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'bootstrap.php';
        }

        private function assets() : \League\Flysystem\FilesystemInterface {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'bootstrap.php';
        }

        private function session(): \Aura\Session\Session {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'session' . DIRECTORY_SEPARATOR . 'bootstrap.php';
        }

        private function sso(Session $session): SSO
        {
            $server = require $this->resourcesPath . DIRECTORY_SEPARATOR . 'sso' . DIRECTORY_SEPARATOR . 'bootstrap.php';
            return new SSO($server, $session);
        }

        private function phpviewDirectoryFactory(Session $session) : PHPViewDirectoryFactory {
            require $this->resourcesPath . DIRECTORY_SEPARATOR . 'phpview' . DIRECTORY_SEPARATOR . 'bootstrap.php';
            return new PHPViewDirectoryFactory($session);
        }


        private function userForToken(SSO $server, Session $session, \pulledbits\ActiveRecord\Schema $schema) : User
        {
            return new User($server, $session, $schema);
        }
    };

    return new Bootstrap();
}