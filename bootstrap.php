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
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }
}

namespace rikmeijer\Teach {

    use League\OAuth1\Client\Credentials\TokenCredentials;
    use League\OAuth1\Client\Server\User;
    use pulledbits\View\Directory;

    require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

    class Bootstrap
    {
        private $resourcesPath = __DIR__ . DIRECTORY_SEPARATOR . 'resources';

        static $sso;

        public function router(): \pulledbits\Router\Router
        {
            $session = $this->session();
            $user = $this->userForToken();
            $schema = $this->schema();
            $assets = $this->assets();
            $phpviewDirectory = $this->phpviewDirectory('');

            return new \pulledbits\Router\Router([
                new Routes\Feedback\SupplyFactoryFactory($schema, $assets, $this->phpviewDirectory('feedback'), $session),
                new Routes\FeedbackFactoryFactory($schema, $phpviewDirectory),
                new Routes\RatingFactoryFactory($schema, $phpviewDirectory, $assets),
                new Routes\Contactmoment\ImportFactoryFactory($schema, $this->iCalReader(), $user, $this->phpviewDirectory('contactmoment')),
                new Routes\QrFactoryFactory($phpviewDirectory),
                new Routes\SSO\CallbackFactoryFactory($session, $this->sso()),
                new Routes\LogoutFactoryFactory($session),
                new Routes\IndexFactoryFactory($user, $schema, $phpviewDirectory)
            ]);
        }

        private function schema(): \pulledbits\ActiveRecord\Schema {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'connection.php';
        }

        private function assets() : \League\Flysystem\FilesystemInterface {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'assets.php';
        }

        private function session(): \Aura\Session\Session {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'session.php';
        }

        private function sso(): \Avans\OAuth\Web
        {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'sso.php';
        }

        private function iCalReader(): \ICal
        {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'ical.php';
        }

        private function phpviewDirectory(string $templatesDirectory) {
            $directory = new Directory($this->resourcesPath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $templatesDirectory, $this->resourcesPath . DIRECTORY_SEPARATOR . 'layouts');

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

            $session = $this->session();
            $directory->registerHelper('form', function (string $method, string $submitValue, string $model) use ($session) : void {
                ?>
                <form method="<?= $this->escape($method); ?>">
                    <input type="hidden" name="__csrf_value" value="<?= $this->escape($session->getCsrfToken()->getValue()); ?>"/>
                    <?= $model; ?>
                    <input type="submit" value="<?= $this->escape($submitValue); ?>"/>
                </form>
                <?php
            });
            $directory->registerHelper('qr', function(int $width, int $height, string $data) : void {
                $renderer = new \BaconQrCode\Renderer\Image\Png();
                $renderer->setHeight($width);
                $renderer->setWidth($height);
                $writer = new \BaconQrCode\Writer($renderer);
                print $writer->writeString($data);
            });
            return $directory;
        }

        private function authorize() : void
        {
            $session = $this->session();
            $sessionToken = $session->getSegment('token');
            $temporaryCredentialsSerialized = $sessionToken->get('temporary_credentials');
            $server = $this->sso();
            if ($temporaryCredentialsSerialized === null) {
                $temporaryCredentialsSerialized = serialize($server->getTemporaryCredentials());
                $this->session()->getSegment('token')->set('temporary_credentials', $temporaryCredentialsSerialized);
            }
            $server->authorize(unserialize($temporaryCredentialsSerialized));
        }

        private function token() : TokenCredentials
        {
            $session = $this->session();
            $sessionToken = $session->getSegment('token');
            $tokenCredentialsSerialized = $sessionToken->get('credentials');
            if ($tokenCredentialsSerialized === null) {
                $this->authorize();
                exit;
            }
            return unserialize($tokenCredentialsSerialized);
        }

        private function userForToken() : callable
        {
            $resources = $this;
            return function()  use ($resources) : User {
                $session = $this->session();
                $sessionToken = $session->getSegment('token');

                /**
                 * @var $user User
                 */
                $user = unserialize($sessionToken->get('user'));
                if (true || !($user instanceof User)) {
                    $server = $resources->sso();
                    $user = $server->getUserDetails($resources->token());
                    $sessionToken->set('user', serialize($user));
                }
                return $user;
            };
        }
    };

    return new Bootstrap();
}