<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Core\VisJS\Timeline;

use App\Document\TimelineItem;

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

    private $timelineItem;

    public function initTimelineItem() {
        $this->timelineItem = new TimelineItem();
        $this->timelineItem->setContent($this->content);

        $isBC = $this->start[0] === '-';
        // documentation http://php.net/ltrim
        $this->start = ltrim($this->start, '-');
        $start = explode('-', $this->start);
        $this->timelineItem->setStartYear(($isBC ? '-' : '') . $start[0]);
        $this->timelineItem->setStartMonth($start[1]);
        $this->timelineItem->setStartDay($start[2]);

        if ($this->end !== null) {
            $isBC = $this->end[0] === '-';
            // documentation http://php.net/ltrim
            $this->end = ltrim($this->end, '-');
            $end = explode('-', $this->end);
            $this->timelineItem->setEndYear(($isBC ? '-' : '') . $end[0]);
            $this->timelineItem->setEndMonth($end[1]);
            $this->timelineItem->setEndDay($end[2]);
        }
    }

    public function getTimelineItem() {
        return $this->timelineItem;
    }

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
