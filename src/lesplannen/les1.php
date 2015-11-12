<?php
return function (\mysqli $database) {
    
    function query($database, $sql)
    {
        $queryResult = $database->query($sql);
        if ($queryResult === false) {
            trigger_error($database->error, E_USER_ERROR);
        }
        return $queryResult;
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
        ")->fetch_assoc();

        $activiteit['inhoud'] = explode(chr(10), $activiteit['inhoud']);
        $activiteit['intelligenties'] = explode(',', $activiteit['intelligenties']);
        return $activiteit;
    }
    
    function getKern($database, $les_id) {
        $activiteitQueryResult = query($database, "
            SELECT 
                thema.leerdoel,
                thema.ervaren_id,
                thema.reflecteren_id,
                thema.conceptualiseren_id,
                thema.toepassen_id
            FROM thema
            WHERE 
                thema.les_id = " . $les_id . "
        ");
        $kern = [];
        while ($thema = $activiteitQueryResult->fetch_assoc()) {
            $kern[$thema["leerdoel"]] = [
                "Ervaren" => getActiviteit($database, $thema["ervaren_id"]),
                "Reflecteren" => getActiviteit($database, $thema["reflecteren_id"]),
                "Conceptualiseren" => getActiviteit($database, $thema["conceptualiseren_id"]),
                "Toepassen" => getActiviteit($database, $thema["toepassen_id"])
            ];
        }
        return $kern;
        
    }
    
    /** @var $lesplanQueryResult mysqli_result */
    $lesplan = query($database, "
        SELECT 
            les.naam AS les,
            module.naam AS vak,
            contactmoment.starttijd AS starttijd,
            contactmoment.eindtijd AS eindtijd,
            SUM(activiteit.tijd) + (
                SELECT SUM(activiteit.tijd) 
                FROM thema 
                LEFT JOIN activiteit ON activiteit.id IN (
                    thema.ervaren_id,
                    thema.reflecteren_id,
                    thema.conceptualiseren_id,
                    thema.toepassen_id
                )
                WHERE thema.les_id = les.id
            ) as duur,
            TIMESTAMPDIFF(MINUTE, contactmoment.starttijd, contactmoment.eindtijd) as beschikbaar,
            contactmoment.ruimte,
            les.activerende_opening_id,
            les.focus_id,
            les.voorstellen_id,
            les.kennismaken_id,
            les.terugblik_id,
            les.huiswerk_id,
            les.evaluatie_id,
            les.pakkend_slot_id
        FROM contactmoment
        JOIN les ON les.id = contactmoment.les_id
        JOIN module ON module.id = les.module_id
        
        LEFT JOIN activiteit ON activiteit.id IN (
            les.activerende_opening_id,
            les.focus_id,
            les.voorstellen_id,
            les.kennismaken_id,
            les.terugblik_id,
            les.huiswerk_id,
            les.evaluatie_id,
            les.pakkend_slot_id
        )
        WHERE 
            contactmoment.id = 1
        GROUP BY
            contactmoment.id
    ")->fetch_assoc();
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
            'duur' => $lesplan['duur'],
            'ruimte' => $lesplan['ruimte'],
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
        'Kern' => getKern($database, 1),
        'Afsluiting' => [
            "Huiswerk" => getActiviteit($database, $lesplan['huiswerk_id']),
            "Evaluatie" => getActiviteit($database, $lesplan['evaluatie_id']),
            "Pakkend slot" => getActiviteit($database, $lesplan['pakkend_slot_id'])
        ]
    ];
};