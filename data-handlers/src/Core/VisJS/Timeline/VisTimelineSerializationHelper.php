<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Core\VisJS\Timeline;

use App\Document\TimelineItem;

/**
 * Constructed in order to keep the vis.js dataset values.
 * Provide methods to get data in shape 
 * 
 *
 * @author Pierre
 */
class VisTimelineSerializationHelper {

    private $timelineItem;
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

    /**
     * 
     * @param string $end représente une date formatée comme suit -000429-12-30T23:00:00.000Z
     */
    public function setStart($start) {
        $this->start = $start;
    }

    private $end;

    public function getEnd() {
        return $this->end;
    }

    /**
     * 
     * @param string $end représente une date formatée comme suit -000429-12-30T23:00:00.000Z
     */
    public function setEnd($end) {
        $this->end = $end;
    }

    public function initTimelineItem() {
        $this->timelineItem = new TimelineItem();

        $this->timelineItem->setContent($this->content);

        // Match dates like
        //Fri Dec 31 -0429 00:00:00 GMT+0100 (Paris, Madrid)
        //Fri Aug 28 1914 00:00:00 GMT+0200
        //Sun Oct 01 1939 00:00:00 GMT+0200
        //Sun Dec 02 1917 00:00:00 GMT+0100 (Paris, Madrid)
        // 0:weekDay 1:month 2:day 3:year
        if (preg_match('/^\w{3} \w{3} \d{2} -?\d{1,6} \d{2}:\d{2}:\d{2} GMT\+0(100 \(Paris, Madrid\)|200)$/', $this->start) === 1) {
            $start = explode(' ', $this->start);
            $this->timelineItem->setStartYear($start[3]);
            // $this->decrementMonth($this->convertMonthAsNumber($start[1]))
            $this->timelineItem->setStartMonth($this->convertMonthAsNumber($start[1]));
            $this->timelineItem->setStartDay($start[2]);
        }

        if (preg_match('/^\w{3} \w{3} \d{2} -?\d{1,6} \d{2}:\d{2}:\d{2} GMT\+0(100 \(Paris, Madrid\)|200)$/', $this->end) === 1) {
            $end = explode(' ', $this->end);
            $this->timelineItem->setEndYear($end[3]);
            // $this->decrementMonth($this->convertMonthAsNumber($end[1]))
            $this->timelineItem->setEndMonth($this->convertMonthAsNumber($end[1]));
            $this->timelineItem->setEndDay($end[2]);
        }
    }

    public function getTimelineItem() {
        return $this->timelineItem;
    }

    private function convertMonthAsNumber($monthWithLetters) {
        switch ($monthWithLetters) {
            case 'Jan':
                return '01';
            case 'Feb':
                return '02';
            case 'Mar':
                return '03';
            case 'Apr':
                return '04';
            case 'May':
                return '05';
            case 'Jun':
                return '06';
            case 'Jul':
                return '07';
            case 'Aug':
                return '08';
            case 'Sep':
                return '09';
            case 'Oct':
                return '10';
            case 'Nov':
                return '11';
            case 'Dec':
                return '12';
            default:
                return'00';
        }
    }

    private function incrementMonth($month) {
        $intValue = intval($month);
        $intValue = ($intValue >= 1 && $intValue <= 12) ? $intValue + 1 : null;
        return (string) $intValue;
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
            // Should never append!!!
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
