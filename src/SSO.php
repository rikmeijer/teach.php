<?php namespace rikmeijer\Teach;

class SSO
{
    private $sessionToken;
    private $server;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->server = $bootstrap->resource('oauth');
        $this->sessionToken = $bootstrap->resource('session')->getSegment('token');
    }

    public function getUserDetails(): \League\OAuth1\Client\Server\User
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
