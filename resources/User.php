<?php

namespace rikmeijer\Teach;

use Aura\Session\Segment;
use pulledbits\ActiveRecord\Schema;

class User
{
    private $server;
    private $sessionToken;
    private $schema;

    public function __construct(\Avans\OAuth\Web $server, Segment $sessionToken, Schema $schema)
    {
        $this->server = $server;
        $this->sessionToken = $sessionToken;
        $this->schema = $schema;
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

    public function retrieveCalendarEvents() {
        $icalReader = new \ICal('http://rooster.avans.nl/gcal/D' . $this->details()->uid);
        $events = [];
        foreach ($icalReader->events() as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            } elseif (array_key_exists('LOCATION', $event) === false) {
                continue;
            }
            $event['USERID'] = $this->details()->uid;
            $events[] = $event;
        }
        return $events;
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
}