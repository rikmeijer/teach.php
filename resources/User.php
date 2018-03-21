<?php

namespace rikmeijer\Teach;

use Aura\Session\Segment;
use League\OAuth1\Client\Server\Server;

class User
{
    private $server;
    private $sessionToken;

    public function __construct(\Avans\OAuth\Web $server, Segment $sessionToken)
    {
        $this->server = $server;
        $this->sessionToken = $sessionToken;
    }

    private function details(): \League\OAuth1\Client\Server\User
    {
        $details = unserialize($this->sessionToken->get('user'));
        if (!($details instanceof \League\OAuth1\Client\Server\User)) {
            $tokenCredentialsSerialized = $this->sessionToken->get('credentials');
            if ($tokenCredentialsSerialized === null) {
                $this->authorize();
                exit;
            }
            $token = unserialize($tokenCredentialsSerialized);

            $details = $this->server->getUserDetails($token);
            $this->sessionToken->set('user', serialize($this->details));
        }
        return $details;
    }

    public function isEmployee()
    {
        return $this->details()->extra['employee'];
    }

    public function getID()
    {
        return $this->details()->uid;
    }

    private function authorize(): void
    {
        $temporaryCredentialsSerialized = $this->sessionToken->get('temporary_credentials');
        if ($temporaryCredentialsSerialized === null) {
            $temporaryCredentialsSerialized = serialize($this->server->getTemporaryCredentials());
            $this->sessionToken->set('temporary_credentials', $temporaryCredentialsSerialized);
        }
        $this->server->authorize(unserialize($temporaryCredentialsSerialized));
    }
}