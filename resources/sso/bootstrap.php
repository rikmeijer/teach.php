<?php namespace rikmeijer\Teach;
// ID: 299

use Aura\Session\Session;

class SSO {

    private $sessionToken;
    private $server;

    public function __construct(Session $session)
    {
        $config = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config.php';
        $this->server = new \Avans\OAuth\Web($config['SSO']);
        $this->sessionToken = $session->getSegment('token');
    }

    public function acquireTemporaryCredentials() : void
    {
        $temporaryCredentials = $this->server->getTemporaryCredentials();
        $this->sessionToken->set('temporary_credentials', serialize($temporaryCredentials));
        $this->server->authorize($temporaryCredentials);
    }

    public function authorizeTokenCredentials(string $oauthToken, string $oauthVerifier) : void
    {
        $temporaryCredentialsSerialized = $this->sessionToken->get('temporary_credentials');
        if ($temporaryCredentialsSerialized !== null) {
            $temporaryCredentials = unserialize($temporaryCredentialsSerialized);
            $tokenCredentials = $this->server->getTokenCredentials($temporaryCredentials, $oauthToken, $oauthVerifier);
            $this->sessionToken->set('temporary_credentials', null);
            $this->sessionToken->set('credentials', serialize($tokenCredentials));
        }
    }

    public function getUserDetails()
    {
        $details = unserialize($this->sessionToken->get('user'));
        if (!($details instanceof \League\OAuth1\Client\Server\User)) {
            $tokenCredentialsSerialized = $this->sessionToken->get('credentials');
            if ($tokenCredentialsSerialized === null) {
                header('Location: /sso/authorize', true, 302);
                exit;
            }
            $token = unserialize($tokenCredentialsSerialized);

            $details = $this->server->getUserDetails($token);
            $this->sessionToken->set('user', serialize($details));
        }
        return $details;
    }
}