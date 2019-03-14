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

        public function load(string $directory) : void {
            foreach (glob($directory . DIRECTORY_SEPARATOR . '*.php') as $file) {
                $this->bootstrap($file);
            }
        }
        public function bootstrap(string $file) {
            return (require $file)($this);
        }
        public function resource(string $resource) {
            static $resources = [];
            if (array_key_exists($resource, $resources)) {
                return $resources[$resource];
            }
            return $resources[$resource] = $this->bootstrap($this->resourcesPath . DIRECTORY_SEPARATOR . $resource . '.php');
        }

        public function config(string $section) : array {
            return (require __DIR__ . DIRECTORY_SEPARATOR . 'config.php')[$section];
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
            return $this->resource('cache');
        }

        public function schema(): \pulledbits\ActiveRecord\Schema {
            return $this->resource('database');
        }

        public function assets() : \League\Flysystem\FilesystemInterface {
            return $this->resource('assets');
        }

        public function session(): \Aura\Session\Session {
            return $this->resource('session');
        }

        public function oauthServer() {
            return $this->resource('oauth');

        }
        public function sso(): SSO
        {
            return $this->resource('sso');
        }

        public function phpviewDirectoryFactory() : PHPViewDirectoryFactory {
            return $this->resource('phpview');
        }


        public function userForToken() : User
        {
            return new User($this->sso(), $this->session(), $this->schema());
        }
    };

    return new Bootstrap();
}