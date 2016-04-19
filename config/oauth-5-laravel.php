<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		'Google' => [
			'client_id'     => '1021851546142-slskjoocj6uqhdkjs08dmi682m9rs7c8.apps.googleusercontent.com',
			'client_secret' => 'G1LXh005cVUqEqqG-OyWMHpy',
			'scope'         => [\OAuth\OAuth2\Service\Google::SCOPE_EMAIL],
		],

	]

];