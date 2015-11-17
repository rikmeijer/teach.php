<?php
return function (\mysqli $database) {
    function getMedia($database, $les_id) {
        $mediaQueryResult = $database->query("
            SELECT DISTINCT media.omschrijving
            FROM les
            LEFT JOIN thema ON thema.les_id = les.id
            LEFT JOIN activiteit ON activiteit.id IN (
                les.activerende_opening_id,
                les.focus_id,
                les.voorstellen_id,
                les.kennismaken_id,
                les.terugblik_id,
                les.huiswerk_id,
                les.evaluatie_id,
                les.pakkend_slot_id,
                thema.ervaren_id,
                thema.reflecteren_id,
                thema.conceptualiseren_id,
                thema.toepassen_id
            )
            JOIN activiteitmedia ON activiteitmedia.activiteit_id = activiteit.id
            JOIN media ON media.id = activiteitmedia.media_id
            WHERE
                les.id = " . $les_id . "
        ");
        
        $media = [];
        if ($mediaQueryResult !== false) {
            while ($mediaItem = $mediaQueryResult->fetch_assoc()) {
                $media[] = $mediaItem['omschrijving'];
            }
        }
        return $media;
    }
    
    function getActiviteitDummy() {
        return [
            "inhoud" => "",
            "werkvorm" => "onbekend",
            "organisatievorm" => "nvt",
            "werkvormsoort" => "onbekend",
            "tijd" => "0",
            "intelligenties" => ""
        ];
    }
    
    function getActiviteit($database, $id) {
        $activiteitQueryResult = $database->query("
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

        if ($activiteitQueryResult !== false) {
            $activiteit = $activiteitQueryResult->fetch_assoc();
        } else {
            return getActiviteitDummy();
        }
        
        $activiteit['inhoud'] = explode(chr(10), $activiteit['inhoud']);
        $activiteit['intelligenties'] = explode(',', $activiteit['intelligenties']);
        return $activiteit;
    }
    
    function getKern($database, $les_id) {
        $activiteitQueryResult = $database->query("
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
        if ($activiteitQueryResult !== false) {
            while ($thema = $activiteitQueryResult->fetch_assoc()) {
                $kern[$thema["leerdoel"]] = [
                    "Ervaren" => getActiviteit($database, $thema["ervaren_id"]),
                    "Reflecteren" => getActiviteit($database, $thema["reflecteren_id"]),
                    "Conceptualiseren" => getActiviteit($database, $thema["conceptualiseren_id"]),
                    "Toepassen" => getActiviteit($database, $thema["toepassen_id"])
                ];
            }
        }
        return $kern;
        
    }
    
    function getContactmomentDummy() {
        return [
        'opleiding' => 'HBO-informatica (voltijd)', // <!-- del>deeltijd</del>/-->
        'vak' => "onbekend",
        'les' => "onbekend",
        'Beginsituatie' => [
            'doelgroep' => [
                'beschrijving' => "onbekend",
                'ervaring' => "onbekend",
                'grootte' => "onbekend"
            ],
            'starttijd' => "onbekend",
            'eindtijd' => "onbekend",
            'duur' => "onbekend",
            'ruimte' => "onbekend",
            'overige' => "onbekend"
        ],
        'media' => [],
        'Introductie' => [
            "Activerende opening" => getActiviteitDummy(),
            "Focus" => getActiviteitDummy(),
            "Voorstellen" => getActiviteitDummy(),
        ],
        'Kern' => [],
        'Afsluiting' => [
            "Huiswerk" => getActiviteitDummy(),
            "Evaluatie" => getActiviteitDummy(),
            "Pakkend slot" => getActiviteitDummy()
        ]
        ];
    }
    
    /** @var $contactmomentQueryResult mysqli_result */
    $contactmomentQueryResult = $database->query("
        SELECT 
            les.id AS lesplan_id,
            les.naam AS les,
            module.naam AS vak,
            doelgroep.grootte AS doelgroep_grootte,
            doelgroep.ervaring AS doelgroep_ervaring,
            doelgroep.beschrijving AS doelgroep_beschrijving,
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
            les.opmerkingen,
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
        JOIN doelgroep ON doelgroep.id = les.doelgroep_id
        
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
    ");
    
    
    if ($contactmomentQueryResult === false) {
        return getContactmomentDummy();
    } else {
        $contactmoment = $contactmomentQueryResult->fetch_assoc();
        if ($contactmoment === null) {
            return getContactmomentDummy();
        }
    }
    
    return [
        'opleiding' => 'HBO-informatica (voltijd)', // <!-- del>deeltijd</del>/-->
        'vak' => $contactmoment['vak'],
        'les' => $contactmoment['les'],
        'Beginsituatie' => [
            'doelgroep' => [
                'beschrijving' => $contactmoment['doelgroep_beschrijving'],
                'ervaring' => $contactmoment['doelgroep_ervaring'],
                'grootte' => $contactmoment['doelgroep_grootte'] . ' personen'
            ],
            'starttijd' => date('H:i', strtotime($contactmoment['starttijd'])),
            'eindtijd' => date('H:i', strtotime($contactmoment['eindtijd'])),
            'duur' => $contactmoment['duur'],
            'ruimte' => $contactmoment['ruimte'],
            'overige' => $contactmoment['opmerkingen']
        ],
        'media' => getMedia($database, $contactmoment['lesplan_id']),
        'Introductie' => [
            "Activerende opening" => getActiviteit($database, $contactmoment['activerende_opening_id']),
            "Focus" => getActiviteit($database, $contactmoment['focus_id']),
            "Voorstellen" => getActiviteit($database, $contactmoment['voorstellen_id']),
        ],
        'Kern' => getKern($database, 1),
        'Afsluiting' => [
            "Huiswerk" => getActiviteit($database, $contactmoment['huiswerk_id']),
            "Evaluatie" => getActiviteit($database, $contactmoment['evaluatie_id']),
            "Pakkend slot" => getActiviteit($database, $contactmoment['pakkend_slot_id'])
        ]
    ];
};