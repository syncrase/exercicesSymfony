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
        if (strpos($start, ',') !== false) {
            // Dans le cas où la valeur vient de la base de données
            $array = explode(',', $start);
        } else {
            // Dans le cas où l'on vient du formulaire mais que l'on a renseigné que l'année
            $array[] = $start;
        }

        if (count($array) === 3) {
            $this->start = 'new Date(' . $array[0] . ',' . $array[1] . ',' . $array[2] . ')';
            $this->startYear = $array[0];
            $this->startMonth = $array[1];
            $this->startDay = $array[2];
        } elseif (count($array) === 1) {
            $this->start = 'new Date(' . $array[0] . ',00,00)';
            $this->startYear = $array[0];
            $this->startMonth = '00';
            $this->startDay = '00';
        } else {
            //throw exception
        }
    }

    private $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay;
    private $end;

    public function getEnd() {
        return $this->end;
    }

    public function setEnd($end) {
        if (null === $end) {
            $this->end = '';
        } else {
            if (strpos($end, ',') !== false) {
                // Dans le cas où la valeur vient de la base de données
                $array = explode(',', $end);
            } else {
                // Dans le cas où l'on vient du formulaire mais que l'on a renseigné que l'année
                $array[] = $end;
            }

            if (count($array) === 3) {
                $this->end = 'new Date(' . $array[0] . ',' . $array[1] . ',' . $array[2] . ')';
                $this->endYear = $array[0];
                $this->endtMonth = $array[1];
                $this->endDay = $array[2];
            } elseif (count($array) === 1) {
                $this->end = 'new Date(' . $array[0] . ',00,00)';
                $this->endYear = $array[0];
                $this->endtMonth = '00';
                $this->endDay = '00';
            } else {
                //throw exception
            }
        }
    }

    public function getDataSet() {
        //        Retourne une information de type
        //        [{id: 1, content: 'Platon', start: new Date(-428,00,00), end:new Date(-348,00,00)},
        //        {id: 2, content: '1ère guerre mondiale', start: new Date(1914,07,28), end:new Date(1918,11,11)},
        //        {id: 3, content: '2nde guerre mondiale', start: new Date(1939,09,01), end:new Date(1945,09,02)},
        //        {id: 4, content: 'déclaration Balfour', start: new Date(1917,11,2)}] 
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
        // Decrement because JS Date index for january is 0
        $startMonth = $ev->getStartMonth() !== null ? $this->decrementMonth($ev->getStartMonth()) : '00';
        $startDay = $ev->getStartDay() !== null ? $ev->getStartDay() : '01';

        $this->setStart($ev->getStartYear() . ',' . $startMonth . ',' . $startDay);

        // End date
        $endMonth = $ev->getEndMonth() !== null ? $this->decrementMonth($ev->getEndMonth()) : '00';
        $endDay = $ev->getEndDay() !== null ? $ev->getEndDay() : '01';
        $this->setEnd($ev->hasEnd() ? $ev->getEndYear() . ',' . $endMonth . ',' . $endDay : null);


        // Table de vérité 1 si la date existait et 0 si null
        // => permet de remettre à null quand = 0
        // year         month               day		result
        // 0		0		0		0 <- uniquement si pas de fin
        // 0		0		1		1 <- day only code
        // 0		1		0		2 <- month only code
        // 0		1		1		3 <- impossible (signifie mois et jour d'une année inconnue)
        // 1		0		0		4 <- year only code
        // 1		0		1		5 <- impossible (signifie année et jour d'un mois inconnue)
        // 1		1		0		6 <- signifie année et mois mais jour inconnu
        // 1		1		1		7 <- signifie date complète: année, mois & jour connus
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

    private function decrementMonth($month) {
        $intValue = intval($month);
        $decrementedMonth = ($intValue >= 1 && $intValue <= 12) ? $intValue - 1 : 0;
        return (string) $decrementedMonth;
    }

}
