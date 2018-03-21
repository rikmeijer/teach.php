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
    use League\OAuth1\Client\Server\Server;

    require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

    class Bootstrap
    {
        private $resourcesPath = __DIR__ . DIRECTORY_SEPARATOR . 'resources';

        public function router(): \pulledbits\Router\Router
        {
            $session = $this->session();
            $server = $this->sso();
            $user = $this->userForToken($server, $session->getSegment('token'));
            $schema = $this->schema();
            $assets = $this->assets();
            $phpviewDirectoryFactory = $this->phpviewDirectoryFactory($session);

            return new \pulledbits\Router\Router([
                new Routes\Feedback\SupplyFactoryFactory($schema, $assets, $phpviewDirectoryFactory, $session),
                new Routes\FeedbackFactoryFactory($schema, $phpviewDirectoryFactory),
                new Routes\RatingFactoryFactory($schema, $phpviewDirectoryFactory, $assets),
                new Routes\Contactmoment\ImportFactoryFactory($schema, $this->iCalReader(), $user, $phpviewDirectoryFactory),
                new Routes\QrFactoryFactory($phpviewDirectoryFactory),
                new Routes\SSO\CallbackFactoryFactory($session, $server),
                new Routes\LogoutFactoryFactory($session),
                new Routes\IndexFactoryFactory($user, $schema, $phpviewDirectoryFactory)
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

        private function iCalReader(): \ICal
        {
            return require $this->resourcesPath . DIRECTORY_SEPARATOR . 'ical' . DIRECTORY_SEPARATOR . 'bootstrap.php';
        }

        private function phpviewDirectoryFactory(Session $session) : PHPViewDirectoryFactory {
            require $this->resourcesPath . DIRECTORY_SEPARATOR . 'phpview' . DIRECTORY_SEPARATOR . 'bootstrap.php';
            return new PHPViewDirectoryFactory($session);
        }


        private function userForToken(\Avans\OAuth\Web $server, Segment $sessionToken) : User
        {
            require $this->resourcesPath . DIRECTORY_SEPARATOR . 'User.php';
            return new User($server, $sessionToken);
        }
    };

    return new Bootstrap();
}