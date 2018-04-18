<?php

namespace rikmeijer\Teach;

use Aura\Session\Segment;
use pulledbits\ActiveRecord\Record;
use pulledbits\ActiveRecord\Schema;

class User
{
    private $server;
    private $sessionToken;
    private $schema;
    private $publicAssetsFileSystem;

    public function __construct(\Avans\OAuth\Web $server, Segment $sessionToken, Schema $schema, \League\Flysystem\FilesystemInterface $publicAssetsFileSystem)
    {
        $this->server = $server;
        $this->sessionToken = $sessionToken;
        $this->schema = $schema;
        $this->publicAssetsFileSystem = $publicAssetsFileSystem;
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
            $this->sessionToken->set('user', serialize($details));
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

    public function retrieveModules() : array
    {
        $modules = [];
        foreach ($this->schema->read('module', [], []) as $module) {
            $modulecontactmomenten = $this->schema->read("contactmoment_module", [], ["module_id" => $module->id, "owner" => $this->details()->uid]);
            if (count($modulecontactmomenten) > 0) {
                $module->contains(['contactmomenten' => $modulecontactmomenten]);
                $modules[] = $module;
            }
        }
        return $modules;
    }

    public function retrieveModulecontactmomentenToday()
    {
        return $this->schema->read('contactmoment_vandaag', [], ["owner" => $this->details()->uid]);
    }

    public function retrieveContactmoment($contactmomentIdentifier) : Record
    {
        $contactmoments = $this->schema->read('contactmoment', [], ['id' => $contactmomentIdentifier, "owner" => $this->details()->uid]);
        if (count($contactmoments) === 0) {
            return new class implements Record {

                public function contains(array $values)
                {}

                public function __get($property)
                {
                    return null;
                }

                public function __set($property, $value)
                {}

                public function delete(): int
                {
                    return 0;
                }

                public function create(): int
                {
                    return 0;
                }

                public function __call(string $method, array $arguments)
                {
                    return null;
                }
            };
        }

        $schema = $this->schema;
        $contactmoments[0]->bind('rate', function(string $ipAddress, string $rating, string $explanation) use ($schema) {
            $schema->executeProcedure('rate_contactmoment', [$this->__get('id'), $ipAddress, $rating, $explanation]);
        });

        return $contactmoments[0];
    }

    public function importCalendarEvents()
    {
        $userId = $this->details()->uid;
        $icalReader = new \ICal('http://rooster.avans.nl/gcal/D' . $this->details()->uid);
        foreach ($icalReader->events() as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            } elseif (array_key_exists('LOCATION', $event) === false) {
                continue;
            }
            $this->schema->executeProcedure('import_ical_to_contactmoment', [$userId, $event['SUMMARY'], $event['UID'], $this->convertToSQLDateTime($event['DTSTART']), $this->convertToSQLDateTime($event['DTEND']), $event['LOCATION']]);
        }
        $this->schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);
    }

    private function convertToSQLDateTime(string $datetime): string
    {
        $datetime = new \DateTime($datetime);
        $datetime->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
        return $datetime->format('Y-m-d H:i:s');
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

    public function acquireTemporaryCredentials() : void
    {
        $temporaryCredentials = $this->server->getTemporaryCredentials();
        $this->sessionToken->set('temporary_credentials', serialize($temporaryCredentials));
        $this->server->authorize($temporaryCredentials);
    }

    public function logout() : void
    {
        if ($this->session->isStarted()) {
            $this->session->getSegment('token')->clear();
            $this->session->clear();
            $this->session->destroy();
        }
    }

    public function retrieveContactmomentRating($contactmomentIdentifier)
    {
        $contactmomentratings = $this->schema->read('contactmomentrating', [], ['contactmoment_id' => $contactmomentIdentifier]);
        if (count($contactmomentratings) === 0) {
            return 0;
        } elseif ($contactmomentratings[0]->waarde === null) {
            return 0;
        }
        return $contactmomentratings[0]->waarde;
    }

    public function readPublicAsset(string $path)
    {
        return $this->publicAssetsFileSystem->read($path);
    }

}