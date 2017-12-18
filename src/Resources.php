<?php namespace rikmeijer\Teach;

use League\OAuth1\Client\Credentials\TemporaryCredentials;
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

    public function schema(): \pulledbits\ActiveRecord\Schema
    {
        $config = require $this->resourcesPath . DIRECTORY_SEPARATOR . 'config.php';
        $pdo = new \PDO($config['DB_CONNECTION'] . ':', $config['DB_USERNAME'], $config['DB_PASSWORD'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        $connection = new Connection($pdo);
        return $connection->schema($config['DB_DATABASE']);
    }

    private function assetsDirectory()
    {
        return $this->resourcesPath . DIRECTORY_SEPARATOR . 'assets';
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

    public function session(): \Aura\Session\Session
    {
        if (isset(self::$session) === false) {
            $session_factory = new \Aura\Session\SessionFactory;
            self::$session = $session_factory->newInstance($_COOKIE);
        }
        return self::$session;
    }

    public function sso(): \Avans\OAuth\Web
    {
        if (isset(self::$sso) === false) {
            self::$sso = require $this->resourcesPath . DIRECTORY_SEPARATOR . 'sso.php';
        }
        return self::$sso;
    }

    private function phpviewDirectory(string $templatesDirectory) {
        $directory = new Directory($templatesDirectory, $this->resourcesPath . DIRECTORY_SEPARATOR . 'layouts');

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

    public function phpview(string $templateIdentifier) : \pulledbits\View\Template {
        $directory = $this->phpviewDirectory($this->resourcesPath . DIRECTORY_SEPARATOR . 'views');
        return $directory->load($templateIdentifier);
    }

    public function iCalReader(string $uri): \ICal
    {
        return new \ICal($uri);
    }

    public function temporaryCredentials() : TemporaryCredentials
    {
        $session = $this->session();
        $sessionToken = $session->getSegment('token');
        $temporaryCredentialsSerialized = $sessionToken->get('temporary_credentials');
        if ($temporaryCredentialsSerialized === null) {
            $server = $this->sso();
            $temporaryCredentialsSerialized = serialize($server->getTemporaryCredentials());
            $this->session()->getSegment('token')->set('temporary_credentials', $temporaryCredentialsSerialized);
        }
        return unserialize($temporaryCredentialsSerialized);
    }

    public function token() : TokenCredentials
    {
        $session = $this->session();
        $sessionToken = $session->getSegment('token');
        $tokenCredentialsSerialized = $sessionToken->get('credentials');
        if ($tokenCredentialsSerialized === null) {
            $temporaryCredentials = $this->temporaryCredentials();
            $server = $this->sso();
            $url = $server->getAuthorizationUrl($temporaryCredentials);
            header('Location: '.$url);
            exit;
        }
        return unserialize($tokenCredentialsSerialized);

    }

    public function userForToken(TokenCredentials $token) : User
    {
        $session = $this->session();
        $sessionToken = $session->getSegment('token');

        /**
         * @var $user User
         */
        $user = unserialize($sessionToken->get('user'));
        if (true || !($user instanceof User)) {
            $server = $this->sso();
            $user = $server->getUserDetails($token);
            $sessionToken->set('user', serialize($user));
        }
        return $user;
    }
}