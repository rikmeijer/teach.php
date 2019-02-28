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
    use Psr\SimpleCache\CacheInterface;


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

            return new \pulledbits\Router\Router([
                new Routes\Feedback\SupplyEndPointFactory($feedbackGUI, $phpviewDirectoryFactory),
                new Routes\FeedbackEndPointFactory($feedbackGUI, $phpviewDirectoryFactory),
                new Routes\RatingEndPointFactory($cache, $publicAssetsFileSystem, $phpviewDirectoryFactory),
                new Routes\Contactmoment\ImportEndPointFactory($user, $phpviewDirectoryFactory),
                new Routes\QrEndPointFactory($phpviewDirectoryFactory),
                new Routes\SSO\AuthorizeFactoryFactory($server),
                new Routes\SSO\CallbackFactoryFactory($server),
                new Routes\UserEndPointFactory($user),
                new Routes\CalendarEndPointFactory(new GUI\Calendar($server, $schema), $phpviewDirectoryFactory),
                new Routes\IndexEndPointFactory(new GUI\Index($server, $schema), $phpviewDirectoryFactory)
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