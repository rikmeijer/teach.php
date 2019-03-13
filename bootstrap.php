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
            static $router;
            if (isset($router)) {
                return $router;
            }
            return $router = new \pulledbits\Router\Router([]);
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