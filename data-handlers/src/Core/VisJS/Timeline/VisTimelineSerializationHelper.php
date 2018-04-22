<?php

namespace App\Core\VisJS\Timeline;

use App\Document\TimelineItem;
use App\Core\VisJS\Timeline\Date;

/**
 * Les attributs de cet objets sont dédiés à reçevoir les valeurs du JSON 
 * représentant la timeline puis à les mettre en forme avant la persistence
 * Provide methods to get data in shape 
 * 
 *
 * @author Pierre
 */
class VisTimelineSerializationHelper {

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

    private $notes;

    public function getNotes() {
        return $this->notes;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
    }

    private $timelineItem;

    /**
     * Reconstruit un objet TimelineItem à partir des données reçues de la UI
     */
    public function initTimelineItem() {
        $this->timelineItem = new TimelineItem();
        $this->timelineItem->setContent($this->content);

        $startDate = new Date($this->start);
        $this->timelineItem->setStartYear($startDate->getYear());
        $this->timelineItem->setStartMonth($startDate->getMonth());
        $this->timelineItem->setStartDay($startDate->getDay());

        if ($this->end !== null) {
            $endDate = new Date($this->end);
            $this->timelineItem->setEndYear($endDate->getYear());
            $this->timelineItem->setEndMonth($endDate->getMonth());
            $this->timelineItem->setEndDay($endDate->getDay());
        }
        if ($this->notes !== null) {
            $this->timelineItem->setNotes($this->notes);
        }
    }

    public function getTimelineItem() {
        return $this->timelineItem;
    }

    /**
     * Les valeurs par défault sont mises à null
     * @param ['start' => number, 'end' => number] Tableau associatif contenant 
     * les codes permetttant de savoir quel valeurs de la date ont été mises 
     * aux valeurs par défault
     */
    public function unadapt($visFriendlyCodes) {
        // Start date
        $startCode = $visFriendlyCodes['start'];
        if ($startCode >= 4) {
            // L'année n'est pas null
            $startCode -= 4;
        } else {
            // Should never append!!!
            // Here, an exception have to be thrown
            $this->timelineItem->setStartYear(null);
        }
        if ($startCode >= 2) {
            // Le mois n'est pas null
            $startCode -= 2;
        } else {
            $this->timelineItem->setStartMonth(null);
        }
        if ($startCode >= 1) {
            // Le mois n'est pas null
            $startCode -= 1;
        } else {
            $this->timelineItem->setStartDay(null);
        }
        // End date
        $endCode = $visFriendlyCodes['end'];
        if ($endCode >= 4) {
            // L'année n'est pas null
            $endCode -= 4;
        } else {
            // Here, an exception have to be thrown
            $this->timelineItem->setEndYear(null);
        }
        if ($endCode >= 2) {
            // Le mois n'est pas null
            $endCode -= 2;
        } else {
            $this->timelineItem->setEndMonth(null);
        }
        if ($endCode >= 1) {
            // Le mois n'est pas null
            $endCode -= 1;
        } else {
            $this->timelineItem->setEndDay(null);
        }
    }

}
