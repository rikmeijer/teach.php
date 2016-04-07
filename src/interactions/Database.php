<?php
namespace Teach\Interactions;

final class Database {


    /**
     *
     * @var \PDO
     */
    private $pdo;
    
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    private function query($sql)
    {
        return $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBeginsituatie($identifier)
    {
        $contactmomenten = $this->query("
            SELECT
                'HBO-informatica (voltijd)' AS opleiding,
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
                contactmoment.id = " . $identifier . "
            GROUP BY
                contactmoment.id
        ");
        if (count($contactmomenten) > 0) {
            return $contactmomenten[0];
        }
        return [
            "opleiding" => 'HBO-informatica (voltijd)',
            "lesplan_id" => "onbekend",
            "les" => "onbekend",
            "vak" => "onbekend",
            "doelgroep_grootte" => "onbekend",
            "doelgroep_ervaring" => "onbekend",
            "doelgroep_beschrijving" => "onbekend",
            "starttijd" => "onbekend",
            "eindtijd" => "onbekend",
            "duur" => "onbekend",
            "beschikbaar" => "onbekend",
            "ruimte" => "onbekend",
            "opmerkingen" => "",
            "activerende_opening_id" => null,
            "focus_id" => null,
            "voorstellen_id" => null,
            "kennismaken_id" => null,
            "terugblik_id" => null,
            "huiswerk_id" => null,
            "evaluatie_id" => null,
            "pakkend_slot_id" => null
        ];
    }
    
    public function getLeerdoelen($les_id)
    {
        return array_keys($this->getKern($les_id));
    }
    
    public function getMedia($les_id)
    {
        if ($les_id === null) {
            return [];
        }
        $mediaQueryResult = $this->pdo->query("
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
            while ($mediaItem = $mediaQueryResult->fetch(\PDO::FETCH_ASSOC)) {
                $media[] = $mediaItem['omschrijving'];
            }
        }
        return $media;
    }
    
    public function getActiviteitDummy()
    {
        return [
            "inhoud" => "",
            "werkvorm" => "onbekend",
            "organisatievorm" => "nvt",
            "werkvormsoort" => "onbekend",
            "tijd" => "0",
            "intelligenties" => []
        ];
    }
    
    public function getActiviteit($id)
    {
        if ($id === null) {
            return $this->getActiviteitDummy();
        }
        $activiteitQueryResult = $this->pdo->query("
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
            $activiteit = $activiteitQueryResult->fetch(\PDO::FETCH_ASSOC);
        } else {
            return $this->getActiviteitDummy();
        }
    
        $activiteit['inhoud'] = explode(chr(10), $activiteit['inhoud']);
        $activiteit['intelligenties'] = explode(',', $activiteit['intelligenties']);
        return $activiteit;
    }
    
    public function getKern($les_id)
    {
        if ($les_id === null) {
            return [];
        }
        $activiteitQueryResult = $this->pdo->query("
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
            $themaCount = 0;
            while ($thema = $activiteitQueryResult->fetch(\PDO::FETCH_ASSOC)) {
                $kern[$thema["leerdoel"]] = new \Teach\Domain\Lesplan\Thema('Thema ' . (++ $themaCount) . ': ' . $thema["leerdoel"], new \Teach\Domain\Lesplan\Activiteit("Ervaren", $this->getActiviteit($thema["ervaren_id"])), new \Teach\Domain\Lesplan\Activiteit("Reflecteren", $this->getActiviteit($thema["reflecteren_id"])), new \Teach\Domain\Lesplan\Activiteit("Conceptualiseren", $this->getActiviteit($thema["conceptualiseren_id"])), new \Teach\Domain\Lesplan\Activiteit("Toepassen", $this->getActiviteit($thema["toepassen_id"])));
            }
        }
        return $kern;
    }
}