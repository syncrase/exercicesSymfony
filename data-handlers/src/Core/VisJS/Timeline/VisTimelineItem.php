<?php

namespace App\Core\VisJS\Timeline;

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

    public function getTimelineItem() {
        $timelineItem = new TimelineItem();

        $timelineItem->setContent($this->content);

        $timelineItem->setStartYear($this->startYear);
        $timelineItem->setStartMonth($this->startMonth);
        $timelineItem->setStartDay($this->startDay);

        $timelineItem->setEndYear($this->endYear);
        $timelineItem->setEndMonth($this->endMonth);
        $timelineItem->setEndDay($this->endDay);

        return $timelineItem;
    }

    public function initVisTimelineItem($ev) {
        $this->setContent($ev->getContent());
        // Start date
        // Quand il n'y a que l'année de disponible => placement de la date au 1er janvier
        $startMonth = $ev->getStartMonth() !== null ? $ev->getStartMonth() : '01';
        $startDay = $ev->getStartDay() !== null ? $ev->getStartDay() : '01';
        $this->setStart('\'' . $ev->getStartYear() . '-' . $startMonth . '-' . $startDay . '\'');

        // End date
        $endMonth = $ev->getEndMonth() !== null ? $ev->getEndMonth() : '01';
        $endDay = $ev->getEndDay() !== null ? $ev->getEndDay() : '01';
        $this->setEnd($ev->hasEnd() ? '\'' . $ev->getEndYear() . '-' . $endMonth . '-' . $endDay . '\'' : null);




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
     * @param type $ev
     * @return The associative array representative of which value was set to default value
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

    /**
     * @param type $month
     * @return type
     */
    private function decrementMonth($month) {
        $intValue = intval($month);
        $decrementedMonth = ($intValue >= 1 && $intValue <= 12) ? $intValue - 1 : 0;
        return (string) $decrementedMonth;
    }

}
