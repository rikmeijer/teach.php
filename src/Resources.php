<?php namespace rikmeijer\Teach;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\OAuth1\Client\Credentials\TokenCredentials;
use League\OAuth1\Client\Server\User;
use pulledbits\ActiveRecord\SQL\Connection;
use pulledbits\View\Directory;

class Resources
{
    private $resourcesPath;

    static $session;
    static $sso;

    public function __construct(string $resourcesPath)
    {
        $this->resourcesPath = $resourcesPath;
    }

    public function routes() : array {
        $session = $this->session();
        $user = $this->userForToken();
        $schema = $this->schema();
        $phpviewDirectory = $this->phpviewDirectory('');
        return [
            new Routes\Feedback\SupplyFactoryFactory($schema, $this->assets(), $this->phpviewDirectory('feedback'), $session),
            new Routes\FeedbackFactoryFactory($schema, $phpviewDirectory),
            new Routes\RatingFactoryFactory($schema, $phpviewDirectory, $this->readAssetStar(), $this->readAssetUnstar()),
            new Routes\Contactmoment\ImportFactoryFactory($schema, $this->iCalReaderFactory(), $user, $this->phpviewDirectory('contactmoment')),
            new Routes\QrFactoryFactory($phpviewDirectory),
            new Routes\SSO\CallbackFactoryFactory($session, $this->sso()),
            new Routes\LogoutFactoryFactory($session),
            new Routes\IndexFactoryFactory($user, $schema, $phpviewDirectory)
        ];
    }

    private function schema(): \pulledbits\ActiveRecord\Schema
    {
        $config = require $this->resourcesPath . DIRECTORY_SEPARATOR . 'config.php';
        $pdo = new \PDO($config['DB_CONNECTION'] . ':', $config['DB_USERNAME'], $config['DB_PASSWORD'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        $connection = new Connection($pdo);
        return $connection->schema($config['DB_DATABASE']);
    }

    private function assets() : FilesystemInterface {
        return new Filesystem(new Local($this->assetsDirectory()));
    }

    private function assetsDirectory()
    {
        return $this->resourcesPath . DIRECTORY_SEPARATOR . 'assets';
    }

    private function readAssetStar()
    {
        $image = $this->assetsDirectory() . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'star.png';
        return file_get_contents($image);
    }

    private function readAssetUnstar()
    {
        $image = $this->assetsDirectory() . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'unstar.png';
        return file_get_contents($image);
    }

    private function session(): \Aura\Session\Session
    {
        if (isset(self::$session) === false) {
            $session_factory = new \Aura\Session\SessionFactory;
            self::$session = $session_factory->newInstance($_COOKIE);
        }
        return self::$session;
    }

    private function sso(): \Avans\OAuth\Web
    {
        if (isset(self::$sso) === false) {
            self::$sso = require $this->resourcesPath . DIRECTORY_SEPARATOR . 'sso.php';
        }
        return self::$sso;
    }

    private function phpviewDirectory(string $templatesDirectory) {
        $directory = new Directory($this->resourcesPath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $templatesDirectory, $this->resourcesPath . DIRECTORY_SEPARATOR . 'layouts');

        $session = $this->session();
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

    private function iCalReaderFactory(): callable
    {
        return function (string $uri) : \ICal {
            return new \ICal($uri);
        };
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
}