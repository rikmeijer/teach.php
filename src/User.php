<?php

namespace rikmeijer\Teach;

use Aura\Session\Session;
use pulledbits\Bootstrap\Bootstrap;

final class User
{
    /**
     * @var Session
     */
    private $session;
    private $oauth;
    private $schema;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->session = $bootstrap->resource('session');
        $this->schema = $bootstrap->resource('database');
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
        $icalReader = new \ICal('http://rooster.avans.nl/gcal/D' . $userId);
        $count = 0;
        foreach ($icalReader->events() as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            }
            if (array_key_exists('LOCATION', $event) === false) {
                continue;
            }
            $this->schema->executeProcedure(
                'import_ical_to_contactmoment',
                [
                    $userId,
                    $event['SUMMARY'],
                    $event['UID'],
                    $this->convertToSQLDateTime($event['DTSTART']),
                    $this->convertToSQLDateTime($event['DTEND']),
                    $event['LOCATION']
                ]
            );
            $count++;
        }
        $this->schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);

        return $count;
    }

    private function convertToSQLDateTime(string $icaldatetime): string
    {
        try {
            $datetime = new \DateTime($icaldatetime);
            $datetime->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
            return $datetime->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
}
