<?php

namespace App\Core\VisJS\Timeline;

/**
 * Les attributs de cet objets sont dédiés à reçevoir les valeurs persistées 
 * représentant la timeline puis à les mettre en forme avant l'affichage
 * 
 *
 * @author Pierre
 */
class VisTimelineItem {

    private $id;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    private $content;

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    private $start;

    public function getStart() {
        return $this->start;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    private $end;

    public function getEnd() {
        return $this->end;
    }

    public function setEnd($end) {
        $this->end = $end;
    }

    /**
     * 
     * @return string Element de la timeline alimentant la string reçue 
     * dans la UI
     */
    public function getDataSet() {
        //        Retourne une information de type
        //        [{id: 1, content: 'Platon', start: '-000428-00-00', end:'-000348-00-00'},
        //        {id: 2, content: '1ère guerre mondiale', start: '1914-07-28', end:'1918-11-11'},
        //        {id: 3, content: '2nde guerre mondiale', start: '1939-09-01', end:'1945-09-02'},
        //        {id: 4, content: 'déclaration Balfour', start: '1917-11-02'},
        //        {id: 5, content: 'Jésus Christ', start: '0000-01-01', end:'0033-01-01'}] 
        //        Cette information est censée être traitée par du Javascript
        $dataSet = '';
        $dataSet .= '{'
                . 'id: ' . $this->id
                . ', content: \'' . $this->content . '\''
                . ', start: ' . $this->start;
        if (null !== $this->end && '' !== $this->end) {
            $dataSet .= ', end:' . $this->end;
        }
        $dataSet .= '}';
        return $dataSet;
    }

    /**
     * Transforme un objet TimelineItem de manière à ce qu'il soit utilisable 
     * par vis.js. Dans cette méthode, les valeurs sont récupérées et 
     * transformées. Les valeurs qui sont null sont remplécées par les valeurs
     * par défault.
     * @param TimelineItem $ev
     * @return ['start' => number, 'end' => number] permet de mémoriser quelles 
     * valeurs parmis année, mois et jour ont été mise par défault
     */
    public function adapt($ev) {
        $this->setContent($ev->getContent());
        // Start date
        // Quand il n'y a que l'année de disponible => placement de la date au 1er janvier
        $this->setStart(
                '\'' . $ev->getStartYear() . '-' .
                ($ev->getStartMonth() !== null ? $ev->getStartMonth() : '01') . '-' .
                ($ev->getStartDay() !== null ? $ev->getStartDay() : '01') . '\''
        );

        // End date
        $this->setEnd(
                $ev->hasEnd() ?
                        '\'' .
                        $ev->getEndYear() . '-' .
                        ($ev->getEndMonth() !== null ? $ev->getEndMonth() : '01') . '-' .
                        ($ev->getEndDay() !== null ? $ev->getEndDay() : '01') . '\'' : null
        );

        return $this->computeDateAdaptationCode($ev);
    }

    /**
     * Table de vérité 1 si la date existait et 0 si null
     * => permet de remettre à null quand = 0
     * year         month               day		result
     * 0		0		0		0 <- uniquement si pas de fin
     * 0		0		1		1 <- day only code
     * 0		1		0		2 <- month only code
     * 0		1		1		3 <- impossible (signifie mois et jour d'une année inconnue)
     * 1		0		0		4 <- year only code
     * 1		0		1		5 <- impossible (signifie année et jour d'un mois inconnue)
     * 1		1		0		6 <- signifie année et mois mais jour inconnu
     * 1		1		1		7 <- signifie date complète: année, mois & jour connus
     * 
     * @param TimelineItem $ev
     * @return ['start' => number, 'end' => number] The associative array representative of which values was set to the default value.
     */
    private function computeDateAdaptationCode($ev) {
        $startDateCode = 4 + // there's always a start date
                ($ev->getStartMonth() !== null ? 2 : 0) +
                ($ev->getStartDay() !== null ? 1 : 0);
        $endDateCode = ($ev->getEndYear() !== null ? 4 : 0) + // there's always a start date
                ($ev->getEndMonth() !== null ? 2 : 0) +
                ($ev->getEndDay() !== null ? 1 : 0);
        return [
            'start' => $startDateCode,
            'end' => $endDateCode
        ];
    }

}
