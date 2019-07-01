<?php

namespace rikmeijer\Teach;

use Aura\Session\Session;
use Auth0\SDK\Auth0;
use pulledbits\Bootstrap\Bootstrap;
use TheCodingMachine\TDBM\TDBMService;

final class User
{
    /**
     * @var Session
     */
    private $session;

    private $oauth;

    /**
     * @var Auth0
     */
    private $auth0;

    /**
     * @var Calendar
     */
    private $calendar;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->session = $bootstrap->resource('session');
        $this->calendar = $bootstrap->resource('calendar');
        $this->auth0 = $bootstrap->resource('auth0');
        $this->oauth = $bootstrap->resource('oauth');
    }

    private function details(): \League\OAuth1\Client\Server\User
    {
        $sessionToken = $this->session->getSegment('token');
        $details = unserialize($sessionToken->get('user'), [\League\OAuth1\Client\Server\User::class]);
        if (!($details instanceof \League\OAuth1\Client\Server\User)) {
            $tokenCredentialsSerialized = $sessionToken->get('credentials');
            if ($tokenCredentialsSerialized === null) {
                header('Location: /sso/authorize', true, 302);
                exit;
            }
            $token = unserialize($tokenCredentialsSerialized, [TokenCredentials::class]);

            $details = $this->oauth->getUserDetails($token);
            $sessionToken->set('user', serialize($details));
        }
        return $details;
    }

    public function acquireTemporaryCredentials() {
        $temporaryCredentials = $this->oauth->getTemporaryCredentials();
        $this->session->getSegment('token')->set('temporary_credentials', serialize($temporaryCredentials));
        return $this->oauth->getAuthorizationUrl($temporaryCredentials);
    }


    public function authorizeTokenCredentials(string $oauthToken, string $oauthVerifier): void
    {
        $temporaryCredentialsSerialized = $this->session->getSegment('token')->get('temporary_credentials');
        if ($temporaryCredentialsSerialized !== null) {
            $temporaryCredentials = unserialize($temporaryCredentialsSerialized, [TemporaryCredentials::class]);
            $tokenCredentials = $this->oauth->getTokenCredentials($temporaryCredentials, $oauthToken, $oauthVerifier);
            $this->session->getSegment('token')->set('temporary_credentials', null);
            $this->session->getSegment('token')->set('credentials', serialize($tokenCredentials));
        }
    }
    public function logout(): void
    {
        $this->session->destroy();
    }

    public function __get($name)
    {
        return $this->details()->$name;
    }

    public function __set($name, $value)
    {
        trigger_error('Can not write SSO', E_USER_ERROR);
    }
    public function __isset($name)
    {
        $details = $this->details();
        return isset($details->$name);
    }


    public function importCalendarEvents(): int
    {
        if ($this->details()->extra['employee'] === false) {
            return 0;
        }

        $userId = $this->details()->uid;
        return $this->calendar->importICal($userId, 'http://rooster.avans.nl/gcal/D' . $userId);
    }
}
