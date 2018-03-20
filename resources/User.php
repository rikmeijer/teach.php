<?php

namespace rikmeijer\Teach;

use Aura\Session\Session;
use League\OAuth1\Client\Server\Server;

class User
{

    private $details;

    public function __construct(Server $server, Session $session)
    {
        $this->server = $server;
        $this->session = $session;
    }

    private function details(): \League\OAuth1\Client\Server\User
    {
        $sessionToken = $this->session->getSegment('token');
        $details = unserialize($sessionToken->get('user'));
        if (!($details instanceof \League\OAuth1\Client\Server\User)) {
            $tokenCredentialsSerialized = $sessionToken->get('credentials');
            if ($tokenCredentialsSerialized === null) {
                $this->authorize();
                exit;
            }
            $token = unserialize($tokenCredentialsSerialized);

            $details = $this->server->getUserDetails($token);
            $sessionToken->set('user', serialize($this->details));
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

    private function authorize(Server $server, Session $session): void
    {
        $sessionToken = $this->session->getSegment('token');
        $temporaryCredentialsSerialized = $sessionToken->get('temporary_credentials');
        if ($temporaryCredentialsSerialized === null) {
            $temporaryCredentialsSerialized = serialize($this->server->getTemporaryCredentials());
            $this->session->getSegment('token')->set('temporary_credentials', $temporaryCredentialsSerialized);
        }
        $this->server->authorize(unserialize($temporaryCredentialsSerialized));
    }
}