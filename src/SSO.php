<?php namespace rikmeijer\Teach;

class SSO
{
    private $sessionToken;
    private $oauth;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->oauth = $bootstrap->resource('oauth');
        $this->sessionToken = $bootstrap->resource('session')->getSegment('token');
    }

    private function getUserDetails(): \League\OAuth1\Client\Server\User
    {
        $details = unserialize($this->sessionToken->get('user'));
        if (!($details instanceof \League\OAuth1\Client\Server\User)) {
            $tokenCredentialsSerialized = $this->sessionToken->get('credentials');
            if ($tokenCredentialsSerialized === null) {
                header('Location: /sso/authorize', true, 302);
                exit;
            }
            $token = unserialize($tokenCredentialsSerialized);

            $details = $this->oauth->getUserDetails($token);
            $this->sessionToken->set('user', serialize($details));
        }
        return $details;
    }

    public function __get($name)
    {
        return $this->getUserDetails()->$name;
    }

    public function __set($name, $value)
    {
        trigger_error('Can not write SSO', E_USER_ERROR);
    }
    public function __isset($name)
    {
        $details = $this->getUserDetails();
        return isset($details->$name);
    }
}
