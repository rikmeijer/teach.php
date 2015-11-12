<?php
return function (\mysqli $database) {
    
    function query($database, $sql)
    {
        $queryResult = $database->query($sql);
        if ($queryResult === false) {
            trigger_error($database->error, E_USER_ERROR);
        }
        return $queryResult->fetch_assoc();
    }
    
    function getActiviteit($database, $id) {
        $activiteit = query($database, "
            SELECT 
                inhoud,
                werkvorm,
                organisatievorm,
                werkvormsoort,
                tijd,
                intelligenties
            FROM activiteit
            WHERE 
                id = " . $id . "
        ");

        $activiteit['inhoud'] = explode(chr(10), $activiteit['inhoud']);
        $activiteit['intelligenties'] = explode(',', $activiteit['intelligenties']);
        return $activiteit;
    }
    
    /** @var $lesplanQueryResult mysqli_result */
    $lesplan = query($database, "
        SELECT 
            les.naam AS les,
            module.naam AS vak,
            contactmoment.starttijd AS starttijd,
            contactmoment.eindtijd AS eindtijd,
            les.activerende_opening_id,
            les.focus_id,
            les.voorstellen_id,
            les.huiswerk_id,
            les.evaluatie_id,
            les.pakkend_slot_id
        FROM contactmoment
        JOIN les ON les.id = contactmoment.les_id
        JOIN module ON module.id = les.module_id
        WHERE 
            contactmoment.id = 1
    ");
    if ($lesplan === null) {
        return null;
    }
    
    return [
        'opleiding' => 'HBO-informatica (voltijd)', // <!-- del>deeltijd</del>/-->
        'vak' => $lesplan['vak'],
        'les' => $lesplan['les'],
        'Beginsituatie' => [
            'doelgroep' => [
                'beschrijving' => 'eerstejaars HBO-studenten',
                'ervaring' => 'geen', // <!-- del>veel</del>, <del>redelijk veel</del>, <del>weinig</del>, -->geen
                'grootte' => '16 personen'
            ],
            'starttijd' => date('H:i', strtotime($lesplan['starttijd'])),
            'eindtijd' => date('H:i', strtotime($lesplan['eindtijd'])),
            'duur' => '95',
            'ruimte' => 'beschikking over vaste computers',
            'overige' => 'nvt'
        ],
        'media' => [
            'filmfragment matrix',
            'countdown timer voor toepassingsfases (optioneel)',
            'voorbeeld IKEA-handleiding + uitgewerkte pseudo-code',
            'rode en groene briefjes/post-its voor feedback',
            'presentatie',
            'voorbeeldproject voor aanvullende feedback'
        ],
        'Introductie' => [
            "Activerende opening" => getActiviteit($database, $lesplan['activerende_opening_id']),
            "Focus" => getActiviteit($database, $lesplan['focus_id']),
            "Voorstellen" => getActiviteit($database, $lesplan['voorstellen_id']),
        ],
        'Kern' => [
            "Zelfstandig eclipse installeren" => [
                "Ervaren" => getActiviteit($database, 4),
                "Reflecteren" => getActiviteit($database, 5),
                "Conceptualiseren" => getActiviteit($database, 6),
                "Toepassen" => getActiviteit($database, 7)
            ],
            "Java-code lezen en uitleggen wat er gebeurt" => [
                "Ervaren" => getActiviteit($database, 8),
                "Reflecteren" => getActiviteit($database, 9),
                "Conceptualiseren" => getActiviteit($database, 10),
                "Toepassen" => getActiviteit($database, 11)
            ]
        ],
        'Afsluiting' => [
            "Huiswerk" => getActiviteit($database, $lesplan['huiswerk_id']),
            "Evaluatie" => getActiviteit($database, $lesplan['evaluatie_id']),
            "Pakkend slot" => getActiviteit($database, $lesplan['pakkend_slot_id'])
        ]
    ];
};