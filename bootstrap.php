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

    use Aura\Session\Segment;
    use Aura\Session\Session;
    use League\Flysystem\FilesystemInterface;

    require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

    class Bootstrap
    {
        private $resourcesPath = __DIR__ . DIRECTORY_SEPARATOR . 'resources';

        public function router(): \pulledbits\Router\Router
        {
            $session = $this->session();
            $server = $this->sso();
            $schema = $this->schema();
            $publicAssetsFileSystem = $this->assets();
            $user = $this->userForToken($server, $session, $schema, $publicAssetsFileSystem);
            $phpviewDirectoryFactory = $this->phpviewDirectoryFactory($session);

            return new \pulledbits\Router\Router([
                new Routes\Feedback\SupplyFactoryFactory($user, $phpviewDirectoryFactory),
                new Routes\FeedbackFactoryFactory($user, $phpviewDirectoryFactory),
                new Routes\RatingFactoryFactory($user, $phpviewDirectoryFactory),
                new Routes\Contactmoment\ImportFactoryFactory($user, $phpviewDirectoryFactory),
                new Routes\QrFactoryFactory($phpviewDirectoryFactory),
                new Routes\SSO\CallbackFactoryFactory($user),
                new Routes\LogoutFactoryFactory($user),
                new Routes\IndexFactoryFactory($user, $phpviewDirectoryFactory)
            ]);
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

        private function sso(): \Avans\OAuth\Web
        {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'sso' . DIRECTORY_SEPARATOR . 'bootstrap.php';
        }

        private function phpviewDirectoryFactory(Session $session) : PHPViewDirectoryFactory {
            require $this->resourcesPath . DIRECTORY_SEPARATOR . 'phpview' . DIRECTORY_SEPARATOR . 'bootstrap.php';
            return new PHPViewDirectoryFactory($session);
        }


        private function userForToken(\Avans\OAuth\Web $server, Session $session, \pulledbits\ActiveRecord\Schema $schema, FilesystemInterface $publicAssetsFileSystem) : User
        {
            require $this->resourcesPath . DIRECTORY_SEPARATOR . 'User.php';
            return new User($server, $session, $schema, $publicAssetsFileSystem);
        }
    };

    return new Bootstrap();
}