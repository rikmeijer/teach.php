<?php
namespace Teach\Entities;

class Factory
{

    /**
     *
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function query($sql)
    {
        return $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createContactmoment($identifier)
    {
        return new Contactmoment($this, $identifier);
    }

    public function getMedia($les_id)
    {
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

    private function getActiviteitDummy()
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
            while ($thema = $activiteitQueryResult->fetch(\PDO::FETCH_ASSOC)) {
                $kern[$thema["leerdoel"]] = [
                    "Ervaren" => $this->getActiviteit($thema["ervaren_id"]),
                    "Reflecteren" => $this->getActiviteit($thema["reflecteren_id"]),
                    "Conceptualiseren" => $this->getActiviteit($thema["conceptualiseren_id"]),
                    "Toepassen" => $this->getActiviteit($thema["toepassen_id"])
                ];
            }
        }
        return $kern;
    }
}